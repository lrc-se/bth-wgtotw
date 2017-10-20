<?php

$num = count($answers);

?>
<?php $this->renderView('default/msgs'); ?>
<?php if ($num) : ?>
<h3>Visar <?= $num ?> av <?= $total ?> svar</h3>
<?php else : ?>
<h3>Inga svar att visa</h3>
<?php endif; ?>
<p><strong>Fråga:</strong> <a href="<?= $this->url('question/' . $question->id) ?>"><?= esc($question->title) ?></a></p>
<p>
    <a class="btn btn-2" href="<?= $this->url('admin/question') ?>">Tillbaka till frågor</a>
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
                <th>Författare</th>
                <th>Publicerad</th>
                <th>Uppdaterad</th>
                <th>Raderad</th>
                <th>Åtgärd</th>
            </tr>
        </thead>
        <tbody>
<?php   foreach ($answers as $answer) : ?>
            <tr<?= ($answer->deleted ? ' class="deleted"' : '') ?>>
                <td><?= $answer->id ?></td>
                <td>
<?php       if ($answer->user) : ?>
                    <a href="<?= $this->url('user/' . $answer->userId) ?>"><?= esc($answer->user->username) ?></a>
<?php       else : ?>
                    <em>(Borttagen användare)</em>
<?php       endif; ?>
                </td>
                <td><?= $answer->published ?></td>
                <td><?= $answer->updated ?></td>
                <td><?= $answer->deleted ?></td>
                <td>
                    <a href="<?= $this->url('admin/answer/' . $answer->id . '/comment') ?>">Visa kommentarer</a><br>
<?php       if ($answer->deleted) : ?>
                    <a class="restore-link" href="#!" data-id="<?= $answer->id ?>">Återställ</a>
<?php       else : ?>
                    <a href="<?= $this->url('admin/answer/edit/' . $answer->id) ?>">Redigera</a><br>
                    <a href="<?= $this->url('admin/answer/delete/' . $answer->id) ?>">Ta bort</a>
<?php       endif; ?>
                </td>
            </tr>
<?php   endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->renderView('admin/restore', ['entity' => 'answer']); ?>
<?php endif; ?>
