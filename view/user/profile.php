<h1><?= esc($user->username) ?></h1>
<?php $this->renderView('default/msgs'); ?>
<p><img src="<?= $user->getGravatar(100) ?>" alt="Gravatar"></p>
<div class="user-reputation"><?= $reputation ?></div>
<?php if ($curUser && $user->id == $curUser->id) : ?>
<p>
    <a class="btn" href="<?= $this->url('user/edit/' . $user->id) ?>">Redigera profil</a>
    <a class="btn btn-2" href="<?= $this->url('user/logout') ?>">Logga ut</a>
</p>
<?php endif; ?>
