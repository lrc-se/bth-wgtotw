<?php

$numQuestions = count($questions);
$numAnswers = count($answers);
$numComments = count($comments);

?>
<h1><?= esc($user->username) ?></h1>
<?php $this->renderView('default/msgs'); ?>
<div class="user-summary">
    <p><img src="<?= $user->getGravatar(150) ?>" alt="Gravatar"></p>
<?php if (!$user->hideEmail) : ?>
    <div><span class="icon-mail" title="E-post"></span> <a href="mailto:<?= esc($user->email) ?>"><?= $user->email ?></a></div>
<?php endif; ?>
<?php if ($user->website) : ?>
    <div class="url"><span class="icon-link" title="Webbplats"></span> <a href="<?= esc($user->website) ?>"><?= $user->website ?></a></div>
<?php endif; ?>
    <div>
        <span>* <?= substr($user->created, 0, 10) ?></span>
    </div>
    <div>
        <span><span class="icon-award" title="Rykte"></span> <?= $reputation ?></span>
        <span><span class="icon-vote" title="Röster"></span> <?= $numVotes ?></span>
    </div>
    <div>
        <span class="icon-message" title="Inlägg"></span> <?= $numQuestions + $numAnswers + $numComments ?>
        <span class="icon-question" title="Frågor"></span> <?= $numQuestions ?>
        <span class="icon-answer" title="Svar"></span> <?= $numAnswers ?>
        <span class="icon-comment" title="Kommentarer"></span> <?= $numComments ?>
    </div>
</div>
<?php if ($curUser && $user->id == $curUser->id) : ?>
<p>
    <a class="btn" href="<?= $this->url('user/edit/' . $user->id) ?>">Redigera profil</a>
<?php   if ($curUser->isAdmin) : ?>
    <a class="btn" href="<?= $this->url('admin') ?>">Administration</a>
<?php   endif; ?>
    <a class="btn btn-2" href="<?= $this->url('user/logout') ?>">Logga ut</a>
</p>
<?php endif; ?>
<h2>Frågor</h2>
<?php $this->renderView('question/index', ['questions' => $questions, 'hideTitle' => true, 'hideUser' => true]); ?>
<h2>Svar</h2>
<?php if (!empty($answers)) : ?>
<ul class="post-list post-wrap">
<?php   foreach ($answers as $answer) : ?>
<?php       $question = $di->post->useSoft()->getById($answer->parentId); ?>
<?php       if ($question) : ?>
    <li>
        <span class="post-type"><span class="icon-answer"></span></span>
        <span class="post-title">
            <a href="<?= $this->url('question/' . $answer->parentId . '#answer-' . $answer->id) ?>"><?= esc($question->title) ?></a>
            <span class="post-rank"><?= $answer->rank ?></span>
        </span>
        <span class="post-time"><?= $answer->published ?></span>
    </li>
<?php       endif; ?>
<?php   endforeach; ?>
</ul>
<?php else : ?>
<p><em>Inga svar att visa</em></p>
<?php endif; ?>
<h2>Kommentarer</h2>
<?php if (!empty($comments)) : ?>
<ul class="post-list post-wrap">
<?php   foreach ($comments as $comment) : ?>
<?php       $parentPost = $di->post->useSoft()->getById($comment->parentId); ?>
<?php       if ($parentPost) : ?>
    <li>
        <span class="post-type"><span class="icon-comment"></span></span>
        <span class="post-title">
            <a href="<?= $this->url('question/' . ($parentPost->type == 'question' ? $comment->parentId : $parentPost->parentId) . '#comment-' . $comment->id) ?>">
                <?= esc(($parentPost->type == 'question' ? $parentPost->title : $di->post->getById($parentPost->parentId)->title)) ?></a>
            <span class="post-rank"><?= $comment->rank ?></span>
        </span>
        <span class="post-time"><?= $comment->published ?></span>
    </li>
<?php       endif; ?>
<?php   endforeach; ?>
</ul>
<?php else : ?>
<p><em>Inga kommentarer att visa</em></p>
<?php endif; ?>

