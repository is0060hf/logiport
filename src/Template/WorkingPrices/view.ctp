<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WorkingPrice $workingPrice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Working Price'), ['action' => 'edit', $workingPrice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Working Price'), ['action' => 'delete', $workingPrice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workingPrice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Working Prices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Working Price'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="workingPrices view large-9 medium-8 columns content">
    <h3><?= h($workingPrice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Price Table') ?></th>
            <td><?= $workingPrice->has('price_table') ? $this->Html->link($workingPrice->price_table->id, ['controller' => 'PriceTables', 'action' => 'view', $workingPrice->price_table->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($workingPrice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Working') ?></th>
            <td><?= $this->Number->format($workingPrice->working) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($workingPrice->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($workingPrice->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($workingPrice->modified) ?></td>
        </tr>
    </table>
</div>
