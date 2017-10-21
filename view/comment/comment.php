<?php

$questionId = ($post->type == 'question' ? $post->id : $post->parentId);
$vote = (!empty($user) ? $di->post->getVote($comment, $user) : null);

?>
<div id="comment-<?= $comment->id ?>" class="comment">
    <div class="post-text"><?= markdown($comment->text) ?></div>
<?php $this->renderView('post/meta', ['post' => $comment, 'author' => $comment->user]); ?>
    <div class="post-footer">
        <div class="post-rank"><?= $comment->rank ?></div>
<?php if (!empty($user) && $comment->userId != $user->id) : ?>
        <div class="post-vote">
<?php   if (!$vote) : ?>
            <a href="<?= $this->url("question/$questionId/vote/" . $comment->id . '/down') ?>?return=comment-<?= $comment->id ?>">–</a>
            <a href="<?= $this->url("question/$questionId/vote/" . $comment->id . '/up') ?>?return=comment-<?= $comment->id ?>">+</a>
<?php   else : ?>
            <span class="post-vote-active"><?= ($vote->value < 0 ? '–' : '+') ?></span>
            <a href="<?= $this->url("question/$questionId/vote/" . $comment->id . '/cancel') ?>?return=comment-<?= $comment->id ?>">Ångra</a>
<?php   endif; ?>
        </div>
<?php endif; ?>
    <div class="post-actions">
<?php if (!empty($user) && ($user->isAdmin || $comment->userId == $user->id)) : ?>
<?php   if ($post->type == 'question') : ?>
        <a class="btn btn-small btn-2" href="<?= $this->url("question/$questionId/comment/" . $comment->id) ?>">Redigera</a>
<?php   elseif ($post->type == 'answer') : ?>
        <a class="btn btn-small btn-2" href="<?= $this->url("question/$questionId/answer/" . $post->id . '/comment/' . $comment->id) ?>">Redigera</a>
<?php   endif; ?>
<?php endif; ?>
    </div>
    </div>
</div>
