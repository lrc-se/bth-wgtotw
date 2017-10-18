<?php if (empty($hideTitle)) : ?>
<h1>Frågor</h1>
<?php $this->renderView('default/msgs'); ?>
<p><a class="btn" href="<?= $this->url('question/create') ?>">Skriv fråga</a></p>
<?php endif; ?>
<?php if (!empty($questions)) : ?>
<div class="questions">
    <ul>
<?php   foreach ($questions as $question) : ?>
        <li>
<?php       if ($question->isAnswered()) : ?>
            <span class="answered">! <?= $di->post->useSoft()->getAnswerCount($question) ?></span>
<?php       else : ?>
            <span class="unanswered">? <?= $di->post->useSoft()->getAnswerCount($question) ?></span>
<?php       endif; ?>
            <a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a>
<?php       if (empty($hideUser)) : ?>
            <a href="<?= $this->url('user/' . $question->user->id) ?>"><?= esc($question->user->username) ?></a>
<?php       endif; ?>
            <span class="question-time"><?= $question->published ?></span>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga frågor att visa</em></p>
<?php endif; ?>
