<?php

namespace WGTOTW\Services;

use \WGTOTW\Models as Models;

/**
 * Tag service.
 */
class TagService extends BaseService
{
    /**
     * Get a tag by ID.
     *
     * @param int           $id     Tag ID.
     *
     * @return Models\Tag|null      Tag model instance if found, null otherwise.
     */
    public function getById($id)
    {
        return ($this->di->tags->find(null, $id) ?: null);
    }
    
    
    /**
     * Get a tag by name.
     *
     * @param string        $name   Tag name.
     *
     * @return Models\Tag|null      Tag model instance if found, null otherwise.
     */
    public function getByName($name)
    {
        return ($this->di->tags->find('name', $name) ?: null);
    }
    
    
    /**
     * Get tags for a specific post.
     *
     * @param Models\Post   $post   Post model instance.
     *
     * @return array                Array of tag model instances.
     */
    public function getByPost($post)
    {
        return $this->di->db->connect()
            ->select('t.*')
            ->from($this->di->tags->getCollectionName() . ' AS t')
            ->join('wgtotw_post_tag AS pt', 't.id = pt.tagId')
            ->where('pt.postId = ?')
            ->execute([$post->id])
            ->fetchAllClass(Models\Tag::class);
    }
    
    
    /**
     * Create tag from model-bound form.
     *
     * @param \LRC\Form\ModelForm   $form       Model-bound form.
     *
     * @return bool                             True if the insert was performed, false if validation failed.
     */
    public function createFromForm($form)
    {
        $tag = $form->populateModel();
        if ($this->getByName($tag->name)) {
            $form->addError('name', 'Namnet är upptaget.');
        }
        
        $form->validate();
        if ($form->isValid()) {
            $tag->created = date('Y-m-d H:i:s');
            $this->di->tags->save($tag);
            return true;
        }
        return false;
    }
    
    
    /**
     * Update tag from model-bound form.
     *
     * @param \LRC\Form\ModelForm   $form       Model-bound form.
     * @param Models\Tag            $oldTag     Model instance of existing tag.
     *
     * @return bool                             True if the update was performed, false if validation failed.
     */
    public function updateFromForm($form, $oldTag)
    {
        $tag = $form->populateModel();
        $tag->id = $oldTag->id;
        $tag->created = $oldTag->created;
        if ($tag->name != $oldTag->name && $this->getByName($tag->name)) {
            $form->addError('name', 'Namnet är upptaget.');
        }
        
        $form->validate();
        if ($form->isValid()) {
            $tag->updated = date('Y-m-d H:i:s');
            $this->di->tags->save($tag);
            return true;
        }
        return false;
    }
    
    
    /**
     * Delete a tag.
     *
     * @param Models\Tag    $tag    Tag model instance.
     */
    public function delete($tag)
    {
        $this->di->tags->delete($tag);
    }
}
