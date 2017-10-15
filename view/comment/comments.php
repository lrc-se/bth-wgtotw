<?php if (!empty($comments)) : ?>
<div class="comments">
    <ul>
<?php   foreach ($comments as $comment) : ?>
<?php       $this->renderView('comment/comment', ['comment' => $comment]); ?>
<?php   endforeach; ?>
    </ul>
</div>
<?php endif; ?>
