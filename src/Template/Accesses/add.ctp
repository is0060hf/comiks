<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Access $access
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Accesses'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="accesses form large-9 medium-8 columns content">
    <?= $this->Form->create($access) ?>
    <fieldset>
        <legend><?= __('Add Access') ?></legend>
        <?php
            echo $this->Form->control('url');
            echo $this->Form->control('access_time');
            echo $this->Form->control('ip_address');
            echo $this->Form->control('host_name');
            echo $this->Form->control('referer');
            echo $this->Form->control('uri');
            echo $this->Form->control('browser_info');
            echo $this->Form->control('request_method');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
