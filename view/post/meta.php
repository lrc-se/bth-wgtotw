<?php

if ($post->type == 'answer') {
    $written = 'Skrivet';
    $published = 'Publicerat';
    $updated = 'Uppdaterat';
} else {
    $written = 'Skriven';
    $published = 'Publicerad';
    $updated = 'Uppdaterad';
}

?>
    <div class="post-meta">
        <div class="post-author">
            <span><?= $written ?> av</span>
            <span>
<?php if ($author) : ?>
                <a href="<?= $this->url('user/' . $author->id) ?>"><img src="<?= $author->getGravatar(30) ?>" alt=""></a>
                <a href="<?= $this->url('user/' . $author->id) ?>"><?= esc($author->username) ?></a>
<?php else : ?>
                <img src="<?= (new \WGTOTW\Models\User())->getGravatar(30) ?>" alt="">
                <em>(Borttagen användare)</em>
<?php endif; ?>
            </span>
        </div>
        <div class="post-time">
            <div class="post-published"><?= $published ?> <span><?= $post->published ?></span></div>
<?php if ($post->updated) : ?>
            <div class="post-updated"><?= $updated ?> <span><?= $post->updated ?></span></div>
<?php endif; ?>
        </div>
    </div>
