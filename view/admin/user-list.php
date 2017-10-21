<?php

$num = count($users);

?>
<h1>Administrera användare</h1>
<?php $this->renderView('default/msgs'); ?>
<p>
    <a class="btn" href="<?= $this->url('admin/user/create') ?>">Lägg till användare</a>
    <a class="btn btn-2" href="<?= $this->url('admin') ?>">Tillbaka till administration</a>
</p>
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
<h3>Visar <?= $num ?> av <?= $total ?> användare</h3>
<div class="xscroll">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Anv.namn</th>
                <th>E&#8209;post</th>
                <th>Webbplats</th>
                <th>Admin</th>
                <th>Raderad</th>
                <th>Åtgärd</th>
            </tr>
        </thead>
        <tbody>
<?php   foreach ($users as $user) : ?>
            <tr<?= ($user->deleted ? ' class="deleted"' : (is_null($user->username) ? ' class="anonymous"' : '')) ?>>
                <td><?= $user->id ?></td>
                <td><a href="<?= $this->url('user/' . $user->id) ?>"><?= esc($user->username) ?></a></td>
                <td><a href="mailto:<?= esc($user->email) ?>"><?= esc($user->email) ?></a></td>
<?php       if ($user->website) : ?>
                <td><a href="<?= esc($user->website) ?>"><?= esc($user->website) ?></a></td>
<?php       else : ?>
                <td>–</td>
<?php       endif; ?>
                <td><?= ($user->isAdmin ? 'Ja' : 'Nej') ?></td>
                <td><?= $user->deleted ?></td>
                <td>
<?php       if ($user->deleted) : ?>
                    <a class="restore-link" href="#!" data-id="<?= $user->id ?>">Återställ</a>
<?php       else : ?>
                    <a href="<?= $this->url('admin/user/edit/' . $user->id) ?>">Redigera</a><br>
<?php           if ($user->id != $admin->id) : ?>
                    <a href="<?= $this->url('admin/user/delete/' . $user->id) ?>">Ta bort</a>
<?php           endif; ?>
<?php       endif; ?>
                </td>
            </tr>
<?php   endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->renderView('admin/restore', ['entity' => 'user']); ?>
<?php else : ?>
<h3>Inga användare att visa</h3>
<?php endif; ?>
