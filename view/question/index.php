<?php if (empty($hideTitle)) : ?>
<h1>Frågor (<?= count($questions) ?>)</h1>
<?php $this->renderView('default/msgs'); ?>
<p><a class="btn" href="<?= $this->url('question/create') ?>">Skriv fråga</a></p>
<?php endif; ?>
<?php if (!empty($questions)) : ?>
<div class="questions">
    <ul class="post-list post-wrap">
<?php   foreach ($questions as $question) : ?>
<?php       $answerCount = $di->post->useSoft()->getAnswerCount($question); ?>
<?php       if ($question instanceof \WGTOTW\Models\PostVM) : ?>
<?php           $author = new \WGTOTW\Models\User(); ?>
<?php           $author->username = $question->username; ?>
<?php           $author->email = $question->email; ?>
<?php       else : ?>
<?php           $author = $question->user; ?>
<?php       endif; ?>
        <li <?= ($question->isAnswered() ? ' class="answered"' : '') ?>>
            <span class="post-type"><span class="icon-question"></span> <strong title="<?= $answerCount ?> svar"><?= $answerCount ?></strong></span>
            <span class="post-title">
                <a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a>
                <span class="nowrap">
                    <?php $this->renderView('post/rank', ['post' => $question]); ?>
<?php       if ($question->isAnswered()) : ?>
                    <span class="icon-accepted" title="Har ett accepterat svar"></span>
<?php       endif; ?>
                </span>
            </span>
<?php       if (empty($hideUser)) : ?>
            <span class="post-meta">
                <span class="post-author">
<?php           if ($author && $author->username) : ?>
                    <a href="<?= $this->url('user/' . $question->userId) ?>"><?= esc($author->username) ?></a>
                    <a href="<?= $this->url('user/' . $question->userId) ?>"><img src="<?= $author->getGravatar(25) ?>" alt=""></a>
<?php           else : ?>
                    <span>(Borttagen användare)</span>
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
