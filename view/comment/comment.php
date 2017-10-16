<li id="comment-<?= $comment->id ?>">
    <div class="comment-text"><?= markdown($comment->text) ?></div>
    <div class="comment-author"><a href="<?= $this->url('user/' . $comment->user->id) ?>"><?= esc($comment->user->username) ?></a></div>
    <div class="comment-time">
        <div class="comment-published">Skriven <?= $comment->published ?></div>
<?php if ($comment->updated) : ?>
        <div class="comment-updated">Uppdaterad <?= $comment->updated ?></div>
<?php endif; ?>
    </div>
    <div class="comment-actions">
<?php if (empty($admin) && $user && $comment->userId == $user->id) : ?>
<?php   if ($post->type == 'question') : ?>
        <a href="<?= $this->url('question/' . $post->id . '/comment/' . $comment->id) ?>">Redigera</a>
<?php   elseif ($post->type == 'answer') : ?>
        <a href="<?= $this->url('question/' . $post->parentId . '/answer/' . $post->id . '/comment/' . $comment->id) ?>">Redigera</a>
<?php   endif; ?>
<?php endif; ?>
    </div>
</li>
