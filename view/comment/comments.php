<?php

$comments = $di->post->useSoft()->getComments($post);

?>
<?php if (!empty($comments)) : ?>
<div class="comments">
    <ul>
<?php   foreach ($comments as $comment) : ?>
        <li>
<?php       $this->renderView('comment/comment', ['comment' => $comment, 'post' => $post, 'user' => $user]); ?>
        </li>
<?php   endforeach; ?>
    </ul>
</div>
<?php endif; ?>
