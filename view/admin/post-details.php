<dl>
    <dt>ID:</dt>
    <dd><?= $post->id ?></dd>
<?php if ($post->title) : ?>
    <dt>Rubrik:</dt>
    <dd><?= esc($post->title) ?></dd>
<?php endif; ?>
    <dt>Författare:</dt>
    <dd>
<?php if ($post->user) : ?>
        <span><?= esc($post->user->username) ?></span>
<?php else : ?>
        <em>(Borttagen användare)</em>
<?php endif; ?>
    </dd>
    <dt>Publicerad:</dt>
    <dd><?= $post->published ?></dd>
    <dt>Uppdaterad:</dt>
    <dd><?= $post->updated ?></dd>
</dl>
<div class="post-text"><?= markdown($post->text) ?></div>
