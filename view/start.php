<h1>Översikt</h1>
<h2>Senaste frågorna</h2>
<?php $this->renderView('question/index', ['questions' => $questions, 'hideTitle' => true]); ?>
<div class="spacer"></div><div class="spacer"></div>
<div class="columns">
    <div class="column-2">
        <h2>Mest aktiva användare</h2>
        <ul class="post-list user-list">
<?php foreach ($activeUsers as $user) : ?>
<?php   $user2 = new \WGTOTW\Models\User(); ?>
<?php   $user2->email = $user->email; ?>
            <li>
                <span class="post-title">
                    <a href="<?= $this->url('user/' . $user->id) ?>"><img src="<?= $user2->getGravatar(25) ?>" alt=""></a>
                    <strong><a href="<?= $this->url('user/' . $user->id) ?>"><?= esc($user->username) ?></a></strong>
                </span>
                <span><span class="icon-message" title="Inlägg"></span> <?= $user->numPosts ?></span>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
    <div class="column-2">
        <h2>Mest använda taggar</h2>
        <ul class="post-list tag-list">
<?php foreach ($activeTags as $tag) : ?>
            <li>
                <span class="post-type"><span class="icon-tag"></span></span>
                <span class="post-title"><a href="<?= $this->url('tag/' . urlencode($tag->name)) ?>"><?= esc($tag->name) ?></a></span>
                <span class="nowrap"><span class="icon-question" title="Frågor"></span> <?= $tag->numPosts ?></span>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
</div>
