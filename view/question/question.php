<?php

$author = $question->user;
$vote = (!empty($user) ? $di->post->getVote($question, $user) : null);

?>
<div class="question">
    <div class="question-header">
        <div class="rank"><?= $question->rank ?></div>
<?php if (!empty($user) && $question->userId != $user->id) : ?>
        <div class="vote">
<?php   if (!$vote) : ?>
            <a href="<?= $this->url('question/' . $question->id . '/vote/' . $question->id . '/down') ?>">–</a>
            <a href="<?= $this->url('question/' . $question->id . '/vote/' . $question->id . '/up') ?>">+</a>
<?php   else : ?>
            <span class="vote-active"><?= ($vote->value < 0 ? '–' : '+') ?></span>
            <a href="<?= $this->url('question/' . $question->id . '/vote/' . $question->id . '/cancel') ?>">Ångra</a>
<?php   endif; ?>
        </div>
<?php endif; ?>
    </div>
    <div class="question-text"><?= $this->di->textfilter->markdown(esc($question->text)) ?></div>
    <div class="question-author">
<?php if ($author) : ?>
        <a href="<?= $this->url('user/' . $author->id) ?>">
            <img src="<?= $author->getGravatar() ?>" alt="">
            <?= esc($author->username) ?>
        </a>
<?php else : ?>
        <img src="<?= (new \WGTOTW\Models\User())->getGravatar() ?>" alt="">
        <em>(Borttagen användare)</em>
<?php endif; ?>
    </div>
    <div class="question-time">
        <div class="question-published">Skriven <?= $question->published ?></div>
<?php if ($question->updated) : ?>
        <div class="question-updated">Uppdaterad <?= $question->updated ?></div>
<?php endif; ?>
    </div>
<?php if (!empty($tags)) : ?>
    <div class="question-tags">
        Taggar:
        <ul>
<?php   foreach ($tags as $tag) : ?>
            <li><a href="<?= $this->url('tag/' . urlencode($tag->name)) ?>"><?= esc($tag->name) ?></a></li>
<?php   endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
    <div class="question-actions">
<?php if (empty($admin) && !empty($user) && $question->userId == $user->id) : ?>
        <a href="<?= $this->url('question/edit/' . $question->id) ?>">Redigera</a>
<?php endif; ?>
<?php if (!empty($canComment)) : ?>
        <a href="<?= $this->url('question/' . $question->id . '/comment') ?>">Kommentera</a>
<?php endif; ?>
    </div>
<?php $this->renderView('comment/comments', ['post' => $question, 'user' => (isset($user) ? $user : null)]); ?>
</div>
