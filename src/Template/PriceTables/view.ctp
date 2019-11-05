<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceTable $priceTable
 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a></li>
		<li class="breadcrumb-item active">顧客情報</li>
	</ol>
</div>
<div class="priceTables view large-9 medium-8 columns content">
    <h3><?= h($priceTable->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $priceTable->has('customer') ? $this->Html->link($priceTable->customer->id, ['controller' => 'Customers', 'action' => 'view', $priceTable->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($priceTable->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Basic Price') ?></th>
            <td><?= $this->Number->format($priceTable->basic_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Return Magnification') ?></th>
            <td><?= $this->Number->format($priceTable->return_magnification) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Return Additional Fee') ?></th>
            <td><?= $this->Number->format($priceTable->return_additional_fee) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cancel Fee') ?></th>
            <td><?= $this->Number->format($priceTable->cancel_fee) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($priceTable->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($priceTable->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Cargo Prices') ?></h4>
        <?php if (!empty($priceTable->cargo_prices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Price Table Id') ?></th>
                <th scope="col"><?= __('Cargo') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($priceTable->cargo_prices as $cargoPrices): ?>
            <tr>
                <td><?= h($cargoPrices->id) ?></td>
                <td><?= h($cargoPrices->price_table_id) ?></td>
                <td><?= h($cargoPrices->cargo) ?></td>
                <td><?= h($cargoPrices->price) ?></td>
                <td><?= h($cargoPrices->created) ?></td>
                <td><?= h($cargoPrices->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CargoPrices', 'action' => 'view', $cargoPrices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CargoPrices', 'action' => 'edit', $cargoPrices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CargoPrices', 'action' => 'delete', $cargoPrices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cargoPrices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Count Prices') ?></h4>
        <?php if (!empty($priceTable->count_prices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Price Table Id') ?></th>
                <th scope="col"><?= __('Counts') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($priceTable->count_prices as $countPrices): ?>
            <tr>
                <td><?= h($countPrices->id) ?></td>
                <td><?= h($countPrices->price_table_id) ?></td>
                <td><?= h($countPrices->counts) ?></td>
                <td><?= h($countPrices->price) ?></td>
                <td><?= h($countPrices->created) ?></td>
                <td><?= h($countPrices->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CountPrices', 'action' => 'view', $countPrices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CountPrices', 'action' => 'edit', $countPrices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CountPrices', 'action' => 'delete', $countPrices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $countPrices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Distance Prices') ?></h4>
        <?php if (!empty($priceTable->distance_prices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Price Table Id') ?></th>
                <th scope="col"><?= __('Distance') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($priceTable->distance_prices as $distancePrices): ?>
            <tr>
                <td><?= h($distancePrices->id) ?></td>
                <td><?= h($distancePrices->price_table_id) ?></td>
                <td><?= h($distancePrices->distance) ?></td>
                <td><?= h($distancePrices->price) ?></td>
                <td><?= h($distancePrices->created) ?></td>
                <td><?= h($distancePrices->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DistancePrices', 'action' => 'view', $distancePrices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DistancePrices', 'action' => 'edit', $distancePrices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DistancePrices', 'action' => 'delete', $distancePrices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $distancePrices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Waiting Prices') ?></h4>
        <?php if (!empty($priceTable->waiting_prices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Price Table Id') ?></th>
                <th scope="col"><?= __('Waiting') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($priceTable->waiting_prices as $waitingPrices): ?>
            <tr>
                <td><?= h($waitingPrices->id) ?></td>
                <td><?= h($waitingPrices->price_table_id) ?></td>
                <td><?= h($waitingPrices->waiting) ?></td>
                <td><?= h($waitingPrices->price) ?></td>
                <td><?= h($waitingPrices->created) ?></td>
                <td><?= h($waitingPrices->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'WaitingPrices', 'action' => 'view', $waitingPrices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'WaitingPrices', 'action' => 'edit', $waitingPrices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'WaitingPrices', 'action' => 'delete', $waitingPrices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $waitingPrices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Working Prices') ?></h4>
        <?php if (!empty($priceTable->working_prices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Price Table Id') ?></th>
                <th scope="col"><?= __('Working') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($priceTable->working_prices as $workingPrices): ?>
            <tr>
                <td><?= h($workingPrices->id) ?></td>
                <td><?= h($workingPrices->price_table_id) ?></td>
                <td><?= h($workingPrices->working) ?></td>
                <td><?= h($workingPrices->price) ?></td>
                <td><?= h($workingPrices->created) ?></td>
                <td><?= h($workingPrices->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'WorkingPrices', 'action' => 'view', $workingPrices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'WorkingPrices', 'action' => 'edit', $workingPrices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'WorkingPrices', 'action' => 'delete', $workingPrices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workingPrices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
