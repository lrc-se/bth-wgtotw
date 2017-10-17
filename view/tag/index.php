<h1>Taggar</h1>
<?php $this->renderView('default/msgs'); ?>
<?php if (!empty($tags)) : ?>
<div class="tags">
    <ul>
<?php   foreach ($tags as $tag) : ?>
        <li>
            <a href="<?= $this->url('tag/' . urlencode($tag->name)) ?>"><?= esc($tag->name) ?></a>
            <div class="tag-desc"><?= esc($tag->description) ?></div>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga taggar att visa</em></p>
<?php endif; ?>
