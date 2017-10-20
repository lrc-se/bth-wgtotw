<?php

switch ($type) {
    case 'question':
        $title = 'denna fråga';
        break;
    case 'answer':
        $title = 'detta svar';
        break;
    case 'comment':
        $title = 'denna kommentar';
        break;
}

?>
<h4>Är du säker på att du vill ta bort <?= $title ?>?</h4>
<?php $this->renderView('admin/post-details', ['post' => $post]); ?>
<form action="<?= $this->currentUrl() ?>" method="post">
    <input type="hidden" name="action" value="delete">
    <input type="submit" value="Ta bort">
    <a class="btn btn-2" href="<?= $this->url("admin/$type") ?>">Avbryt</a>
</form>
