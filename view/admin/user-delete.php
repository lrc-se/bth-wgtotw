<h4>Är du säker på att du vill ta bort användaren "<?= esc($user->username) ?>"?</h4>
<form action="<?= $this->currentUrl() ?>" method="post">
    <input type="hidden" name="action" value="delete">
    <input type="submit" value="Ta bort">
    <a class="btn btn-2" href="<?= $this->url('admin/user') ?>">Avbryt</a>
</form>
