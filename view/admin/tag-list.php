<?php

$num = count($tags);

?>
<h1>Administrera taggar</h1>
<?php $this->renderView('default/msgs'); ?>
<p>
    <a class="btn" href="<?= $this->url('admin/tag/create') ?>">Lägg till tagg</a>
    <a class="btn btn-2" href="<?= $this->url('admin') ?>">Tillbaka till administration</a>
</p>
<?php if ($num) : ?>
<h3>Visar <?= ($num == 1 ? '1 tagg' : "$num taggar") ?></h3>
<?php else : ?>
<h3>Inga taggar att visa</h3>
<?php endif; ?>
<?php if ($num) : ?>
<div class="xscroll">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Namn</th>
                <th>Beskrivning</th>
                <th>Skapad</th>
                <th>Uppdaterad</th>
                <th>Åtgärd</th>
            </tr>
        </thead>
        <tbody>
<?php   foreach ($tags as $tag) : ?>
            <tr>
                <td><?= $tag->id ?></td>
                <td><a href="<?= $this->url('tag/' . urlencode($tag->name)) ?>"><?= esc($tag->name) ?></a></td>
                <td><?= esc($tag->description) ?></td>
                <td><?= $tag->created ?></td>
                <td><?= $tag->updated ?></td>
                <td>
                    <a href="<?= $this->url('admin/tag/edit/' . $tag->id) ?>">Redigera</a><br>
                    <a href="<?= $this->url('admin/tag/delete/' . $tag->id) ?>">Ta bort</a>
                </td>
            </tr>
<?php   endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
