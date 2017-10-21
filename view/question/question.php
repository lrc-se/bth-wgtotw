<?php

$vote = (!empty($user) ? $di->post->getVote($question, $user) : null);
$user = (isset($user) ? $user : null);

?>
<div class="post-header question-header">
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
<div class="post-body question">
    <div class="post-text">
<?php $this->renderView('post/meta', ['post' => $question, 'author' => $question->user]); ?>
        <?= $this->di->textfilter->markdown(esc($question->text)) ?>
    </div>
<?php if (!empty($tags)) : ?>
    <div class="post-tags">
        <strong>Taggar:</strong>
        <ul>
<?php   foreach ($tags as $tag) : ?>
            <li><a href="<?= $this->url('tag/' . urlencode($tag->name)) ?>"><?= esc($tag->name) ?></a></li>
<?php   endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php $this->renderView('post/actions', ['post' => $question, 'user' => $user, 'canComment' => !empty($canComment)]); ?>
<?php $this->renderView('comment/comments', ['post' => $question, 'user' => $user]); ?>
</div>
