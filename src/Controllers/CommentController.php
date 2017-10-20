<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Form\ModelForm as Form;
use \WGTOTW\Models as Models;

/**
 * Controller for comments.
 */
class CommentController extends BaseController
{
    /**
     * Write comment.
     *
     * @param int   $questionId     Question ID.
     * @param int   $answerId       Answer ID.
     */
    public function create($questionId, $answerId = null)
    {
        $user = $this->di->common->verifyUser();
        
        if (!is_null($answerId)) {
            $id = $answerId;
            $type = 'answer';
            $findError = "frågan med ID $questionId";
            $title = 'Kommentera svar';
        } else {
            $id = $questionId;
            $type = 'question';
            $findError = "svaret med ID $answerId";
            $title = 'Kommentera fråga';
        }
        $post = $this->di->post->useSoft()->getById($id, $type);
        if (!$post) {
            $this->di->common->redirectError('question', "Kunde inte hitta $findError.");
        }
        
        $form = new Form('comment-form', Models\Comment::class);
        if ($this->di->request->getMethod() == 'POST') {
            if ($this->di->post->createFromForm('comment', $form, $user)) {
                $this->di->common->redirect("question/$questionId#comment-" . $form->getModel()->id);
            }
        }
        
        if ($post->type == 'question') {
            $postData = [
                'question' => $post,
                'tags' => $this->di->tag->getByPost($post)
            ];
        } else {
            $postData = ['answer' => $post];
        }
        return $this->di->common->renderMain('comment/edit', [
            'title' => $title,
            'formData' => [
                'admin' => null,
                'update' => false,
                'form' => $form,
                'questionId' => $questionId,
                'answerId' => $answerId,
                'return' => 'question/' . $questionId . (!is_null($answerId) ? "#answer-$answerId" : '')
            ],
            'postData' => $postData
        ], $title);
    }
    
    
    /**
     * Edit comment.
     *
     * @param int   $questionId     Question ID.
     * @param int   $commentId      Comment ID.
     * @param int   $answerId       Answer ID.
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function update($questionId, $commentId, $answerId = null)
    {
        $user = $this->di->common->verifyUser();
        
        if (!is_null($answerId)) {
            $id = $answerId;
            $type = 'answer';
            $findError = "frågan med ID $questionId";
            $comboError = 'svars';
        } else {
            $id = $questionId;
            $type = 'question';
            $findError = "svaret med ID $answerId";
            $comboError = 'fråge';
        }
        $post = $this->di->post->useSoft()->getById($id, $type);
        if (!$post) {
            $this->di->common->redirectError('question', "Kunde inte hitta $findError.");
        }
        
        $comment = $this->di->post->useSoft()->getById($commentId, 'comment');
        if (!$comment) {
            $this->di->common->redirectError("question/$questionId", "Kunde inte hitta kommentaren med ID $commentId.");
        } elseif ($post->id != $comment->parentId) {
            $this->di->common->redirectError("question/$questionId", "Felaktig kombination av kommentars- och $comboError-ID:n.");
        } elseif (!$user->isAdmin && $user->id != $comment->userId) {
            $this->di->common->redirectError("question/$questionId", 'Du har inte behörighet att redigera den begärda kommentaren.');
        }
        
        if ($this->di->request->getMethod() == 'POST') {
            $form = new Form('comment-form', Models\Comment::class);
            if ($this->di->post->updateFromForm($form, $comment, $user)) {
                $this->di->common->redirect("question/$questionId#comment-" . $form->getModel()->id);
            }
        } else {
            $form = new Form('comment-form', $comment);
        }
        
        if ($post->type == 'question') {
            $postData = [
                'question' => $post,
                'tags' => $this->di->tag->getByPost($post)
            ];
        } else {
            $postData = ['answer' => $post];
        }
        return $this->di->common->renderMain('comment/edit', [
            'title' => 'Redigera kommentar',
            'formData' => [
                'admin' => null,
                'update' => true,
                'form' => $form,
                'questionId' => $questionId,
                'answerId' => $answerId,
                'return' => 'question/' . $questionId . '#comment-' . $comment->id
            ],
            'postData' => $postData
        ], 'Redigera kommentar');
    }
}
