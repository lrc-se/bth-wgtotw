<li>
    <div class="comment-text"><?= markdown($comment->text) ?></div>
    <div class="comment-author"><a href="<?= $this->url('user/' . $comment->user->id) ?>"><?= esc($comment->user->username) ?></a></div>
    <div class="comment-time">
        <div class="comment-published">Skriven <?= $comment->published ?></div>
<?php if ($comment->updated) : ?>
        <div class="comment-updated">Uppdaterad <?= $comment->updated ?></div>
<?php endif; ?>
    </div>
</li>
