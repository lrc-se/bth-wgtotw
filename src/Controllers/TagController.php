<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Form\ModelForm as Form;
use \WGTOTW\Models as Models;

/**
 * Controller for tags.
 */
class TagController extends BaseController
{
    /**
     * Tag index.
     */
    public function index()
    {
        return $this->di->common->renderMain('tag/index', [
            'tags' => $this->di->tag->getAll()
        ], 'Taggar');
    }
    
    
    /**
     * Question index by tag.
     *
     * @param string    $name   Tag name.
     */
    public function questions($name)
    {
        $tag = $this->di->tag->getByName($name);
        if (!$tag) {
            $this->di->common->redirectError('tag', 'Kunde inte hitta taggen med namnet "' . htmlspecialchars($name) . '".');
        }
        
        return $this->di->common->renderMain('tag/questions', [
            'tag' => $tag,
            'questions' => $this->di->post->useSoft()->getByTag($tag, ['order' => 'published DESC'])
        ], htmlspecialchars($name));
    }
}
