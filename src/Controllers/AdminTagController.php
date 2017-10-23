<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Models as Models;
use \WGTOTW\Form\ModelForm as Form;

/**
 * Controller for admin tag functions.
 */
class AdminTagController extends BaseController
{
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
                $this->di->common->redirectMessage('admin/tag', 'Taggen <strong>' . htmlspecialchars($form->getModel()->name) . '</strong> har skapats.');
            }
        }
        
        return $this->di->common->renderMain('tag/edit', [
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
                $this->di->common->redirectMessage('admin/tag', 'Taggen <strong>' . htmlspecialchars($form->getModel()->name) . '</strong> har uppdaterats.');
            }
        } else {
            $form = new Form('tag-form', $tag);
        }
        
        return $this->di->common->renderMain('tag/edit', [
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
                $this->di->common->redirectMessage('admin/tag', 'Taggen <strong>' . htmlspecialchars($tag->name) . '</strong> har tagits bort.');
            }
        }
        
        return $this->di->common->renderMain('admin/tag-delete', ['tag' => $tag], 'Ta bort tagg');
    }
}
