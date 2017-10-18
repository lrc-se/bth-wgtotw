<h1>Allt om sci-fi</h1>
<p>Välkommen...</p>

<h2>Senaste frågorna</h2>
<?php $this->renderView('question/index', ['questions' => $questions, 'hideTitle' => true]); ?>

<h2>Mest aktiva användare</h2>
<ul>
<?php foreach ($activeUsers as $user) : ?>
    <li>
        <a href="<?= $this->url('user/' . $user->id) ?>"><?= esc($user->username) ?></a> (<?= $user->numPosts ?> inlägg)
    </li>
<?php endforeach; ?>
</ul>
