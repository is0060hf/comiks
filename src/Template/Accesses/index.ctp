<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Access[]|\Cake\Collection\CollectionInterface $accesses
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Access'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="accesses index large-9 medium-8 columns content">
    <h3><?= __('Accesses') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('access_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ip_address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('host_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('referer') ?></th>
                <th scope="col"><?= $this->Paginator->sort('uri') ?></th>
                <th scope="col"><?= $this->Paginator->sort('browser_info') ?></th>
                <th scope="col"><?= $this->Paginator->sort('request_method') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($accesses as $access): ?>
            <tr>
                <td><?= $this->Number->format($access->id) ?></td>
                <td><?= h($access->url) ?></td>
                <td><?= h($access->access_time) ?></td>
                <td><?= h($access->ip_address) ?></td>
                <td><?= h($access->host_name) ?></td>
                <td><?= h($access->referer) ?></td>
                <td><?= h($access->uri) ?></td>
                <td><?= h($access->browser_info) ?></td>
                <td><?= h($access->request_method) ?></td>
                <td><?= h($access->created) ?></td>
                <td><?= h($access->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $access->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $access->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $access->id], ['confirm' => __('Are you sure you want to delete # {0}?', $access->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
