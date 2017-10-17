<?php

$author = $comment->user;
$questionId = ($post->type == 'question' ? $post->id : $post->parentId);
$vote = (!empty($user) ? $di->post->getVote($comment, $user) : null);

?>
<li id="comment-<?= $comment->id ?>">
    <div class="comment-text"><?= markdown($comment->text) ?></div>
    <div class="comment-author"><a href="<?= $this->url('user/' . $author->id) ?>"><?= esc($author->username) ?></a></div>
    <div class="comment-time">
        <div class="comment-published">Skriven <?= $comment->published ?></div>
<?php if ($comment->updated) : ?>
        <div class="comment-updated">Uppdaterad <?= $comment->updated ?></div>
<?php endif; ?>
    </div>
    <div class="comment-actions">
<?php if (empty($admin) && $user && $comment->userId == $user->id) : ?>
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
