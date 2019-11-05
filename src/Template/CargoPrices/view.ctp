<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CargoPrice $cargoPrice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cargo Price'), ['action' => 'edit', $cargoPrice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cargo Price'), ['action' => 'delete', $cargoPrice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cargoPrice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cargo Prices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cargo Price'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cargoPrices view large-9 medium-8 columns content">
    <h3><?= h($cargoPrice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Price Table') ?></th>
            <td><?= $cargoPrice->has('price_table') ? $this->Html->link($cargoPrice->price_table->id, ['controller' => 'PriceTables', 'action' => 'view', $cargoPrice->price_table->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cargoPrice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cargo') ?></th>
            <td><?= $this->Number->format($cargoPrice->cargo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($cargoPrice->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($cargoPrice->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($cargoPrice->modified) ?></td>
        </tr>
    </table>
</div>
