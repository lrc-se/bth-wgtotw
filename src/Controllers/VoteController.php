<?php

namespace WGTOTW\Controllers;

use \WGTOTW\Form\ModelForm as Form;
use \WGTOTW\Models as Models;

/**
 * Controller for votes.
 */
class VoteController extends BaseController
{
    /**
     * Handle down vote.
     *
     * @param int   $questionId     Question ID.
     * @param int   $postId         Post ID.
     */
    public function voteDown($questionId, $postId)
    {
        $this->handleVote($questionId, $postId, -1);
    }
    
    
    /**
     * Handle up vote.
     *
     * @param int   $questionId     Question ID.
     * @param int   $postId         Post ID.
     */
    public function voteUp($questionId, $postId)
    {
        $this->handleVote($questionId, $postId, 1);
    }
    
    
    /**
     * Cancel vote.
     *
     * @param int   $questionId     Question ID.
     * @param int   $postId         Post ID.
     */
    public function cancelVote($questionId, $postId)
    {
        $this->handleVote($questionId, $postId, 0);
    }
    
    
    /**
     * Handle vote.
     *
     * @param int   $questionId     Question ID.
     * @param int   $postId         Post ID.
     * @param int   $value          Vote value.
     */
    private function handleVote($questionId, $postId, $value)
    {
        $user = $this->di->common->verifyUser();
        $post = $this->di->post->useSoft()->getById($postId);
        if (!$post) {
            $this->di->common->redirectError("question/$questionId", "Kunde inte hitta inlägget med ID $postId.");
        }
        if ($post->userId == $user->id) {
            $this->di->common->redirectError("question/$questionId", 'Du kan inte rösta på ditt eget inlägg.');
        }
        
        if ($this->di->post->registerVote($post, $user, $value)) {
            $anchor = urlencode($this->di->request->getGet('return'));
            $this->di->common->redirect("question/$questionId" . ($anchor ? "#$anchor" : ''));
        } else {
            $this->di->common->redirectError("question/$questionId", 'Du har redan röstat på detta inlägg.');
        }
    }
}
