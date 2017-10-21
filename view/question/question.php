<?php

$author = $question->user;
$vote = (!empty($user) ? $di->post->getVote($question, $user) : null);

?>
<div class="question-header">
    <div class="post-rank"><?= $question->rank ?></div>
<?php if (!empty($user) && $question->userId != $user->id) : ?>
    <div class="post-vote">
<?php   if (!$vote) : ?>
        <a href="<?= $this->url('question/' . $question->id . '/vote/' . $question->id . '/down') ?>">–</a>
        <a href="<?= $this->url('question/' . $question->id . '/vote/' . $question->id . '/up') ?>">+</a>
<?php   else : ?>
        <span class="post-vote-active"><?= ($vote->value < 0 ? '–' : '+') ?></span>
        <a href="<?= $this->url('question/' . $question->id . '/vote/' . $question->id . '/cancel') ?>">Ångra</a>
<?php   endif; ?>
    </div>
<?php endif; ?>
</div>
<div class="question">
    <div class="question-text"><?= $this->di->textfilter->markdown(esc($question->text)) ?></div>
    <div class="question-meta">
        <div class="question-author">
            <span>Skriven av</span>
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
        <div class="question-time">
            <div class="question-published">Publicerad <span><?= $question->published ?></span></div>
<?php if ($question->updated) : ?>
            <div class="question-updated">Uppdaterad <span><?= $question->updated ?></span></div>
<?php endif; ?>
        </div>
    </div>
<?php if (!empty($tags)) : ?>
    <div class="question-tags">
        <strong>Taggar:</strong>
        <ul>
<?php   foreach ($tags as $tag) : ?>
            <li><a href="<?= $this->url('tag/' . urlencode($tag->name)) ?>"><?= esc($tag->name) ?></a></li>
<?php   endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
    <div class="question-actions">
<?php if (!empty($canComment)) : ?>
        <a class="btn btn-small" href="<?= $this->url('question/' . $question->id . '/comment') ?>">Kommentera</a>
<?php endif; ?>
<?php if (!empty($user) && ($user->isAdmin || $question->userId == $user->id)) : ?>
        <a class="btn btn-small btn-2" href="<?= $this->url('question/edit/' . $question->id) ?>">Redigera</a>
<?php endif; ?>
    </div>
<?php $this->renderView('comment/comments', ['post' => $question, 'user' => (isset($user) ? $user : null)]); ?>
</div>
