<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Form\ModelForm as Form;
use \WGTOTW\Models as Models;

/**
 * Controller for answers.
 */
class AnswerController extends BaseController
{
    /**
     * Write answer page.
     */
    public function create($questionId)
    {
        $this->di->common->verifyUser();
        $question = $this->di->post->getById($questionId, 'question');
        if (!$question) {
            $this->di->common->redirectError('question', "Kunde inte hitta frågan med ID $questionId.");
        }
        
        return $this->di->common->renderMain('answer/form', [
            'admin' => null,
            'update' => false,
            'form' => new Form('answer-form', Models\Answer::class),
            'question' => $question
        ], 'Besvara fråga');
    }
    
    
    /**
     * Write answer handler.
     */
    public function handleCreate($questionId)
    {
        $user = $this->di->common->verifyUser();
        $question = $this->di->post->getById($questionId, 'question');
        if (!$question) {
            $this->di->common->redirectError('question', "Kunde inte hitta frågan med ID $questionId.");
        }
        
        $form = new Form('answer-form', Models\Answer::class);
        if ($this->di->post->createFromForm('answer', $form, $user)) {
            $this->di->common->redirect("question/$questionId#answer-" . $form->getModel()->id);
        }
        
        return $this->di->common->renderMain('answer/form', [
            'admin' => null,
            'update' => false,
            'form' => $form,
            'question' => $question
        ], 'Besvara fråga');
    }
    
    
    /**
     * Edit answer page.
     *
     * @param int $id   Answer ID.
     */
    public function update($questionId, $answerId)
    {
        $user = $this->di->common->verifyUser();
        $question = $this->di->post->getById($questionId, 'question');
        if (!$question) {
            $this->di->common->redirectError('question', "Kunde inte hitta frågan med ID $questionId.");
        }
        
        $answer = $this->di->post->useSoft()->getById($answerId, 'answer');
        if (!$answer) {
            $this->di->common->redirectError("question/$questionId", "Kunde inte hitta svaret med ID $answerId.");
        } elseif ($user->id != $answer->userId) {
            $this->di->common->redirectError("question/$questionId", 'Du har inte behörighet att redigera det begärda svaret.');
        } elseif ($answer->parentId != $question->id) {
            $this->di->common->redirectError("question/$questionId", 'Felaktig kombination av fråge- och svars-ID:n.');
        }
        
        return $this->di->common->renderMain('answer/form', [
            'admin' => null,
            'update' => true,
            'form' => new Form('answer-form', $answer),
            'question' => $question
        ], 'Redigera svar');
    }
    
    
    /**
     * Edit answer handler.
     *
     * @param int $id   Answer ID.
     */
    public function handleUpdate($questionId, $answerId)
    {
        $user = $this->di->common->verifyUser();
        $question = $this->di->post->getById($questionId, 'question');
        if (!$question) {
            $this->di->common->redirectError('question', "Kunde inte hitta frågan med ID $questionId.");
        }
        
        $oldAnswer = $this->di->post->useSoft()->getById($answerId, 'answer');
        if (!$oldAnswer) {
            $this->di->common->redirectError("question/$questionId", "Kunde inte hitta frågan med ID $answerId.");
        } elseif ($user->id != $oldAnswer->userId) {
            $this->di->common->redirectError("question/$questionId", 'Du har inte behörighet att redigera det begärda svaret.');
        } elseif ($oldAnswer->parentId != $question->id) {
            $this->di->common->redirectError("question/$questionId", 'Felaktig kombination av fråge- och svars-ID:n.');
        }
        
        $form = new Form('answer-form', Models\Answer::class);
        if ($this->di->post->updateFromForm($form, $oldAnswer, $user)) {
            $this->di->common->redirect("question/$questionId#answer-" . $form->getModel()->id);
        }
        
        return $this->di->common->renderMain('answer/form', [
            'admin' => null,
            'update' => true,
            'form' => $form,
            'question' => $question
        ], 'Redigera svar');
    }
}
