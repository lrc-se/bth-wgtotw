<?php

$numQuestions = count($questions);
$numAnswers = count($answers);
$numComments = count($comments);

?>
<h1><?= esc($user->username) ?></h1>
<?php $this->renderView('default/msgs'); ?>
<p><img src="<?= $user->getGravatar(100) ?>" alt="Gravatar"></p>
<?php if (!$user->hideEmail) : ?>
<div>E-post: <a href="mailto:<?= esc($user->email) ?>"><?= $user->email ?></a></div>
<?php endif; ?>
<?php if ($user->website) : ?>
<div>Webbplats: <a href="<?= esc($user->website) ?>"><?= $user->website ?></a></div>
<?php endif; ?>
<div class="user-reputation">Rykte: <?= $reputation ?></div>
<div class="user-posts">
    Frågor: <?= $numQuestions ?><br>
    Svar: <?= $numAnswers ?><br>
    Kommentarer: <?= $numComments ?><br>
    Totalt: <?= $numQuestions + $numAnswers + $numComments ?>
</div>
<div class="user-votes">Röster: <?= $numVotes ?></div>
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
<ul>
<?php   foreach ($answers as $answer) : ?>
    <li>
        <a href="<?= $this->url('question/' . $answer->parentId . '#answer-' . $answer->id) ?>"><?= esc($di->post->getById($answer->parentId)->title) ?></a>
        <span class="answer-time"><?= $answer->published ?></span>
    </li>
<?php   endforeach; ?>
</ul>
<?php else : ?>
<p><em>Inga svar att visa</em></p>
<?php endif; ?>
<h2>Kommentarer</h2>
<?php if (!empty($comments)) : ?>
<ul>
<?php   foreach ($comments as $comment) : ?>
<?php       $parentPost = $di->post->getById($comment->parentId); ?>
    <li>
        <a href="<?= $this->url('question/' . ($parentPost->type == 'question' ? $comment->parentId : $parentPost->parentId) . '#comment-' . $comment->id) ?>">
            <?= esc(($parentPost->type == 'question' ? $parentPost->title : $di->post->getById($parentPost->parentId)->title)) ?>
        </a>
        <span class="comment-time"><?= $comment->published ?></span>
    </li>
<?php   endforeach; ?>
</ul>
<?php else : ?>
<p><em>Inga kommentarer att visa</em></p>
<?php endif; ?>

