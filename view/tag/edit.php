<h1><?= ($update ? 'Redigera tagg' : 'Skapa tagg') ?></h1>
<?php $this->renderView('default/msgs'); ?>
<?php $this->renderView('tag/form', $data); ?>
