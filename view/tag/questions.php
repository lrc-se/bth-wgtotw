<h1><?= esc($tag->name) ?></h1>
<?php $this->renderView('default/msgs'); ?>
<div class="tag-desc"><?= esc($tag->description) ?></div>
<h2>Frågor</h2>
<?php if (!empty($questions)) : ?>
<div class="questions">
    <ul>
<?php   foreach ($questions as $question) : ?>
        <li>
<?php       if ($question->isAnswered()) : ?>
            <span class="answered">!</span>
<?php       else : ?>
            <span class="unanswered">?</span>
<?php       endif; ?>
            <a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a>
            <a href="<?= $this->url('user/' . $question->userId) ?>"><?= esc($question->username) ?></a>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga frågor att visa</em></p>
<?php endif; ?>
