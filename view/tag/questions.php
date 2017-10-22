<h1><?= esc($tag->name) ?></h1>
<?php $this->renderView('default/msgs'); ?>
<div class="tag-desc"><?= esc($tag->description) ?></div>
<h2>Frågor (<?= count($questions) ?>)</h2>
<?php $this->renderView('question/index', ['questions' => $questions, 'hideTitle' => true]); ?>
