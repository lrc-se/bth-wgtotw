<?php

switch ($type) {
    case 'question':
        $title = 'Ta bort fråga';
        $what = 'denna fråga';
        break;
    case 'answer':
        $title = 'Ta bort svar';
        $what = 'detta svar';
        break;
    case 'comment':
        $title = 'Ta bort kommentar';
        $what = 'denna kommentar';
        break;
}

?>
<h1><?= $title ?></h1>
<h5>Är du säker på att du vill ta bort <?= $what ?>?</h5>
<div class="spacer"></div>
<?php $this->renderView('admin/post-details', ['post' => $post]); ?>
<div class="spacer"></div>
<form action="<?= $this->currentUrl() ?>" method="post">
    <input type="hidden" name="action" value="delete">
    <input type="submit" value="Ta bort">
    <a class="btn btn-2" href="<?= $this->url($return) ?>">Avbryt</a>
</form>
