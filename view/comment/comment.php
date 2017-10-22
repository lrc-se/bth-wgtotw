<?php

$questionId = ($post->type == 'question' ? $post->id : $post->parentId);
$vote = (!empty($user) ? $di->post->getVote($comment, $user) : null);

?>
<div id="comment-<?= $comment->id ?>" class="comment">
<?php $this->renderView('post/meta', ['post' => $comment, 'author' => $comment->user]); ?>
    <div class="post-text"><?= markdown($comment->text) ?></div>
    <div class="post-footer">
        <div class="post-rank"><?= $comment->rank ?></div>
<?php if (!empty($user) && $comment->userId != $user->id) : ?>
        <div class="post-vote">
<?php   if (!$vote) : ?>
            <a href="<?= $this->url("question/$questionId/vote/" . $comment->id . '/up') ?>?return=comment-<?= $comment->id ?>" title="Rösta upp"><span class="icon-thumbs-up"></span></a>
            <a href="<?= $this->url("question/$questionId/vote/" . $comment->id . '/down') ?>?return=comment-<?= $comment->id ?>" title="Rösta ned"><span class="icon-thumbs-down"></span></a>
<?php   else : ?>
            <span class="post-vote-active">
<?php       if ($vote->value < 0) : ?>
            <span class="icon-thumbs-down" title="Du har röstat ned denna kommentar"></span>
<?php       else : ?>
            <span class="icon-thumbs-up" title="Du har röstat upp denna kommentar"></span>
<?php       endif; ?>
        </span>
            <a href="<?= $this->url("question/$questionId/vote/" . $comment->id . '/cancel') ?>?return=comment-<?= $comment->id ?>" title="Ångra röst"><span class="icon-cancel"></span></a>
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
