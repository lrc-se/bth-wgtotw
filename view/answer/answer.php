<?php

$author = $answer->user;
$vote = (!empty($user) ? $di->post->getVote($answer, $user) : null);

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
    <div class="post-meta">
        <div class="post-author">
            <span>Skrivet av</span>
            <span>
<?php if ($author) : ?>
                <a href="<?= $this->url('user/' . $author->id) ?>"><img src="<?= $author->getGravatar(30) ?>" alt=""></a>
                <a href="<?= $this->url('user/' . $author->id) ?>"><?= esc($author->username) ?></a>
<?php else : ?>
                <img src="<?= (new \WGTOTW\Models\User())->getGravatar(30) ?>" alt="">
                <em>(Borttagen användare)</em>
<?php endif; ?>
            </span>
        </div>
        <div class="post-time">
            <div class="post-published">Publicerat <span><?= $answer->published ?></span></div>
<?php if ($answer->updated) : ?>
            <div class="post-updated">Uppdaterat <span><?= $answer->updated ?></span></div>
<?php endif; ?>
        </div>
    </div>
    <div class="post-actions">
<?php if (!empty($canComment)) : ?>
        <a class="btn btn-small" href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id . '/comment') ?>">Kommentera</a>
<?php endif; ?>
<?php if (!empty($user) && ($user->isAdmin || $answer->userId == $user->id)) : ?>
        <a class="btn btn-small btn-2" href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id) ?>">Redigera</a>
<?php endif; ?>
    </div>
<?php $this->renderView('comment/comments', ['post' => $answer, 'user' => (isset($user) ? $user : null)]); ?>
</div>
