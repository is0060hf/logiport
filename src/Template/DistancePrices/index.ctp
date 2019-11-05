<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DistancePrice[]|\Cake\Collection\CollectionInterface $distancePrices
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Distance Price'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="distancePrices index large-9 medium-8 columns content">
    <h3><?= __('Distance Prices') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price_table_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('distance') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($distancePrices as $distancePrice): ?>
            <tr>
                <td><?= $this->Number->format($distancePrice->id) ?></td>
                <td><?= $distancePrice->has('price_table') ? $this->Html->link($distancePrice->price_table->id, ['controller' => 'PriceTables', 'action' => 'view', $distancePrice->price_table->id]) : '' ?></td>
                <td><?= $this->Number->format($distancePrice->distance) ?></td>
                <td><?= $this->Number->format($distancePrice->price) ?></td>
                <td><?= h($distancePrice->created) ?></td>
                <td><?= h($distancePrice->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $distancePrice->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $distancePrice->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $distancePrice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $distancePrice->id)]) ?>
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
