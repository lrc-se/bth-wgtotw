<?php if (empty($hideTitle)) : ?>
<h1>Frågor</h1>
<?php $this->renderView('default/msgs'); ?>
<p><a class="btn" href="<?= $this->url('question/create') ?>">Skriv fråga</a></p>
<?php endif; ?>
<?php if (!empty($questions)) : ?>
<div class="questions">
    <ul>
<?php   foreach ($questions as $question) : ?>
<?php       $author = ($question instanceof \WGTOTW\Models\PostVM ? $question->username : ($question->user ? $question->user->username : null)); ?>
        <li>
<?php       if ($question->isAnswered()) : ?>
            <span class="answered">! <?= $di->post->useSoft()->getAnswerCount($question) ?></span>
<?php       else : ?>
            <span class="unanswered">? <?= $di->post->useSoft()->getAnswerCount($question) ?></span>
<?php       endif; ?>
            <span class="question-rank"><?= $question->rank ?></span>
            <a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a>
<?php       if (empty($hideUser)) : ?>
<?php           if ($author) : ?>
            <a href="<?= $this->url('user/' . $question->userId) ?>"><?= esc($author) ?></a>
<?php           else : ?>
            <em>(Borttagen användare)</em>
<?php           endif; ?>
<?php       endif; ?>
            <span class="question-time"><?= $question->published ?></span>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga frågor att visa</em></p>
<?php endif; ?>
