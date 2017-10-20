<?php

$num = count($questions);

?>
<?php $this->renderView('default/msgs'); ?>
<?php if ($num) : ?>
<h3>Visar <?= $num ?> av <?= ($total == 1 ? '1 fråga' : "$total frågor") ?></h3>
<?php else : ?>
<h3>Inga frågor att visa</h3>
<?php endif; ?>
<p>
    <a class="btn btn-2" href="<?= $this->url('admin') ?>">Tillbaka till administration</a>
</p>
<form action="<?= $this->currentUrl() ?>">
    <p>
        <label for="status">Visa:</label>
        <select id="status" name="status" onchange="this.form.submit()">
            <option value="">Alla</option>
            <option value="active"<?= ($status == 'active' ? ' selected' : '') ?>>Endast aktiva</option>
            <option value="inactive"<?= ($status == 'inactive' ? ' selected' : '') ?>>Endast inaktiva</option>
        </select>
    </p>
</form>
<?php if ($num) : ?>
<div class="xscroll">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Rubrik</th>
                <th>Författare</th>
                <th>Publicerad</th>
                <th>Uppdaterad</th>
                <th>Raderad</th>
                <th>Åtgärd</th>
            </tr>
        </thead>
        <tbody>
<?php   foreach ($questions as $question) : ?>
            <tr<?= ($question->deleted ? ' class="deleted"' : '') ?>>
                <td><?= $question->id ?></td>
                <td><a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a></td>
                <td>
<?php       if ($question->user) : ?>
                    <a href="<?= $this->url('user/' . $question->userId) ?>"><?= esc($question->user->username) ?></a>
<?php       else : ?>
                    <em>(Borttagen användare)</em>
<?php       endif; ?>
                </td>
                <td><?= $question->published ?></td>
                <td><?= $question->updated ?></td>
                <td><?= $question->deleted ?></td>
                <td>
                    <a href="<?= $this->url('admin/question/' . $question->id . '/answer') ?>">Visa svar</a><br>
                    <a href="<?= $this->url('admin/question/' . $question->id . '/comment') ?>">Visa kommentarer</a><br>
<?php       if ($question->deleted) : ?>
                    <a class="restore-link" href="#!" data-id="<?= $question->id ?>">Återställ</a>
<?php       else : ?>
                    <a href="<?= $this->url('admin/question/edit/' . $question->id) ?>">Redigera</a><br>
                    <a href="<?= $this->url('admin/question/delete/' . $question->id) ?>">Ta bort</a>
<?php       endif; ?>
                </td>
            </tr>
<?php   endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->renderView('admin/restore', ['entity' => 'question']); ?>
<?php endif; ?>
