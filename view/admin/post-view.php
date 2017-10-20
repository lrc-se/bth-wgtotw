<?php if ($deleted) : ?>
<div class="msg warning"><div>OBS! <?= $deleted ?> och visas inte för besökare.</div></div>
<?php endif; ?>
<?php $this->renderView($view, $data); ?>
<p>
    <a class="btn btn-2" href="<?= $this->url($return) ?>">Tillbaka</a>
</p>
