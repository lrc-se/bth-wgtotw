<h1><?= ($update ? 'Redigera fråga' : 'Skriv fråga') ?></h1>
<?php $this->renderView('default/msgs'); ?>
<?php $this->renderView('question/form', $data); ?>
