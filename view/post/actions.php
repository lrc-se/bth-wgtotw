<?php

if ($post->type == 'question') {
    $commentUrl = 'question/' . $post->id . '/comment';
    $editUrl = 'question/edit/' . $post->id;
} elseif ($post->type == 'answer') {
    $commentUrl = 'question/' . $post->parentId . '/answer/' . $post->id . '/comment';
    $editUrl = 'question/' . $post->parentId . '/answer/' . $post->id;
}

?>
    <div class="post-actions">
<?php if (!empty($canComment)) : ?>
        <a class="btn btn-small" href="<?= $this->url($commentUrl) ?>">Kommentera</a>
<?php endif; ?>
<?php if (!empty($user) && ($user->isAdmin || $post->userId == $user->id)) : ?>
        <a class="btn btn-small btn-2" href="<?= $this->url($editUrl) ?>">Redigera</a>
<?php endif; ?>
    </div>
