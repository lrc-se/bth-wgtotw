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
        
        $tags = $this->di->tag->getByPost($question);
        $comments = $this->di->post->getComments($question);
        $answers = $this->di->post->getAnswers($question);
        
        return $this->di->common->renderMain('question/view', [
            'user' => $this->di->user->getCurrent(),
            'question' => $question,
            'canComment' => true,
            'tags' => $tags,
            'comments' => $comments,
            'answers' => $answers
        ], htmlspecialchars($question->title));
    }
    
    
    /**
     * Write question.
     */
    public function create()
    {
        $user = $this->di->common->verifyUser();
        $form = new Form('question-form', Models\Question::class);
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->post->createFromForm('question', $form, $user)) {
                $this->di->common->redirect('question/' . $form->getModel()->id);
            }
        }
        
        return $this->di->common->renderMain('question/edit', [
            'admin' => null,
            'update' => false,
            'form' => $form,
            'tags' => $this->di->tag->getAll(),
            'tagIds' => []
        ], 'Skriv ny fråga');
    }
    
    
    /**
     * Edit question.
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
        
        if ($this->di->request->getMethod() == 'POST') {
            $form = new Form('question-form', Models\Question::class);
            if ($this->di->post->updateFromForm($form, $question, $user)) {
                $this->di->common->redirect('question/' . $question->id);
            }
        } else {
            $form = new Form('question-form', $question);
        }
        
        return $this->di->common->renderMain('question/edit', [
            'admin' => null,
            'update' => true,
            'form' => $form,
            'tags' => $this->di->tag->getAll(),
            'tagIds' => $this->di->tag->getIdsByPost($question)
        ], 'Redigera fråga');
    }
}
