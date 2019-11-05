<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WorkingPrice[]|\Cake\Collection\CollectionInterface $workingPrices
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Working Price'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Price Tables'), ['controller' => 'PriceTables', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Price Table'), ['controller' => 'PriceTables', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="workingPrices index large-9 medium-8 columns content">
    <h3><?= __('Working Prices') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price_table_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('working') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($workingPrices as $workingPrice): ?>
            <tr>
                <td><?= $this->Number->format($workingPrice->id) ?></td>
                <td><?= $workingPrice->has('price_table') ? $this->Html->link($workingPrice->price_table->id, ['controller' => 'PriceTables', 'action' => 'view', $workingPrice->price_table->id]) : '' ?></td>
                <td><?= $this->Number->format($workingPrice->working) ?></td>
                <td><?= $this->Number->format($workingPrice->price) ?></td>
                <td><?= h($workingPrice->created) ?></td>
                <td><?= h($workingPrice->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $workingPrice->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $workingPrice->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $workingPrice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workingPrice->id)]) ?>
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
