<?php

namespace WGTOTW\Services;

use \WGTOTW\Models as Models;

/**
 * Post service.
 */
class PostService extends BaseService
{
    /**
     * @var boolean     Whether to take soft-deletion into account.
     */
    private $softQuery = false;
    
    
    /**
     * Get a post by ID.
     *
     * @param int       $id         Post ID.
     * @param string    $type       Post type (pass null to return any type).
     *
     * @return Models\Post|null     Post model instance if found, null otherwise.
     */
    public function getById($id, $type = null)
    {
        if (is_null($type)) {
            $method = ($this->softQuery ? 'findSoft' : 'find');
            $post = $this->di->posts->$method(null, $id);
        } else {
            $method = ($this->softQuery ? 'getFirstSoft' : 'getFirst');
            $post = $this->di->posts->$method('id = ? AND type = ?', [$id, $type]);
        }
        $this->useSoft(false);
        return ($post ?: null);
    }
    
    
    /**
     * Get posts by author.
     *
     * @param Models\User   $user   User model instance.
     * @param string        $type   Post type (pass null to return all types).
     *
     * @return array                Array of post model instances.
     */
    public function getByAuthor($user, $type = null)
    {
        $method = ($this->softQuery ? 'getAllSoft' : 'getAll');
        if (!is_null($type)) {
            $posts = $this->di->posts->$method('userId = ? AND type = ?', [$user->id, $type]);
        } else {
            $posts = $this->di->posts->$method('userId = ?', [$user->id]);
        }
        $this->useSoft(false);
        return $posts;
    }
    
    
    /**
     * Get posts by type.
     *
     * @param string    $type   Post type (pass null to return all types).
     *
     * @return array            Array of post model instances.
     */
    public function getByType($type)
    {
        $method = ($this->softQuery ? 'getAllSoft' : 'getAll');
        $posts = $this->di->posts->$method('type = ?', [$type]);
        $this->useSoft(false);
        return $posts;
    }
    
    
    /**
     * Get posts by tag.
     *
     * @param Models\Tag    $tag    Tag model instance.
     *
     * @return array                Array of post model instances.
     */
    public function getByTag($tag)
    {
        $posts = $this->di->db->connect()
            ->select('p.*, u.username, u.email')
            ->from($this->di->posts->getCollectionName() . ' AS p')
            ->join('wgtotw_post_tag AS pt', 'p.id = pt.postId')
            ->leftJoin($this->di->users->getCollectionName() . ' AS u', 'p.userId = u.id')
            ->where('pt.tagId = ?' . ($this->softQuery ? ' AND p.deleted IS NULL AND u.deleted IS NULL' : ''))
            ->execute([$tag->id])
            ->fetchAllClass(Models\PostVM::class);
        $this->useSoft(false);
        return $posts;
    }
    
    
    /**
     * Get all posts.
     *
     * @param   string  $type   Post type.
     * @param   string  $order  Order by clause.
     *
     * @return array            Array of post model instances.
     */
    public function getAll($type = null, $order = null)
    {
        $method = ($this->softQuery ? 'getAllSoft' : 'getAll');
        if (!is_null($type)) {
            $posts = $this->di->posts->$method('type = ?', [$type], $order);
        } else {
            $posts = $this->di->posts->$method(null, [], $order);
        }
        $this->useSoft(false);
        return $posts;
    }
    
    
    /**
     * Get answers for question.
     *
     * @param Models\Question   $question   Question model instance.
     * @param string            $order      Order by clause.
     *
     * @return array                        Array of answer model instances.
     */
    public function getAnswers($question, $order = null)
    {
        $method = ($this->softQuery ? 'getAllSoft' : 'getAll');
        $questions = $this->di->posts->$method("type = 'answer' AND parentId = ?", [$question->id], $order);
        $this->useSoft(false);
        return $questions;
    }
    
    
    /**
     * Get comments for post.
     *
     * @param Models\Post   $post   Post model instance.
     *
     * @return array                Array of post model instances.
     */
    public function getComments($post)
    {
        $method = ($this->softQuery ? 'getAllSoft' : 'getAll');
        $posts = $this->di->posts->$method("type = 'comment' AND parentId = ?", [$post->id]);
        $this->useSoft(false);
        return $posts;
    }
    
    
    /**
     * Get user's vote for post.
     *
     * @param Models\Post   $post   Post model instance.
     * @param Models\User   $user   User model instance.
     * @param Models\Vote|null      Vote model instance, or null if no vote found.
     */
    public function getVote($post, $user)
    {
        return $this->di->votes->getFirst('postId = ? AND userId = ?', [$post->id, $user->id]);
    }
    
    
    /**
     * Register a vote on a post.
     *
     * @param Models\Post   $post   Post model instance.
     * @param Models\User   $user   User model instance.
     * @param int           $value  Vote value (positive = up, negative = down, 0 = cancel vote).
     *
     * @param boolean               True if the vote was cast/cancelled, false if the user has already cast a vote for the post.
     */
    public function registerVote($post, $user, $value)
    {
        $oldVote = $this->getVote($post, $user);
        if ($oldVote && $value === 0) {
            // cancel old vote
            $this->di->votes->delete($oldVote);
            $post->rank -= $oldVote->value;
            $this->di->posts->save($post);
            return true;
        } elseif (!$oldVote && $value !== 0) {
            // cast new vote or amend previous vote
            if ($oldVote) {
                $vote = $oldVote;
            } else {
                $vote = new Models\Vote();
                $vote->postId = $post->id;
                $vote->userId = $user->id;
            }
            
            $vote->value = $value;
            $this->di->votes->save($vote);
            $post->rank += $value;
            $this->di->posts->save($post);
            return true;
        }
        return false;
    }
    
    
    /**
     * Set the accepted answer to a question.
     *
     * @param Models\Question   $question   Question model instance.
     * @param Models\Answer     $answer     Answer model instance.
     */
    public function acceptAnswer($question, $answer)
    {
        // demote old accepted answer, if any
        $oldAnswer = $this->di->posts->getFirst("type = 'answer' AND parentId = ? AND status = '" . Models\Answer::ACCEPTED . "'", [$answer->parentId]);
        if ($oldAnswer) {
            $oldAnswer->status = null;
            $this->di->posts->save($oldAnswer);
        }
        
        // promote new accepted answer
        $answer->status = Models\Answer::ACCEPTED;
        $this->di->posts->save($answer);
        
        // mark corresponding question as answered
        $question->status = Models\Question::ANSWERED;
        $this->di->posts->save($question);
    }
    
    
    /**
     * Remove accepted status from an answer.
     *
     * @param Models\Question   $question   Question model instance.
     * @param Models\Answer     $answer     Answer model instance.
     */
    public function unacceptAnswer($question, $answer)
    {
        // demote old accepted answer
        $answer->status = null;
        $this->di->posts->save($answer);
        
        // mark corresponding question as unanswered
        $question->status = null;
        $this->di->posts->save($question);
    }
    
    
    /**
     * Create post from model-bound form.
     *
     * @param string                    $type   Post type.
     * @param \WGTOTW\Form\ModelForm    $form   Model-bound form.
     * @param Models\User               $user   Post author.
     *
     * @return bool                             True if the insert was performed, false if validation failed.
     */
    public function createFromForm($type, $form, $user)
    {
        $post = $form->populateModel();
        $form->validate();
        if ($form->isValid()) {
            $post->userId = $user->id;
            $post->type = $type;
            $post->rank = 0;
            $post->published = date('Y-m-d H:i:s');
            $this->di->posts->save($post);
            $this->updatePostTags($post, $form->getExtra('tagIds', []));
            return true;
        }
        return false;
    }
    
    
    /**
     * Update post from model-bound form.
     *
     * @param \WGTOTW\Form\ModelForm    $form       Model-bound form.
     * @param Models\Post               $oldPost    Model instance of existing post.
     * @param Models\User               $user       Post editor.
     *
     * @return bool                                 True if the update was performed, false if validation failed.
     */
    public function updateFromForm($form, $oldPost, $user)
    {
        $post = $form->populateModel();
        $post->id = $oldPost->id;
        $post->userId = $user->id;
        $post->parentId = $oldPost->parentId;
        $post->type = $oldPost->type;
        $post->rank = $oldPost->rank;
        $post->status = $oldPost->status;
        $post->published = $oldPost->published;
        
        $form->validate();
        if ($form->isValid()) {
            $post->updated = date('Y-m-d H:i:s');
            $this->di->posts->save($post);
            $this->updatePostTags($post, $form->getExtra('tagIds', []));
            return true;
        }
        return false;
    }
    
    
    /**
     * Delete a post.
     *
     * @param Models\Post   $post   Post model instance.
     */
    public function delete($post)
    {
        $this->di->posts->deleteSoft($post);
    }
    
    
    /**
     * Restore a deleted post.
     *
     * @param Models\Post   $post   Post model instance.
     */
    public function restore($post)
    {
        $this->di->posts->restoreSoft($post);
    }
    
    
    /**
     * Set whether to take soft-deletion into account for the next selection query.
     *
     * @param boolean   $state  True = on, false = off.
     *
     * @return self
     */
    public function useSoft($state = true)
    {
        $this->softQuery = $state;
        return $this;
    }
    
    
    /**
     * Update post/tag associations.
     *
     * @param Model\Post    $post   Post model instance.
     * @param array         $tagIds Array of tag IDs.
     */
    private function updatePostTags($post, $tagIds)
    {
        // remove old associations
        $this->di->db->connect()
            ->deleteFrom('wgtotw_post_tag', 'postId = ?')
            ->execute([$post->id]);
        
        // save new associations
        foreach ($tagIds as $tagId) {
            $this->di->db->connect()
                ->insert('wgtotw_post_tag', ['postId', 'tagId'])
                ->execute([$post->id, $tagId]);
        }
    }
}
