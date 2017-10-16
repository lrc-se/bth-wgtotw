<h1><?= esc($question->title) ?></h1>
<?php $this->renderView('default/msgs'); ?>
<?php $this->renderView('question/question', $data); ?>
<h2>Svar</h2>
<?php if ($user) : ?>
<p><a class="btn" href="<?= $this->url('question/' . $question->id . '/answer') ?>">Skriv ett svar</a></p>
<?php endif; ?>
<?php if (!empty($answers)) : ?>
<div class="answers">
    <ul>
<?php   foreach ($answers as $answer) : ?>
        <li id="answer-<?= $answer->id ?>">
<?php $this->renderView('answer/answer', ['answer' => $answer, 'user' => $user, 'canComment' => true]); ?>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga svar att visa</em></p>
<?php endif; ?>
