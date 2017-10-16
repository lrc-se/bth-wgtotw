<?php

$author = $question->user;

?>
<div class="question">
    <div class="question-text"><?= $this->di->textfilter->markdown(esc($question->text)) ?></div>
    <div class="question-author">
        <a href="<?= $this->url('user/' . $author->id) ?>">
            <img src="<?= $author->getGravatar() ?>" alt="">
            <?= esc($author->username) ?>
        </a>
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
<?php if (empty($admin) && !empty($user) && $question->userId == $user->id) : ?>
<div class="question-edit"><a href="<?= $this->url('question/edit/' . $question->id) ?>">Redigera</a></div>
<?php endif; ?>
<?php $this->renderView('comment/comments', ['comments' => $di->post->getComments($question)]); ?>
</div>
