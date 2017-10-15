<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WGTOTW / <?= $title ?></title>
<?php foreach ($stylesheets as $stylesheet) : ?>
    <link rel="stylesheet" href="<?= $this->asset($stylesheet) ?>">
<?php endforeach; ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i">
    <!--<link rel="shortcut icon" href="<?= $this->asset('favicon.ico') ?>">-->
    <script>
        var WGTOTW = {
            basePath: "<?= $this->url('') ?>/"
        };
    </script>
</head>
<body>

<?php if ($this->regionHasContent('header')) : ?>
<div class="wrap header-wrap">
<?php $this->renderRegion('header') ?>
</div>
<?php endif; ?>

<?php if ($this->regionHasContent('main')) : ?>
<div class="wrap main-wrap">
    <main>
        <article>
<?php $this->renderRegion('main') ?>
        </article>
    </main>
</div>
<?php endif; ?>

<?php if ($this->regionHasContent('footer')) : ?>
<div class="wrap footer-wrap">
<?php $this->renderRegion('footer') ?>
</div>
<?php endif; ?>

<script src="<?= $this->asset('js/main.js') ?>" async></script>
</body>
</html>
