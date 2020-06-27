<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PostImage $postImage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Post Image'), ['action' => 'edit', $postImage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Post Image'), ['action' => 'delete', $postImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postImage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Post Images'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post Image'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="postImages view large-9 medium-8 columns content">
    <h3><?= h($postImage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Post') ?></th>
            <td><?= $postImage->has('post') ? $this->Html->link($postImage->post->title, ['controller' => 'Posts', 'action' => 'view', $postImage->post->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image Path') ?></th>
            <td><?= h($postImage->image_path) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($postImage->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($postImage->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($postImage->modified) ?></td>
        </tr>
    </table>
</div>
