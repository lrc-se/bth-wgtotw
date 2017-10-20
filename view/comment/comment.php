<?php

$author = $comment->user;
$questionId = ($post->type == 'question' ? $post->id : $post->parentId);
$vote = (!empty($user) ? $di->post->getVote($comment, $user) : null);

?>
<li id="comment-<?= $comment->id ?>">
    <div class="comment-text"><?= markdown($comment->text) ?></div>
    <div class="comment-author">
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
    <div class="comment-time">
        <div class="comment-published">Skriven <?= $comment->published ?></div>
<?php if ($comment->updated) : ?>
        <div class="comment-updated">Uppdaterad <?= $comment->updated ?></div>
<?php endif; ?>
    </div>
    <div class="comment-actions">
<?php if (!empty($user) && ($user->isAdmin || $comment->userId == $user->id)) : ?>
<?php   if ($post->type == 'question') : ?>
        <a href="<?= $this->url("question/$questionId/comment/" . $comment->id) ?>">Redigera</a>
<?php   elseif ($post->type == 'answer') : ?>
        <a href="<?= $this->url("question/$questionId/answer/" . $post->id . '/comment/' . $comment->id) ?>">Redigera</a>
<?php   endif; ?>
<?php endif; ?>
    </div>
    <div class="comment-footer">
        <div class="rank"><?= $comment->rank ?></div>
<?php if (!empty($user) && $comment->userId != $user->id) : ?>
        <div class="vote">
<?php   if (!$vote) : ?>
            <a href="<?= $this->url("question/$questionId/vote/" . $comment->id . '/down') ?>?return=comment-<?= $comment->id ?>">–</a>
            <a href="<?= $this->url("question/$questionId/vote/" . $comment->id . '/up') ?>?return=comment-<?= $comment->id ?>">+</a>
<?php   else : ?>
            <span class="vote-active"><?= ($vote->value < 0 ? '–' : '+') ?></span>
            <a href="<?= $this->url("question/$questionId/vote/" . $comment->id . '/cancel') ?>?return=comment-<?= $comment->id ?>">Ångra</a>
<?php   endif; ?>
        </div>
<?php endif; ?>
    </div>
</li>
