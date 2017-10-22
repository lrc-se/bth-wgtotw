<?php

$vote = (!empty($user) ? $di->post->getVote($answer, $user) : null);
$user = (isset($user) ? $user : null);

?>
<div class="post-header answer-header">
    <div class="post-rank"><?= $answer->rank ?></div>
<?php if (!empty($user) && $answer->userId != $user->id) : ?>
    <div class="post-vote">
<?php   if (!$vote) : ?>
        <a href="<?= $this->url('question/' . $answer->parentId . '/vote/' . $answer->id . '/up') ?>?return=answer-<?= $answer->id ?>" title="Rösta upp"><span class="icon-thumbs-up"></span></a>
        <a href="<?= $this->url('question/' . $answer->parentId . '/vote/' . $answer->id . '/down') ?>?return=answer-<?= $answer->id ?>" title="Rösta ned"><span class="icon-thumbs-down"></span></a>
<?php   else : ?>
        <span class="post-vote-active">
<?php       if ($vote->value < 0) : ?>
            <span class="icon-thumbs-down" title="Du har röstat ned detta svar"></span>
<?php       else : ?>
            <span class="icon-thumbs-up" title="Du har röstat upp detta svar"></span>
<?php       endif; ?>
        </span>
        <a href="<?= $this->url('question/' . $answer->parentId . '/vote/' . $answer->id . '/cancel') ?>?return=answer-<?= $answer->id ?>" title="Ångra röst"><span class="icon-cancel"></span></a>
<?php   endif; ?>
    </div>
<?php endif; ?>
    <div class="answer-accept">
<?php if (!empty($user) && $question->userId == $user->id) : ?>
<?php   if ($answer->isAccepted()) : ?>
        <span class="answer-accepted" title="Accepterat svar"><span class="icon-accepted"></span></span>
        <a href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id . '/unaccept') ?>?return=answer-<?= $answer->id ?>">Ångra</a>
<?php   else : ?>
        <a href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id . '/accept') ?>?return=answer-<?= $answer->id ?>" title="Acceptera detta svar"><span class="icon-accepted"></span></a>
<?php   endif; ?>
<?php else : ?>
<?php   if ($answer->isAccepted()) : ?>
        <span class="answer-accepted" title="Accepterat svar"><span class="icon-accepted"></span></span>
<?php   endif; ?>
<?php endif; ?>
    </div>
</div>
<div class="post-body answer">
<?php $this->renderView('post/meta', ['post' => $answer, 'author' => $answer->user]); ?>
    <div class="post-text"><?= markdown($answer->text) ?></div>
<?php $this->renderView('post/actions', ['post' => $answer, 'user' => $user, 'canComment' => !empty($canComment)]); ?>
<?php $this->renderView('comment/comments', ['post' => $answer, 'user' => $user]); ?>
</div>
