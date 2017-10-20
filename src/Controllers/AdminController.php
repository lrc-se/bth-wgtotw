<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Models as Models;
use \WGTOTW\Form\ModelForm as Form;

/**
 * Controller for admin.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class AdminController extends BaseController
{
    /**
     * Admin start page.
     */
    public function index()
    {
        $this->di->common->verifyAdmin();
        return $this->di->common->renderMain('admin/index', [], 'Administration');
    }
    
    
    
    /**
     * Admin user list.
     */
    public function users()
    {
        $admin = $this->di->common->verifyAdmin();
        
        $status = $this->di->request->getGet('status');
        if ($status == 'active') {
            $users = $this->di->repository->users->getAllSoft();
            $total = $this->di->repository->users->count();
        } elseif ($status == 'inactive') {
            $users = $this->di->repository->users->getAll('deleted IS NOT NULL');
            $total = $this->di->repository->users->count();
        } else {
            $users = $this->di->repository->users->getAll();
            $total = count($users);
        }
        
        return $this->di->common->renderMain('admin/user-list', [
            'users' => $users,
            'admin' => $admin,
            'total' => $total,
            'status' => $status
        ], 'Administrera användare');
    }
    
    
    /**
     * Admin create user page/handler.
     */
    public function createUser()
    {
        $admin = $this->di->common->verifyAdmin();
        $form = new Form('user-form', Models\User::class);
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->user->createFromForm($form)) {
                $this->di->common->redirectMessage('admin/user', 'Användaren "' . htmlspecialchars($form->getModel()->username) . '" har skapats.');
            }
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $form->getModel(),
            'admin' => $admin,
            'update' => false,
            'form' => $form
        ], 'Skapa användare');
    }
    
    
    /**
     * Admin edit user page/handler.
     *
     * @param int $id   User ID.
     */
    public function updateUser($id)
    {
        $admin = $this->di->common->verifyAdmin();
        $user = $this->di->user->getById($id);
        if (!$user) {
            $this->di->common->redirectError('admin/user', "Kunde inte hitta användaren med ID $id.");
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            $form = new Form('user-form', Models\User::class);
            if ($this->di->user->updateFromForm($form, $user)) {
                $this->di->common->redirectMessage('admin/user', 'Användaren "' . htmlspecialchars($form->getModel()->username) . '" har uppdaterats.');
            }
        } else {
            $form = new Form('user-form', $user);
        }
        
        return $this->di->common->renderMain('user/form', [
            'user' => $form->getModel(),
            'admin' => $admin,
            'update' => true,
            'form' => $form
        ], 'Redigera användare');
    }
    
    
    /**
     * Admin delete user page/handler.
     *
     * @param int $id   User ID.
     */
    public function deleteUser($id)
    {
        $admin = $this->di->common->verifyAdmin();
        $user = $this->di->user->getById($id);
        if (!$user) {
            $this->di->common->redirectError('admin/user', "Kunde inte hitta användaren med ID $id.");
        }
        if ($user->id == $admin->id) {
            $this->di->common->redirectError('admin/user', 'Du kan inte ta bort din egen användare.');
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->request->getPost('action') == 'delete') {
                $this->di->user->delete($user);
                $this->di->common->redirectMessage('admin/user', 'Användaren "' . htmlspecialchars($user->username) . '" har tagits bort.');
            }
        }
        
        return $this->di->common->renderMain('admin/user-delete', ['user' => $user], 'Ta bort användare');
    }
    
    
    /**
     * Admin restore user handler.
     *
     * @param int $id   User ID.
     */
    public function restoreUser($id)
    {
        $this->di->common->verifyAdmin();
        $user = $this->di->user->getById($id);
        if (!$user) {
            $this->di->common->redirectError('admin/user', "Kunde inte hitta användaren med ID $id.");
        }
        
        if ($this->di->request->getPost('action') == 'restore') {
            $this->di->user->restore($user);
            $this->di->common->redirectMessage('admin/user', 'Användaren "' . htmlspecialchars($user->username) . '" har återställts.');
        }
        
        $this->di->common->redirect('admin/user');
    }
    
    
    
    /**
     * Admin tag list.
     */
    public function tags()
    {
        $this->di->common->verifyAdmin();
        $tags = $this->di->repository->tags->getAll();
        
        return $this->di->common->renderMain('admin/tag-list', [
            'tags' => $tags
        ], 'Administrera taggar');
    }
    
    
    /**
     * Admin create tag page/handler.
     */
    public function createTag()
    {
        $this->di->common->verifyAdmin();
        $form = new Form('tag-form', Models\Tag::class);
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->tag->createFromForm($form)) {
                $this->di->common->redirectMessage('admin/tag', 'Taggen "' . htmlspecialchars($form->getModel()->name) . '" har skapats.');
            }
        }
        
        return $this->di->common->renderMain('tag/form', [
            'tag' => $form->getModel(),
            'update' => false,
            'form' => $form
        ], 'Skapa tagg');
    }
    
    
    /**
     * Admin edit tag page/handler.
     *
     * @param int $id   Tag ID.
     */
    public function updateTag($id)
    {
        $this->di->common->verifyAdmin();
        $tag = $this->di->tag->getById($id);
        if (!$tag) {
            $this->di->common->redirectError('admin/tag', "Kunde inte hitta taggen med ID $id.");
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            $form = new Form('tag-form', Models\Tag::class);
            if ($this->di->tag->updateFromForm($form, $tag)) {
                $this->di->common->redirectMessage('admin/tag', 'Taggen "' . htmlspecialchars($form->getModel()->name) . '" har uppdaterats.');
            }
        } else {
            $form = new Form('tag-form', $tag);
        }
        
        return $this->di->common->renderMain('tag/form', [
            'tag' => $form->getModel(),
            'update' => true,
            'form' => $form
        ], 'Redigera tagg');
    }
    
    
    /**
     * Admin delete tag page/handler.
     *
     * @param int $id   Tag ID.
     */
    public function deleteTag($id)
    {
        $this->di->common->verifyAdmin();
        $tag = $this->di->tag->getById($id);
        if (!$tag) {
            $this->di->common->redirectError('admin/tag', "Kunde inte hitta taggen med ID $id.");
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->request->getPost('action') == 'delete') {
                $this->di->tag->delete($tag);
                $this->di->common->redirectMessage('admin/tag', 'Taggen "' . htmlspecialchars($tag->name) . '" har tagits bort.');
            }
        }
        
        return $this->di->common->renderMain('admin/tag-delete', ['tag' => $tag], 'Ta bort tagg');
    }
    
    
    
    /**
     * Admin question list.
     */
    public function questions()
    {
        $this->di->common->verifyAdmin();
        
        $status = $this->di->request->getGet('status');
        list($questions, $total) = $this->filterPosts($status, 'question');
        
        return $this->di->common->renderMain('admin/question-list', [
            'questions' => $questions,
            'total' => $total,
            'status' => $status
        ], 'Administrera frågor');
    }
    
    
    /**
     * Admin answer list.
     *
     * @param int   $questionId     Question ID.
     */
    public function answers($questionId)
    {
        $this->di->common->verifyAdmin();
        
        $question = $this->di->post->getById($questionId);
        if (!$question) {
            $this->di->common->redirectError('admin/question', "Kunde inte hitta frågan med ID $questionId.");
        }
        
        $status = $this->di->request->getGet('status');
        list($answers, $total) = $this->filterPosts($status, 'answer', $questionId);
        
        return $this->di->common->renderMain('admin/answer-list', [
            'question' => $question,
            'answers' => $answers,
            'total' => $total,
            'status' => $status
        ], 'Administrera svar');
    }
    
    
    /**
     * Admin comment list.
     *
     * @param int   $parentId   Parent post ID.
     */
    public function comments($parentId)
    {
        $this->di->common->verifyAdmin();
        
        $parent = $this->di->post->getById($parentId);
        if (!$parent) {
            $this->di->common->redirectError('admin/question', "Kunde inte hitta inlägget med ID $parentId.");
        }
        
        $status = $this->di->request->getGet('status');
        list($comments, $total) = $this->filterPosts($status, 'comment', $parentId);
        
        return $this->di->common->renderMain('admin/comment-list', [
            'parent' => $parent,
            'comments' => $comments,
            'total' => $total,
            'status' => $status
        ], 'Administrera kommentarer');
    }
    
    
    /**
     * Admin view post page.
     *
     * @param string    $type   Post type.
     * @param int       $id     Post ID.
     */
    public function viewPost($type, $id)
    {
        $this->di->common->verifyAdmin();
        $post = $this->di->post->getById($id, $type);
        if (!$post) {
            $this->di->common->redirectError('admin/question', "Kunde inte hitta inlägget med ID $id.");
        }
        
        switch ($type) {
            case 'question':
                return $this->di->common->renderMain('admin/post-view', [
                    'deleted' => ($post->deleted ? 'Denna fråga är borttagen' : false),
                    'view' => 'question/question',
                    'question' => $post,
                    'canComment' => false,
                    'return' => $this->getReturnUrl($post)
                ], 'Visa fråga');
            case 'answer':
                return $this->di->common->renderMain('admin/post-view', [
                    'deleted' => ($post->deleted ? 'Detta svar är borttaget' : false),
                    'view' => 'answer/answer',
                    'answer' => $post,
                    'canComment' => false,
                    'return' => $this->getReturnUrl($post)
                ], 'Visa svar');
            case 'comment':
                return $this->di->common->renderMain('admin/post-view', [
                    'deleted' => ($post->deleted ? 'Denna kommentar är borttagen' : false),
                    'view' => 'comment/comment',
                    'comment' => $post,
                    'post' => $this->di->post->getById($post->parentId),
                    'return' => $this->getReturnUrl($post)
                ], 'Visa kommentar');
        }
    }
    
    
    /**
     * Admin edit post page/handler.
     *
     * @param string    $type   Post type.
     * @param int       $id     Post ID.
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function updatePost($type, $id)
    {
        $this->di->common->verifyAdmin();
        $post = $this->di->post->getById($id, $type);
        if (!$post) {
            $this->di->common->redirectError('admin/question', "Kunde inte hitta inlägget med ID $id.");
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            switch ($type) {
                case 'question':
                    $model = Models\Question::class;
                    $msg = 'Frågan har uppdaterats.';
                    break;
                case 'answer':
                    $model = Models\Answer::class;
                    $msg = 'Svaret har uppdaterats.';
                    break;
                case 'comment':
                    $model = Models\Comment::class;
                    $msg = 'Kommentaren har uppdaterats.';
                    break;
            }
            $form = new Form("$type-form", $model);
            if ($this->di->post->updateFromForm($form, $post)) {
                $this->di->common->redirectMessage($this->getReturnUrl($post), $msg);
            }
        } else {
            $form = new Form("$type-form", $post);
        }
        
        switch ($type) {
            case 'question':
                return $this->di->common->renderMain('question/form', [
                    'question' => $form->getModel(),
                    'admin' => true,
                    'update' => true,
                    'form' => $form,
                    'tags' => $this->di->tag->getAll(),
                    'tagIds' => $this->di->tag->getIdsByPost($post)
                ], 'Redigera fråga');
            case 'answer':
                return $this->di->common->renderMain('answer/form', [
                    'answer' => $form->getModel(),
                    'admin' => true,
                    'update' => true,
                    'form' => $form,
                    'return' => $this->getReturnUrl($post)
                ], 'Redigera svar');
            case 'comment':
                return $this->di->common->renderMain('comment/form', [
                    'comment' => $form->getModel(),
                    'admin' => true,
                    'update' => true,
                    'form' => $form,
                    'return' => $this->getReturnUrl($post)
                ], 'Redigera kommentar');
        }
    }
    
    
    /**
     * Admin delete post page/handler.
     *
     * @param string    $type   Post type.
     * @param int       $id     Post ID.
     */
    public function deletePost($type, $id)
    {
        $this->di->common->verifyAdmin();
        $post = $this->di->post->getById($id, $type);
        if (!$post) {
            $this->di->common->redirectError('admin/question', "Kunde inte hitta inlägget med ID $id.");
        }
        
        switch ($type) {
            case 'question':
                $msg = 'Frågan har tagits bort.';
                $title = 'Ta bort fråga';
                break;
            case 'answer':
                $msg = 'Svaret har tagits bort.';
                $title = 'Ta bort svar';
                break;
            case 'comment':
                $msg = 'Kommentaren har tagits bort.';
                $title = 'Ta bort kommentar';
                break;
        }
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->request->getPost('action') == 'delete') {
                $this->di->post->delete($post);
                $this->di->common->redirectMessage($this->getReturnUrl($post), $msg);
            }
        }
        
        return $this->di->common->renderMain('admin/post-delete', [
            'post' => $post,
            'type' => $type,
            'return' => $this->getReturnUrl($post)
        ], $title);
    }
    
    
    /**
     * Admin restore post handler.
     *
     * @param string    $type   Post type.
     * @param int       $id     Post ID.
     */
    public function restorePost($type, $id)
    {
        $this->di->common->verifyAdmin();
        $post = $this->di->post->getById($id, $type);
        if (!$post) {
            $this->di->common->redirectError('admin/question', "Kunde inte hitta inlägget med ID $id.");
        }
        
        switch ($type) {
            case 'question':
                $msg = 'Frågan har tagits återställts.';
                break;
            case 'answer':
                $msg = 'Svaret har återställts.';
                break;
            case 'comment':
                $msg = 'Kommentaren har återställts.';
                break;
        }
        if ($this->di->request->getPost('action') == 'restore') {
            $this->di->post->restore($post);
            $this->di->common->redirectMessage($this->getReturnUrl($post), $msg);
        }
        
        $this->di->common->redirect($this->getReturnUrl($post));
    }
    
    
    /**
     * Get return URL for post.
     *
     * @param Models\Post   $post   Post model instance.
     *
     * @return string               Return URL.
     */
    private function getReturnUrl($post)
    {
        switch ($post->type) {
            case 'question':
                $return = 'admin/question';
                break;
            case 'answer':
                $return = 'admin/question/' . $post->parentId . '/answer';
                break;
            case 'comment':
                $parent = $this->di->post->getById($post->parentId);
                $return = 'admin/' . $parent->type . '/' . $parent->id . '/comment';
                break;
            default:
                $return = null;
        }
        return $return;
    }
    
    
    /**
     * Filter posts.
     *
     * @param string    $status     Post status.
     * @param string    $type       Post type.
     * @param int       $parentId   Parent post ID.
     *
     * @return array                Array of filtered posts and their total count.
     */
    private function filterPosts($status, $type, $parentId = null)
    {
        $status = $this->di->request->getGet('status');
        $where = ['type = ?'];
        $values = [$type];
        if (!is_null($parentId)) {
            $where[] = 'parentId = ?';
            $values[] = $parentId;
        }
        if ($status == 'active') {
            $posts = $this->di->repository->posts->getAllSoft(implode(' AND ', $where), $values);
            $total = $this->di->repository->posts->count(implode(' AND ', $where), $values);
        } elseif ($status == 'inactive') {
            $where[] = 'deleted IS NOT NULL';
            $posts = $this->di->repository->posts->getAll(implode(' AND ', $where), $values);
            $total = $this->di->repository->posts->count(implode(' AND ', $where), $values);
        } else {
            $posts = $this->di->repository->posts->getAll(implode(' AND ', $where), $values);
            $total = count($posts);
        }
        return [$posts, $total];
    }
}
