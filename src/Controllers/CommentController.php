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
        $post = $this->di->post->useSoft()->getById(($answerId ?: $questionId));
        if (!$post || $post->type == 'comment') {
            $this->di->common->redirectError('question', 'Kunde inte hitta ' . (is_null($answerId) ? "frågan med ID $questionId." : "svaret med ID $answerId."));
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
                'tags' => []
            ];
        } elseif ($post->type == 'answer') {
            $postData = ['answer' => $post];
        }
        return $this->di->common->renderMain('comment/edit', [
            'title' => 'Kommentera ' . (is_null($answerId) ? 'fråga' : 'svar'),
            'formData' => [
                'admin' => null,
                'update' => false,
                'form' => $form,
                'questionId' => $questionId,
                'answerId' => $answerId
            ],
            'postData' => $postData
        ], 'Kommentera ' . (is_null($answerId) ? 'fråga' : 'svar'));
    }
    
    
    /**
     * Edit comment.
     *
     * @param int   $questionId     Question ID.
     * @param int   $commentId      Comment ID.
     * @param int   $answerId       Answer ID.
     */
    public function update($questionId, $commentId, $answerId = null)
    {
        $user = $this->di->common->verifyUser();
        $post = $this->di->post->useSoft()->getById(($answerId ?: $questionId));
        if (!$post || $post->type == 'comment') {
            $this->di->common->redirectError('question', 'Kunde inte hitta ' . (is_null($answerId) ? "frågan med ID $questionId." : "svaret med ID $answerId."));
        }
        
        $comment = $this->di->post->useSoft()->getById($commentId, 'comment');
        if (!$comment) {
            $this->di->common->redirectError("question/$questionId", "Kunde inte hitta kommentaren med ID $commentId.");
        } elseif ($post->id != $comment->parentId) {
            $this->di->common->redirectError("question/$questionId", 'Felaktig kombination av kommentars- och ' . (is_null($answerId) ? 'fråge-' : 'svars-') . 'ID:n.');
        } elseif ($user->id != $comment->userId) {
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
                'tags' => []
            ];
        } elseif ($post->type == 'answer') {
            $postData = ['answer' => $post];
        }
        return $this->di->common->renderMain('comment/edit', [
            'title' => 'Redigera kommentar',
            'formData' => [
                'admin' => null,
                'update' => true,
                'form' => $form,
                'questionId' => $questionId,
                'answerId' => ($post->type == 'answer' ? $post->id : null)
            ],
            'postData' => $postData
        ], 'Redigera kommentar');
    }
}
