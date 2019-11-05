<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CountPrice $countPrice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Count Price'), ['action' => 'edit', $countPrice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Count Price'), ['action' => 'delete', $countPrice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $countPrice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Count Prices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Count Price'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="countPrices view large-9 medium-8 columns content">
    <h3><?= h($countPrice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Price Table') ?></th>
            <td><?= $countPrice->has('price_table') ? $this->Html->link($countPrice->price_table->id, ['controller' => 'PriceTables', 'action' => 'view', $countPrice->price_table->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($countPrice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Counts') ?></th>
            <td><?= $this->Number->format($countPrice->counts) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($countPrice->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($countPrice->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($countPrice->modified) ?></td>
        </tr>
    </table>
</div>
