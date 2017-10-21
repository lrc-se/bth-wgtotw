<h1>Användare</h1>
<?php $this->renderView('default/msgs'); ?>
<?php if (!empty($users)) : ?>
<div class="users">
    <ul class="post-list">
<?php   foreach ($users as $user) : ?>
        <li>
            <span class="post-title">
                <a href="<?= $this->url('user/' . $user->id) ?>"><img src="<?= $user->getGravatar(25) ?>" alt=""></a>
                <strong><a href="<?= $this->url('user/' . $user->id) ?>"><?= esc($user->username) ?></a></strong>
            </span>
            <span>
                <span><span class="icon-award" title="Rykte"></span> <?= $di->user->getReputation($user) ?></span>
                <span><span class="icon-message" title="Inlägg"></span> <?= $di->repository->posts->countSoft('userId = ?', [$user->id]) ?></span>
            </span>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php else : ?>
<p><em>Inga användare att visa</em></p>
<?php endif; ?>
