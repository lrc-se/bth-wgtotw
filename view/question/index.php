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
        <li <?= ($question->isAnswered() ? ' class="answered"' : '') ?>>
<?php       if ($question->isAnswered()) : ?>
            <span class="question-status">! <?= $di->post->useSoft()->getAnswerCount($question) ?></span>
<?php       else : ?>
            <span class="question-status">? <?= $di->post->useSoft()->getAnswerCount($question) ?></span>
<?php       endif; ?>
            <span class="post-rank"><?= $question->rank ?></span>
            <span class="question-title"><a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a></span>
<?php       if (empty($hideUser)) : ?>
            <span class="question-meta">
                <span class="question-author">
<?php           if ($author) : ?>
                    <a href="<?= $this->url('user/' . $question->userId) ?>"><?= esc($author) ?></a>
<?php           else : ?>
                    <em>(Borttagen användare)</em>
<?php           endif; ?>
                </span>
<?php       endif; ?>
                <span class="question-time"><?= $question->published ?></span>
            </span>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga frågor att visa</em></p>
<?php endif; ?>
