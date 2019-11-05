<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DistancePrice $distancePrice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Distance Price'), ['action' => 'edit', $distancePrice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Distance Price'), ['action' => 'delete', $distancePrice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $distancePrice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Distance Prices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Distance Price'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="distancePrices view large-9 medium-8 columns content">
    <h3><?= h($distancePrice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Price Table') ?></th>
            <td><?= $distancePrice->has('price_table') ? $this->Html->link($distancePrice->price_table->id, ['controller' => 'PriceTables', 'action' => 'view', $distancePrice->price_table->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($distancePrice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Distance') ?></th>
            <td><?= $this->Number->format($distancePrice->distance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($distancePrice->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($distancePrice->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($distancePrice->modified) ?></td>
        </tr>
    </table>
</div>
