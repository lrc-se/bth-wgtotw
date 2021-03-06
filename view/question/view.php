<h1><?= esc($question->title) ?></h1>
<?php $this->renderView('default/msgs'); ?>
<?php $this->renderView('question/question', $data); ?>
<h2 id="answers">Svar (<?= count($answers) ?>)</h2>
<p><a class="btn" href="<?= $this->url('question/' . $question->id . '/answer') ?>">Skriv ett svar</a></p>
<?php if (!empty($answers)) : ?>
<div class="answers">
    <form action="<?= $di->request->getCurrentUrl() ?>#answers">
        <label for="sort">Sortering:</label>
        <select id="sort" class="input-small" name="sort" onchange="this.form.submit()">
<?php   foreach ($sortOptions as $option => $value) : ?>
            <option value="<?= $value ?>"<?= ($sort == $value ? ' selected' : '') ?>><?= $option ?></option>
<?php   endforeach; ?>
        </select>
    </form>
    <ul>
<?php   foreach ($answers as $answer) : ?>
        <li id="answer-<?= $answer->id ?>"<?= ($answer->isAccepted() ? ' class="accepted"' : '') ?>>
<?php $this->renderView('answer/answer', ['answer' => $answer, 'question' => $question, 'user' => $user, 'canComment' => true]); ?>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga svar att visa</em></p>
<?php endif; ?>
<script>
    (function(doc) {
        var anchor = doc.location.hash;
        if (anchor && (anchor.substring(0, 8) == "#answer-" || anchor.substring(0, 9) == "#comment-")) {
            var el = doc.querySelector(anchor);
            if (el) {
                el.classList.add("attention");
            }
        }
    })(document);
</script>
