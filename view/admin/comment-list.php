<?php

$num = count($comments);
if ($parent->type == 'answer') {
    $question = $di->post->getById($parent->parentId, 'question');
}

?>
<h1>Administrera kommentarer</h1>
<?php $this->renderView('default/msgs'); ?>
<p>
<?php if ($parent->type == 'answer') : ?>
    <a class="btn btn-2" href="<?= $this->url('admin/question/' . $question->id . '/answer') ?>">Tillbaka till svar</a>
<?php endif; ?>
    <a class="btn btn-2" href="<?= $this->url('admin/question') ?>">Tillbaka till frågor</a>
    <a class="btn btn-2" href="<?= $this->url('admin') ?>">Tillbaka till administration</a>
</p>
<?php if ($parent->type == 'question') : ?>
<h2>Fråga</h2>
<ul class="post-list">
    <li>
        <span class="icon-question"></span> <a href="<?= $this->url('question/' . $parent->id) ?>"><?= esc($parent->title) ?></a>
    </li>
</ul>
<div class="spacer"></div>
<?php   if ($parent->deleted) : ?>
<?php       if ($parent->type == 'question') : ?>
<div class="msg warning"><div><strong>OBS!</strong> Frågan är borttagen och kommentarerna visas därför inte för besökare.</div></div>
<?php       elseif ($parent->type == 'answer') : ?>
<div class="msg warning"><div><strong>OBS!</strong> Svaret är borttaget och kommentarerna visas därför inte för besökare.</div></div>
<?php       endif; ?>
<?php   endif; ?>
<?php else : ?>
<h2>Svar till fråga</h2>
<ul class="post-list">
    <li>
        <span class="icon-question"></span> <a href="<?= $this->url('question/' . $question->id . '#answer-' . $parent->id) ?>"><?= esc($question->title) ?></a>
    </li>
</ul>
<div class="spacer"></div>
<?php   if ($question->deleted) : ?>
<div class="msg warning"><div><strong>OBS!</strong> Frågan är borttagen och kommentarerna visas därför inte för besökare.</div></div>
<?php   elseif ($parent->type == 'answer' && $parent->deleted) : ?>
<div class="msg warning"><div><strong>OBS!</strong> Svaret är borttaget och kommentarerna visas därför inte för besökare.</div></div>
<?php   endif; ?>
<?php endif; ?>
<div class="spacer"></div>
<form action="<?= $this->currentUrl() ?>">
    <p>
        <label for="status">Visa:</label>
        <select id="status" class="input-small" name="status" onchange="this.form.submit()">
            <option value="">Alla</option>
            <option value="active"<?= ($status == 'active' ? ' selected' : '') ?>>Endast aktiva</option>
            <option value="inactive"<?= ($status == 'inactive' ? ' selected' : '') ?>>Endast inaktiva</option>
        </select>
    </p>
</form>
<?php if ($num) : ?>
<h3>Visar <?= $num ?> av <?= ($total == 1 ? '1 kommentar' : "$total kommentarer") ?></h3>
<div class="xscroll">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Författare</th>
                <th>Publicerad</th>
                <th>Uppdaterad</th>
                <th>Raderad</th>
                <th>Åtgärd</th>
            </tr>
        </thead>
        <tbody>
<?php   foreach ($comments as $comment) : ?>
            <tr<?= ($comment->deleted ? ' class="deleted"' : '') ?>>
                <td><?= $comment->id ?></td>
                <td>
<?php       if ($comment->user) : ?>
                    <a href="<?= $this->url('user/' . $comment->userId) ?>"><?= esc($comment->user->username) ?></a>
<?php       else : ?>
                    <span>(Borttagen användare)</span>
<?php       endif; ?>
                </td>
                <td><?= $comment->published ?></td>
                <td><?= $comment->updated ?></td>
                <td><?= $comment->deleted ?></td>
                <td>
                    <a href="<?= $this->url('admin/comment/' . $comment->id) ?>">Visa kommentar</a><br>
<?php       if ($comment->deleted) : ?>
                    <a class="restore-link" href="#!" data-id="<?= $comment->id ?>">Återställ</a>
<?php       else : ?>
                    <a href="<?= $this->url('admin/comment/edit/' . $comment->id) ?>">Redigera</a><br>
                    <a href="<?= $this->url('admin/comment/delete/' . $comment->id) ?>">Ta bort</a>
<?php       endif; ?>
                </td>
            </tr>
<?php   endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->renderView('admin/restore', ['entity' => 'comment']); ?>
<?php else : ?>
<h3>Inga kommentarer att visa</h3>
<?php endif; ?>
