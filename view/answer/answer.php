<?php

$vote = (!empty($user) ? $di->post->getVote($answer, $user) : null);
$user = (isset($user) ? $user : null);

?>
<div class="post-header answer-header">
    <div class="post-rank"><?= $answer->rank ?></div>
<?php if (!empty($user) && $answer->userId != $user->id) : ?>
    <div class="post-vote">
<?php   if (!$vote) : ?>
        <a href="<?= $this->url('question/' . $answer->parentId . '/vote/' . $answer->id . '/down') ?>?return=answer-<?= $answer->id ?>">–</a>
        <a href="<?= $this->url('question/' . $answer->parentId . '/vote/' . $answer->id . '/up') ?>?return=answer-<?= $answer->id ?>">+</a>
<?php   else : ?>
        <span class="post-vote-active"><?= ($vote->value < 0 ? '–' : '+') ?></span>
        <a href="<?= $this->url('question/' . $answer->parentId . '/vote/' . $answer->id . '/cancel') ?>?return=answer-<?= $answer->id ?>">Ångra</a>
<?php   endif; ?>
    </div>
<?php endif; ?>
    <div class="answer-accept">
<?php if (!empty($user) && $question->userId == $user->id) : ?>
<?php   if ($answer->isAccepted()) : ?>
        <span class="answer-accepted">*</span>
        <a href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id . '/unaccept') ?>?return=answer-<?= $answer->id ?>">Ångra</a>
<?php   else : ?>
        <a href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id . '/accept') ?>?return=answer-<?= $answer->id ?>" title="Acceptera detta svar">*</a>
<?php   endif; ?>
<?php else : ?>
<?php   if ($answer->isAccepted()) : ?>
        <span class="answer-accepted" title="Accepterat svar">*</span>
<?php   endif; ?>
<?php endif; ?>
    </div>
</div>
<div class="post-body answer">
    <div class="post-text"><?= markdown($answer->text) ?></div>
<?php $this->renderView('post/meta', ['post' => $answer, 'author' => $answer->user]); ?>
<?php $this->renderView('post/actions', ['post' => $answer, 'user' => $user, 'canComment' => !empty($canComment)]); ?>
<?php $this->renderView('comment/comments', ['post' => $answer, 'user' => $user]); ?>
</div>
