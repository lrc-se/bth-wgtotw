<?php if (empty($hideTitle)) : ?>
<h1>Frågor</h1>
<?php $this->renderView('default/msgs'); ?>
<p><a class="btn" href="<?= $this->url('question/create') ?>">Skriv fråga</a></p>
<?php endif; ?>
<?php if (!empty($questions)) : ?>
<div class="questions">
    <ul class="post-list">
<?php   foreach ($questions as $question) : ?>
<?php       if ($question instanceof \WGTOTW\Models\PostVM) : ?>
<?php           $author = new \WGTOTW\Models\User(); ?>
<?php           $author->username = $question->username; ?>
<?php           $author->email = $question->email; ?>
<?php       else : ?>
<?php           $author = $question->user; ?>
<?php       endif; ?>
        <li <?= ($question->isAnswered() ? ' class="answered"' : '') ?>>
            <span class="post-type"><span class="icon-question"></span> <strong><?= $di->post->useSoft()->getAnswerCount($question) ?></strong></span>
            <span class="post-title">
                <a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a>
                <span class="post-rank"><?= $question->rank ?></span>
<?php       if ($question->isAnswered()) : ?>
                <span class="icon-accepted" title="Har ett accepterat svar"></span>
<?php       endif; ?>
            </span>
<?php       if (empty($hideUser)) : ?>
            <span class="post-meta">
                <span class="post-author">
<?php           if ($author && $author->username) : ?>
                    <a href="<?= $this->url('user/' . $question->userId) ?>"><?= esc($author->username) ?></a>
                    <a href="<?= $this->url('user/' . $question->userId) ?>"><img src="<?= $author->getGravatar(25) ?>" alt=""></a>
<?php           else : ?>
                    <em>(Borttagen användare)</em>
                    <img src="<?= (new \WGTOTW\Models\User())->getGravatar(25) ?>" alt="">
<?php           endif; ?>
                </span>
<?php       endif; ?>
                <span class="post-time"><?= $question->published ?></span>
            </span>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga frågor att visa</em></p>
<?php endif; ?>
