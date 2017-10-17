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
     * Write answer.
     *
     * @param int   $questionId     Question ID.
     */
    public function create($questionId)
    {
        $user = $this->di->common->verifyUser();
        $question = $this->di->post->getById($questionId, 'question');
        if (!$question) {
            $this->di->common->redirectError('question', "Kunde inte hitta frågan med ID $questionId.");
        }
        
        $form = new Form('answer-form', Models\Answer::class);
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->post->createFromForm('answer', $form, $user)) {
                $this->di->common->redirect("question/$questionId#answer-" . $form->getModel()->id);
            }
        }
        
        return $this->di->common->renderMain('answer/edit', [
            'formData' => [
                'admin' => null,
                'update' => false,
                'form' => $form,
                'questionId' => $question->id
            ],
            'questionData' => [
                'question' => $question,
                'tags' => [],
                'author' => $question->user
            ]
        ], 'Besvara fråga');
    }
    
    
    /**
     * Edit answer.
     *
     * @param int   $questionID     Question ID.
     * @param int   $answerID       Answer ID.
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
        } elseif ($answer->parentId != $question->id) {
            $this->di->common->redirectError("question/$questionId", 'Felaktig kombination av fråge- och svars-ID:n.');
        } elseif ($user->id != $answer->userId) {
            $this->di->common->redirectError("question/$questionId", 'Du har inte behörighet att redigera det begärda svaret.');
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            $form = new Form('answer-form', Models\Answer::class);
            if ($this->di->post->updateFromForm($form, $answer, $user)) {
                $this->di->common->redirect("question/$questionId#answer-" . $form->getModel()->id);
            }
        } else {
            $form = new Form('answer-form', $answer);
        }
        
        return $this->di->common->renderMain('answer/edit', [
            'formData' => [
                'admin' => null,
                'update' => true,
                'form' => $form,
                'questionId' => $question->id
            ],
            'questionData' => [
                'question' => $question,
                'tags' => [],
                'author' => $question->user
            ]
        ], 'Redigera svar');
    }
    
    
    /**
     * Accept answer.
     *
     * @param int   $questionId     Question ID.
     * @param int   $answerId       Answer ID.
     */
    public function accept($questionId, $answerId)
    {
        $this->changeAcceptedStatus($questionId, $answerId, true);
    }
    
    
    /**
     * Unaccept answer.
     *
     * @param int   $questionId     Question ID.
     * @param int   $answerId       Answer ID.
     */
    public function unaccept($questionId, $answerId)
    {
        $this->changeAcceptedStatus($questionId, $answerId, false);
    }
    
    
    /**
     * Change accepted status for answer.
     *
     * @param int   $questionId     Question ID.
     * @param int   $answerId       Answer ID.
     * @param int   $status         Accepted status.
     */
    private function changeAcceptedStatus($questionId, $answerId, $status)
    {
        $user = $this->di->common->verifyUser();
        $answer = $this->di->post->useSoft()->getById($answerId, 'answer');
        if (!$answer) {
            $this->di->common->redirectError("question/$questionId", "Kunde inte hitta svaret med ID $answerId.");
        }
        
        $question = $this->di->post->useSoft()->getById($questionId, 'question');
        if (!$question) {
            $this->di->common->redirectError('question', "Kunde inte hitta frågan med ID $questionId.");
        } elseif ($answer->parentId != $question->id) {
            $this->di->common->redirectError("question/$questionId", 'Felaktig kombination av fråge- och svars-ID:n.');
        } elseif ($question->userId != $user->id) {
            $this->di->common->redirectError("question/$questionId", 'Du har inte behörighet att acceptera svar för denna fråga.');
        }
        
        if ($status) {
            $this->di->post->acceptAnswer($question, $answer);
        } else {
            $this->di->post->unacceptAnswer($question, $answer);
        }
        $this->di->common->redirect("question/$questionId#answer-" . $answer->id);
    }
}
