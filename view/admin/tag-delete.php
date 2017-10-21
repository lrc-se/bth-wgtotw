<h1>Ta bort tagg</h1>
<h5>Är du säker på att du vill ta bort taggen "<?= esc($tag->name) ?>"? Detta kan inte ångras!</h5>
<div class="spacer"></div>
<form action="<?= $this->currentUrl() ?>" method="post">
    <input type="hidden" name="action" value="delete">
    <input type="submit" value="Ta bort">
    <a class="btn btn-2" href="<?= $this->url('admin/tag') ?>">Avbryt</a>
</form>
