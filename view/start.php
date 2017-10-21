<h1>Allt om sci-fi</h1>
<p>Välkommen...</p>

<h2>Senaste frågorna</h2>
<?php $this->renderView('question/index', ['questions' => $questions, 'hideTitle' => true]); ?>

<div class="spacer"></div><div class="spacer"></div>

<div class="columns">
    <div class="column-2">
        <h2>Mest aktiva användare</h2>
        <ul class="post-list">
<?php foreach ($activeUsers as $user) : ?>
<?php   $user2 = new \WGTOTW\Models\User(); ?>
<?php   $user2->email = $user->email; ?>
            <li>
                <span class="post-title">
                    <a href="<?= $this->url('user/' . $user->id) ?>"><img src="<?= $user2->getGravatar(25) ?>" alt=""></a>
                    <strong><a href="<?= $this->url('user/' . $user->id) ?>"><?= esc($user->username) ?></a></strong>
                </span>
                <span><strong><?= $user->numPosts ?></strong> inlägg</span>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
    <div class="column-2">
        <h2>Mest använda taggar</h2>
        <ul class="post-list">
<?php foreach ($activeTags as $tag) : ?>
            <li>
                <span class="post-title"><a href="<?= $this->url('tag/' . urlencode($tag->name)) ?>"><?= esc($tag->name) ?></a></span>
                <span><?= ($tag->numPosts == 1 ? '<strong>1</strong> fråga' : '<strong>' . $tag->numPosts . '</strong> frågor') ?></span>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
</div>
