<?php

$author = $answer->user;
$vote = (!empty($user) ? $di->post->getVote($answer, $user) : null);

?>
<div class="answer-header">
    <div class="rank"><?= $answer->rank ?></div>
<?php if (!empty($user) && $answer->userId != $user->id) : ?>
    <div class="vote">
<?php   if (!$vote) : ?>
        <a href="<?= $this->url('question/' . $answer->parentId . '/vote/' . $answer->id . '/down') ?>?return=answer-<?= $answer->id ?>">–</a>
        <a href="<?= $this->url('question/' . $answer->parentId . '/vote/' . $answer->id . '/up') ?>?return=answer-<?= $answer->id ?>">+</a>
<?php   else : ?>
        <span class="vote-active"><?= ($vote->value < 0 ? '–' : '+') ?></span>
        <a href="<?= $this->url('question/' . $answer->parentId . '/vote/' . $answer->id . '/cancel') ?>?return=answer-<?= $answer->id ?>">Ångra</a>
<?php   endif; ?>
    </div>
<?php endif; ?>
    <div class="answer-accept">
<?php if (!empty($user) && $question->userId == $user->id) : ?>
<?php   if ($answer->isAccepted()) : ?>
        <span class="answer-accepted">*</span>
        <a href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id . '/unaccept') ?>?return=answer-<?= $answer->id ?>">Ångra</a>
<?php   else: ?>
        <a href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id . '/accept') ?>?return=answer-<?= $answer->id ?>" title="Acceptera detta svar">*</a>
<?php   endif; ?>
<?php else : ?>
<?php   if ($answer->isAccepted()) : ?>
        <span class="answer-accepted">*</span>
<?php   endif; ?>
<?php endif; ?>
    </div>
</div>
<div class="answer-text"><?= markdown($answer->text) ?></div>
<div class="answer-author">
    <a href="<?= $this->url('user/' . $author->id) ?>">
        <img src="<?= $author->getGravatar() ?>" alt="">
        <?= esc($author->username) ?>
    </a>
</div>
<div class="answer-time">
    <div class="answer-published">Skrivet <?= $answer->published ?></div>
<?php if ($answer->updated) : ?>
    <div class="answer-updated">Uppdaterat <?= $answer->updated ?></div>
<?php endif; ?>
</div>
<div class="answer-actions">
<?php if (empty($admin) && !empty($user) && $answer->userId == $user->id) : ?>
    <a href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id) ?>">Redigera</a>
<?php endif; ?>
<?php if (!empty($canComment)) : ?>
    <a href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id . '/comment') ?>">Kommentera</a>
<?php endif; ?>
</div>
<?php $this->renderView('comment/comments', ['post' => $answer, 'user' => (isset($user) ? $user : null)]); ?>
