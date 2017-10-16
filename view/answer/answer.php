<?php

$author = $answer->user;

?>
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
<?php if (empty($admin) && !empty($user) && $answer->userId == $user->id) : ?>
<div class="answer-edit"><a href="<?= $this->url('question/' . $answer->parentId . '/answer/' . $answer->id) ?>">Redigera</a></div>
<?php endif; ?>
<?php $this->renderView('comment/comments', ['comments' => $di->post->getComments($answer)]); ?>
