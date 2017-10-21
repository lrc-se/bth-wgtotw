<?php if (empty($hideTitle)) : ?>
<h1>Frågor</h1>
<?php $this->renderView('default/msgs'); ?>
<p><a class="btn" href="<?= $this->url('question/create') ?>">Skriv fråga</a></p>
<?php endif; ?>
<?php if (!empty($questions)) : ?>
<div class="questions">
    <ul>
<?php   foreach ($questions as $question) : ?>
<?php       if ($question instanceof \WGTOTW\Models\PostVM) : ?>
<?php           $author = new \WGTOTW\Models\User(); ?>
<?php           $author->username = $question->username; ?>
<?php           $author->email = $question->email; ?>
<?php       else : ?>
<?php           $author = $question->user; ?>
<?php       endif; ?>
        <li <?= ($question->isAnswered() ? ' class="answered"' : '') ?>>
<?php       if ($question->isAnswered()) : ?>
            <span class="question-status"><span class="icon-answer" title="Har ett accepterat svar"></span> <?= $di->post->useSoft()->getAnswerCount($question) ?></span>
<?php       else : ?>
            <span class="question-status"><span class="icon-question" title="Saknar accepterat svar"></span> <?= $di->post->useSoft()->getAnswerCount($question) ?></span>
<?php       endif; ?>
            <span class="post-rank"><?= $question->rank ?></span>
            <span class="question-title"><a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a></span>
<?php       if (empty($hideUser)) : ?>
            <span class="question-meta">
                <span class="question-author">
<?php           if ($author) : ?>
                    <a href="<?= $this->url('user/' . $question->userId) ?>"><?= esc($author->username) ?></a>
                    <a href="<?= $this->url('user/' . $question->userId) ?>"><img src="<?= $author->getGravatar(25) ?>" alt=""></a>
<?php           else : ?>
                    <em>(Borttagen användare)</em>
                    <img src="<?= $author->getGravatar(25) ?>" alt="">
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
