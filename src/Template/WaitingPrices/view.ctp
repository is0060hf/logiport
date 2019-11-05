<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WaitingPrice $waitingPrice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Waiting Price'), ['action' => 'edit', $waitingPrice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Waiting Price'), ['action' => 'delete', $waitingPrice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $waitingPrice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Waiting Prices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Waiting Price'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="waitingPrices view large-9 medium-8 columns content">
    <h3><?= h($waitingPrice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Price Table') ?></th>
            <td><?= $waitingPrice->has('price_table') ? $this->Html->link($waitingPrice->price_table->id, ['controller' => 'PriceTables', 'action' => 'view', $waitingPrice->price_table->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($waitingPrice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Waiting') ?></th>
            <td><?= $this->Number->format($waitingPrice->waiting) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($waitingPrice->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($waitingPrice->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($waitingPrice->modified) ?></td>
        </tr>
    </table>
</div>
