<h1>Frågor</h1>
<?php $this->renderView('default/msgs'); ?>
<p><a class="btn" href="<?= $this->url('question/create') ?>">Skriv fråga</a></p>
<?php if (!empty($questions)) : ?>
<div class="questions">
    <ul>
<?php   foreach ($questions as $question) : ?>
        <li>
<?php       if ($question->status == \WGTOTW\Models\Question::ANSWERED) : ?>
            <span class="answered">!</span>
<?php       else : ?>
            <span class="unanswered">?</span>
<?php       endif; ?>
            <a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a>
            <a href="<?= $this->url('user/' . $question->user->id) ?>"><?= esc($question->user->username) ?></a>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga frågor att visa</em></p>
<?php endif; ?>
