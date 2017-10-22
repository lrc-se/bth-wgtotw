<h1><?= $title ?></h1>
<?php if ($deleted) : ?>
<div class="msg warning"><div><strong>OBS!</strong> <?= $deleted ?> och visas inte för besökare.</div></div>
<?php endif; ?>
<div<?= (isset($comment) ? ' class="post-body"' : '') ?>>
<?php $this->renderView($view, $data); ?>
</div>
<div class="spacer"></div>
<p>
    <a class="btn btn-2" href="<?= $this->url($return) ?>">Tillbaka</a>
</p>
