<?php

$comments = $di->post->getComments($post);

?>
<?php if (!empty($comments)) : ?>
<div class="comments">
    <ul>
<?php   foreach ($comments as $comment) : ?>
<?php       $this->renderView('comment/comment', ['comment' => $comment, 'post' => $post, 'user' => $user]); ?>
<?php   endforeach; ?>
    </ul>
</div>
<?php endif; ?>
