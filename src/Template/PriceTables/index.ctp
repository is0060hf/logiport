<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceTable[]|\Cake\Collection\CollectionInterface $priceTables
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Price Table'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cargo Prices'), ['controller' => 'CargoPrices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cargo Price'), ['controller' => 'CargoPrices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Count Prices'), ['controller' => 'CountPrices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Count Price'), ['controller' => 'CountPrices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Distance Prices'), ['controller' => 'DistancePrices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Distance Price'), ['controller' => 'DistancePrices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Waiting Prices'), ['controller' => 'WaitingPrices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Waiting Price'), ['controller' => 'WaitingPrices', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Working Prices'), ['controller' => 'WorkingPrices', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Working Price'), ['controller' => 'WorkingPrices', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="priceTables index large-9 medium-8 columns content">
    <h3><?= __('Price Tables') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('basic_price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('return_magnification') ?></th>
                <th scope="col"><?= $this->Paginator->sort('return_additional_fee') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cancel_fee') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($priceTables as $priceTable): ?>
            <tr>
                <td><?= $this->Number->format($priceTable->id) ?></td>
                <td><?= $priceTable->has('customer') ? $this->Html->link($priceTable->customer->id, ['controller' => 'Customers', 'action' => 'view', $priceTable->customer->id]) : '' ?></td>
                <td><?= $this->Number->format($priceTable->basic_price) ?></td>
                <td><?= $this->Number->format($priceTable->return_magnification) ?></td>
                <td><?= $this->Number->format($priceTable->return_additional_fee) ?></td>
                <td><?= $this->Number->format($priceTable->cancel_fee) ?></td>
                <td><?= h($priceTable->created) ?></td>
                <td><?= h($priceTable->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $priceTable->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $priceTable->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $priceTable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $priceTable->id)]) ?>
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
