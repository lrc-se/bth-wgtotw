<h1><?= ($formData['update'] ? 'Redigera svar' : 'Besvara fråga') ?></h1>
<?php $this->renderView('default/msgs'); ?>
<?php $this->renderView('answer/form', $formData); ?>
<h2>Fråga</h2>
<?php $this->renderView('question/question', $questionData); ?>
