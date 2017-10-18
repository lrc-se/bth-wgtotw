<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Form\ModelForm as Form;
use \WGTOTW\Models as Models;

/**
 * Controller for default pages.
 */
class DefaultController extends BaseController
{
    /**
     * Start page.
     */
    public function index()
    {
        $questions = $this->di->post->useSoft()->getAll('question', 'published DESC');
        return $this->di->common->renderMain('start', [
            'questions' => $questions
        ], 'Start');
    }
}
