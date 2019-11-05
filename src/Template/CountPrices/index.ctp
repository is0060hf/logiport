<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CountPrice[]|\Cake\Collection\CollectionInterface $countPrices
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Count Price'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="countPrices index large-9 medium-8 columns content">
    <h3><?= __('Count Prices') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price_table_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('counts') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($countPrices as $countPrice): ?>
            <tr>
                <td><?= $this->Number->format($countPrice->id) ?></td>
                <td><?= $countPrice->has('price_table') ? $this->Html->link($countPrice->price_table->id, ['controller' => 'PriceTables', 'action' => 'view', $countPrice->price_table->id]) : '' ?></td>
                <td><?= $this->Number->format($countPrice->counts) ?></td>
                <td><?= $this->Number->format($countPrice->price) ?></td>
                <td><?= h($countPrice->created) ?></td>
                <td><?= h($countPrice->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $countPrice->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $countPrice->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $countPrice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $countPrice->id)]) ?>
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
