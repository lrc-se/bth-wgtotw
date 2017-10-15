<h1><?= esc($question->title) ?></h1>
<div class="question">
    <div class="question-text"><?= $this->di->textfilter->markdown(esc($question->text)) ?></div>
    <div class="question-author"><a href="<?= $this->url('user/' . $question->user->id) ?>"><?= esc($question->user->username) ?></a></div>
    <div class="question-time">
        <div class="question-published">Skriven <?= $question->published ?></div>
<?php if ($question->updated) : ?>
        <div class="question-updated">Uppdaterad <?= $question->updated ?></div>
<?php endif; ?>
    </div>
<?php if (!empty($tags)) : ?>
    <div class="question-tags">
        Taggar:
        <ul>
<?php   foreach ($tags as $tag) : ?>
            <li><a href="<?= $this->url('tag/' . urlencode($tag->name)) ?>"><?= esc($tag->name) ?></a></li>
<?php   endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php $this->renderView('comment/comments', ['comments' => $comments]); ?>
</div>
<h2>Svar</h2>
<?php if (!empty($answers)) : ?>
<div class="answers">
    <ul>
<?php   foreach ($answers as $answer) : ?>
        <li>
            <div class="answer-text"><?= markdown($answer->text) ?></div>
            <div class="answer-author"><a href="<?= $this->url('user/' . $answer->user->id) ?>"><?= esc($answer->user->username) ?></a></div>
<?php $this->renderView('comment/comments', ['comments' => $di->post->getComments($answer)]); ?>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga svar att visa</em></p>
<?php endif; ?>
