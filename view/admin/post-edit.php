<?php

$data[$post->type] = $post;

?>
<h1><?= $title ?></h1>
<?php $this->renderView('default/msgs'); ?>
<?php $this->renderView($post->type . '/form', $data); ?>
