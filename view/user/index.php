<h1>Användare</h1>
<?php $this->renderView('default/msgs'); ?>
<?php if (!empty($users)) : ?>
<div class="users">
    <ul>
<?php   foreach ($users as $user) : ?>
        <li>
            <a href="<?= $this->url('user/' . $user->id) ?>"><?= esc($user->username) ?></a>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga användare att visa</em></p>
<?php endif; ?>
