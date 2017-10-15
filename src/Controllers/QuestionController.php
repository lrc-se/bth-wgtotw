<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Form\ModelForm as Form;
use \WGTOTW\Models as Models;

/**
 * Controller for questions.
 */
class QuestionController extends BaseController
{
    /**
     * Questions index.
     */
    public function index()
    {
        return $this->di->common->renderMain('question/index', [
            'questions' => $this->di->post->useSoft()->getByType('question')
        ], 'Frågor');
    }
    
    
    /**
     * View question page.
     *
     * @param int   $id     Question ID.
     */
    public function view($id)
    {
        $question = $this->di->post->useSoft()->getById($id, 'question');
        if (!$question) {
            $this->di->common->redirectError('question', "Kunde inte hitta frågan med ID $id.");
        }
        
        $tags = []; //$this->di->tag->getByPost($question);
        $comments = $this->di->post->getComments($question);
        $answers = $this->di->post->getAnswers($question);
        
        return $this->di->common->renderMain('question/view', [
            'user' => $this->di->user->getCurrent(),
            'question' => $question,
            'tags' => $tags,
            'comments' => $comments,
            'answers' => $answers
        ], htmlspecialchars($question->title));
    }
    
    
    /**
     * Write question page.
     */
    public function create()
    {
        $this->di->common->verifyUser();
        return $this->di->common->renderMain('question/form', [
            'admin' => null,
            'update' => false,
            'form' => new Form('question-form', Models\Question::class)
        ], 'Skriv ny fråga');
    }
    
    
    /**
     * Write question handler.
     */
    public function handleCreate()
    {
        $user = $this->di->common->verifyUser();
        $form = new Form('question-form', Models\Question::class);
        if ($this->di->post->createFromForm('question', $form, $user)) {
            $this->di->common->redirect('question/' . $form->getModel()->id);
        }
        
        return $this->di->common->renderMain('question/form', [
            'admin' => null,
            'update' => false,
            'form' => $form
        ], 'Skriv ny fråga');
    }
    
    
    /**
     * Edit question page.
     *
     * @param int $id   Question ID.
     */
    public function update($id)
    {
        $user = $this->di->common->verifyUser();
        $question = $this->di->post->useSoft()->getById($id, 'question');
        if (!$question) {
            $this->di->common->redirectError('question', "Kunde inte hitta frågan med ID $id.");
        } elseif ($user->id != $question->userId) {
            $this->di->common->redirectError('question', 'Du har inte behörighet att redigera den begärda frågan.');
        }
        
        return $this->di->common->renderMain('question/form', [
            'admin' => null,
            'update' => true,
            'form' => new Form('question-form', $question)
        ], 'Redigera fråga');
    }
    
    
    /**
     * Edit question handler.
     *
     * @param int $id   Question ID.
     */
    public function handleUpdate($id)
    {
        $user = $this->di->common->verifyUser();
        $oldQuestion = $this->di->post->useSoft()->getById($id, 'question');
        if (!$oldQuestion) {
            $this->di->common->redirectError('question', "Kunde inte hitta frågan med ID $id.");
        } elseif ($user->id != $oldQuestion->userId) {
            $this->di->common->redirectError('question', 'Du har inte behörighet att redigera den begärda frågan.');
        }
        
        $form = new Form('question-form', Models\Question::class);
        if ($this->di->post->updateFromForm($form, $oldQuestion, $user)) {
            $this->di->common->redirect('question/' . $oldQuestion->id);
        }
        
        return $this->di->common->renderMain('question/form', [
            'admin' => null,
            'update' => true,
            'form' => $form
        ], 'Redigera fråga');
    }
}
