<h1><?= $title ?></h1>
<?php $this->renderView('default/msgs'); ?>
<?php $this->renderView('comment/form', $formData); ?>
<?php if (is_null($formData['answerId'])) : ?>
<h2>Fråga</h2>
<?php $this->renderView('question/question', $postData); ?>
<?php else : ?>
<h2>Svar</h2>
<?php $this->renderView('answer/answer', $postData); ?>
<?php endif; ?>
