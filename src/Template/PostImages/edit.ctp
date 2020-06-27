<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PostImage $postImage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $postImage->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $postImage->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Post Images'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="postImages form large-9 medium-8 columns content">
    <?= $this->Form->create($postImage) ?>
    <fieldset>
        <legend><?= __('Edit Post Image') ?></legend>
        <?php
            echo $this->Form->control('post_id', ['options' => $posts]);
            echo $this->Form->control('image_path');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
