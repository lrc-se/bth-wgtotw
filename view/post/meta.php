<?php

if ($post->type == 'answer') {
    $size = 30;
    $published = 'Publicerat';
    $updated = 'Uppdaterat';
} else {
    $published = 'Publicerad';
    $updated = 'Uppdaterad';
    if ($post->type == 'question') {
        $size = 40;
    } else {
        $size = 20;
    }
}

?>
    <div class="post-meta">
        <div class="post-author">
<?php if ($author) : ?>
            <a href="<?= $this->url('user/' . $author->id) ?>"><img src="<?= $author->getGravatar($size) ?>" alt=""></a>
            <a href="<?= $this->url('user/' . $author->id) ?>"><?= esc($author->username) ?></a>
<?php else : ?>
            <img src="<?= (new \WGTOTW\Models\User())->getGravatar($size) ?>" alt="">
            <em>(Borttagen användare)</em>
<?php endif; ?>
        </div>
        <div class="post-time">
            <div class="post-published"><span class="icon-time" title="<?= $published ?>"></span> <span><?= $post->published ?></span></div>
<?php if ($post->updated) : ?>
            <div class="post-updated"><span class="icon-update" title="<?= $updated ?>"></span> <span><?= $post->updated ?></span></div>
<?php endif; ?>
        </div>
    </div>
