<?php
	/**
	 * @var \App\View\AppView                                                $this
	 * @var \App\Model\Entity\Voucher[]|\Cake\Collection\CollectionInterface $vouchers
	 */

    use Cake\Core\Configure;
    use Cake\ORM\TableRegistry;

    //フォームテンプレートを取得
    $form_template = Configure::read("form_template");

    //得意先のリスト
    $cstList = TableRegistry::get('Customers')->find()->all();
    $customersNameList = [];
    $customersNameList[''] = '未選択';
    foreach ($cstList as $cst) {
        if ($cst->customers_name != '') {
            $customersNameList[$cst->customers_name] = $cst->customers_name;
        }
    }
?>

<div class="row">
	<div class="col-6 breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a
						href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a>
			</li>
			<li class="breadcrumb-item"><a
						href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">伝票一覧</a>
			</li>
			<li class="breadcrumb-item active">内訳明細書生成生成</li>
		</ol>
	</div>
</div>

<div class="vouchers index large-9 medium-8 columns content">
    <?= $this->element('search_report') ?>

    <?= $this->Form->create(null, array(
        'templates' => $form_template,
        'type' => 'post',
        'idPrefix' => 'list_form',
        'name' => 'list_form'
    )); ?>

	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('deliveryman_name', '配達員', array('lock' => false)) ?></th>
			<th scope="col"><?= $this->Paginator->sort('customers_name', '得意先', array('direction' => 'asc')) ?></th>
			<th scope="col"><?= $this->Paginator->sort('delivery_dest', '搬入先', array('direction' => 'asc')) ?></th>
			<th scope="col"><?= $this->Paginator->sort('appendix', '備考', array('direction' => 'asc')) ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', '作成日', array('direction' => 'desc')) ?></th>
            <th scope="col" class="actions"><a href="#" id="index_selector_header"><?= __('選択') ?></a></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($vouchers as $voucher): ?>
			<tr>
				<td class="align-middle"><?= h($voucher->deliveryman_name) ?></td>
				<td class="align-middle"><?= h($voucher->customers_name) ?></td>
				<td class="align-middle"><?= h($voucher->delivery_dest) ?></td>
				<td class="align-middle"><?= h($voucher->appendix) ?></td>
				<td class="align-middle"><?= h($voucher->created) ?></td>
                <td class="actions align-middle">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input index_selecter" name="sel[]" value="<?= $voucher->id ?>"
                               id="customCheck<?= $voucher->id ?>">
                        <label class="custom-control-label" for="customCheck<?= $voucher->id ?>">選択</label>
                    </div>
                </td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?= $this->element('pagenate'); ?>

	<!--伝票情報の入力欄-->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="text-center">
						<p class="form-paragraph">伝票を作成するための情報を入力してください。</p>
					</div>

					<?php
						echo $this->Form->control('seikyuuduki', array(
								'label' => array(
										'text' => '請求月',       // labelで出力するテキスト
										'class' => 'col-form-label' // labelタグのクラス名
								),
								'type' => 'text',
								'templateVars' => array(
										'div_class' => 'form-group row',
										'div_tooltip' => 'tooltip',
										'div_tooltip_placement' => 'top',
										'div_tooltip_title' => '請求月を入力してください。'
								),
								'value' => date('m'),
								'id' => 'seikyuuduki',
								'class' => 'form-control'      // inputタグのクラス名
						));

						echo $this->Form->control('hakkoubi', array(
								'label' => array(
										'text' => '発行日',       // labelで出力するテキスト
										'class' => 'col-form-label' // labelタグのクラス名
								),
								'type' => 'text',
								'templateVars' => array(
										'div_class' => 'form-group row',
										'div_tooltip' => 'tooltip',
										'div_tooltip_placement' => 'top',
										'div_tooltip_title' => '請求書の発行日を入力してください。'
								),
								'value' => date('Y年m月t日'),
								'id' => 'hakkoubi',
								'class' => 'form-control'      // inputタグのクラス名
						));

						echo $this->Form->control('customers_name', array(
								'label' => array(
										'text' => '請求先',       // labelで出力するテキスト
										'class' => 'col-form-label' // labelタグのクラス名
								),
								'type' => 'select',
								'options' => $customersNameList,
								'templateVars' => array(
										'div_class' => 'form-group row',
										'div_tooltip' => 'tooltip',
										'div_tooltip_placement' => 'top',
										'div_tooltip_title' => '請求先の名前を選択してください。',
										'select_toggle' => 'select2'
								),
								'value' => $this->request->getData('customers_name'),
								'id' => 'customers_name',
								'class' => 'form-control select2'      // inputタグのクラス名
						));
					?>

					<div class="row my-2">
						<div class="col-12 text-center">
							<button class="btn btn-success mr-3" type="submit" name="submit_btn" value="utiwake_hakkou">
								<i class="fe-edit"></i>
								<span>内訳明細書を生成する</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= $this->Form->end(); ?>
</div>

