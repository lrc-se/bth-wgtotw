<dl>
    <dt>ID:</dt>
    <dd><?= $post->id ?></dd>
<?php if ($post->title) : ?>
    <dt>Rubrik:</dt>
    <dd><?= esc($post->title) ?></dd>
<?php endif; ?>
    <dt>Författare:</dt>
    <dd>
        <span><?= ($post->user ? esc($post->user->username) : '(Borttagen användare)') ?></span>
    </dd>
    <dt>Publicerad:</dt>
    <dd><?= $post->published ?></dd>
    <dt>Uppdaterad:</dt>
    <dd><?= $post->updated ?></dd>
</dl>
<div class="post-body"><?= markdown($post->text) ?></div>
