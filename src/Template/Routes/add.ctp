<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Route $route
 */
?>
<div class="breadcrumb_div">
    <ol class="breadcrumb m-b-20">
        <li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">伝票一覧</a></li>
        <li class="breadcrumb-item active">新規伝票登録</li>
    </ol>
</div>

<div class="routes form large-9 medium-8 columns content">
    <?= $this->Form->create($route) ?>
    <fieldset>
        <legend><?= __('Add Route') ?></legend>
        <?php
            echo $this->Form->control('voucher_id');
            echo $this->Form->control('on_ic');
            echo $this->Form->control('off_ic');
            echo $this->Form->control('price');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
