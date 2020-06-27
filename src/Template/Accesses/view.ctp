<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Access $access
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Access'), ['action' => 'edit', $access->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Access'), ['action' => 'delete', $access->id], ['confirm' => __('Are you sure you want to delete # {0}?', $access->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Accesses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Access'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accesses view large-9 medium-8 columns content">
    <h3><?= h($access->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($access->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ip Address') ?></th>
            <td><?= h($access->ip_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Host Name') ?></th>
            <td><?= h($access->host_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Referer') ?></th>
            <td><?= h($access->referer) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Uri') ?></th>
            <td><?= h($access->uri) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Browser Info') ?></th>
            <td><?= h($access->browser_info) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Request Method') ?></th>
            <td><?= h($access->request_method) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($access->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Access Time') ?></th>
            <td><?= h($access->access_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($access->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($access->modified) ?></td>
        </tr>
    </table>
</div>
