<?php
	/**
	 * @var \App\View\AppView                                                $this
	 * @var \App\Model\Entity\Voucher[]|\Cake\Collection\CollectionInterface $vouchers
	 */

	use Cake\ORM\TableRegistry;

	$cstList = TableRegistry::get('Customers')->find()->all();
	$userList = TableRegistry::get('Users')->find()->all();
	$voucherList = TableRegistry::get('Vouchers')->find()->all();

	$customersNameList = [];
	$customersNameList[''] = '未選択';
	$usersNameList = [];
	$usersNameList[''] = '未選択';
	$deliveryDestinationList = [];
	$deliveryDestinationList[''] = '未選択';

	foreach ($voucherList as $vItem) {
		if ($vItem->delivery_dest != '') {
			$deliveryDestinationList[$vItem->delivery_dest] = $vItem->delivery_dest;
		}
	}
	foreach ($cstList as $cst) {
		if ($cst->customers_name != '') {
			$customersNameList[$cst->customers_name] = $cst->customers_name;
		}
	}
	foreach ($userList as $usr) {
		if ($usr->username != '') {
			$usersNameList[$usr->username] = $usr->username;
		}
	}
?>
<div class="row">
	<div class="col-6 breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
			<li class="breadcrumb-item active">伝票一覧</li>
		</ol>
	</div>
	<div class="col-6 text-right">
		<a href="<?= $this->Url->build(['controller' => 'Vouchers', 'action' => 'add']); ?>" class="btn btn-success mt-2">
			<i class="fe-git-pull-request"></i>
			<span>新規登録する</span>
		</a>
		<?php
			if ($this->request->session()->read('Auth.User.user_role') == 'システム管理者') {
				?>
				<a href="<?= $this->Url->build(['controller' => 'Vouchers', 'action' => 'seikyuu']); ?>" class="btn btn-success mt-2">
					<i class="fe-edit"></i>
					<span>帳票を生成する</span>
				</a>
				<?php
			}
		?>
	</div>
</div>

<div class="vouchers index large-9 medium-8 columns content">
	<?php
		$form_template = array(
				'error' => '<div class="col-sm-12 error-message alert alert-danger mt-1 mb-2 py-1">{{content}}</div>',
				'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
				'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10 d-flex align-items-center">{{input}}</div>',
				'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
				'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
				'input' => '<input class="form-control" type="{{type}}" name="{{name}}" {{attrs}} data-toggle="{{data_toggle}}" maxlength="{{max_length}}" data-mask-format="{{data_mask_format}}">',
				'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
				'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>'
		);
	?>

	<?= $this->Form->create(null, array(
			'templates' => $form_template,
			'type' => 'get',
			'idPrefix' => 'search_form',
			'name' => 'search_form'
	)); ?>

	<legend><?= __('伝票一覧') ?></legend>

	<!--検索条件の項目-->
	<?php
		if ($this->request->session()->read('Auth.User.user_role') == 'システム管理者') {
			?>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p class="form-paragraph">伝票を検索するための条件を入力してください。</p>
							</div>

							<?php
								echo $this->Form->control('deliveryman_name', array(
										'label' => array(
												'text' => '配達員名',       // labelで出力するテキスト
												'class' => 'col-form-label' // labelタグのクラス名
										),
										'type' => 'select',
										'options' => $usersNameList,
										'templateVars' => array(
												'div_class' => 'form-group row',
												'div_tooltip' => 'tooltip',
												'div_tooltip_placement' => 'top',
												'div_tooltip_title' => '絞り込みたい配達員の名前を入力してください。',
												'select_toggle' => 'select2'
										),
										'value' => $this->request->getQuery('deliveryman_name'),
										'id' => 'deliveryman_name',
										'class' => 'form-control select2'      // inputタグのクラス名
								));

								echo $this->Form->control('customers_name', array(
										'label' => array(
												'text' => '得意先',       // labelで出力するテキスト
												'class' => 'col-form-label' // labelタグのクラス名
										),
										'type' => 'select',
										'options' => $customersNameList,
										'templateVars' => array(
												'div_class' => 'form-group row',
												'div_tooltip' => 'tooltip',
												'div_tooltip_placement' => 'top',
												'div_tooltip_title' => '絞り込みたい得意先を入力してください。',
												'select_toggle' => 'select2'
										),
										'value' => $this->request->getQuery('customers_name'),
										'id' => 'customers_name',
										'class' => 'form-control select2'      // inputタグのクラス名
								));

								echo $this->Form->control('delivery_dest', array(
										'label' => array(
												'text' => '積込先',       // labelで出力するテキスト
												'class' => 'col-form-label' // labelタグのクラス名
										),
										'type' => 'select',
										'options' => $deliveryDestinationList,
										'templateVars' => array(
												'div_class' => 'form-group row',
												'div_tooltip' => 'tooltip',
												'div_tooltip_placement' => 'top',
												'div_tooltip_title' => '絞り込みたい積込先の名称を入力してください。',
												'select_toggle' => 'select2'
										),
										'value' => $this->request->getQuery('delivery_dest'),
										'id' => 'delivery_dest',
										'class' => 'form-control select2'      // inputタグのクラス名
								));

								echo $this->Form->control('upper_created', array(
										'label' => array(
												'text' => '作成日（上限）',       // labelで出力するテキスト
												'class' => 'col-form-label' // labelタグのクラス名
										),
										'type' => 'text',
										'templateVars' => array(
												'div_class' => 'form-group row',
												'div_tooltip' => 'tooltip',
												'div_tooltip_placement' => 'top',
												'div_tooltip_title' => '絞り込みたい伝票作成日(上限)を入力してください。(例：2000/01/01)',
												'data_mask_format' => '0000/00/00',
												'data_toggle' => 'input-mask',
												'max_length' => '10'
										),
										'value' => $this->request->getQuery('upper_created'),
										'class' => 'form-control',      // inputタグのクラス名
										'id' => 'upper_created',
								));

								echo $this->Form->control('under_created', array(
										'label' => array(
												'text' => '作成日（下限）',       // labelで出力するテキスト
												'class' => 'col-form-label' // labelタグのクラス名
										),
										'type' => 'text',
										'templateVars' => array(
												'div_class' => 'form-group row',
												'div_tooltip' => 'tooltip',
												'div_tooltip_placement' => 'top',
												'div_tooltip_title' => '絞り込みたい伝票作成日(下限)を入力してください。(例：2000/02/01)',
												'data_mask_format' => '0000/00/00',
												'data_toggle' => 'input-mask',
												'max_length' => '10'
										),
										'value' => $this->request->getQuery('under_created'),
										'class' => 'form-control',      // inputタグのクラス名
										'id' => 'under_created',
								));

								echo $this->Form->control('appendix', array(
										'label' => array(
												'text' => '備考',       // labelで出力するテキスト
												'class' => 'col-form-label' // labelタグのクラス名
										),
										'templateVars' => array(
												'div_class' => 'form-group row',
												'div_tooltip' => 'tooltip',
												'div_tooltip_placement' => 'top',
												'div_tooltip_title' => '絞り込みたい備考を入力してください。部分一致で検索されます。'
										),
										'value' => $this->request->getQuery('appendix'),
										'class' => 'form-control',      // inputタグのクラス名
										'id' => 'appendix',
										'rows' => '3'
								));
							?>

							<div class="row my-2">
								<div class="col-12 text-center">
									<button class="btn btn-outline-dark mr-3" type="button" name="submit_btn" value="clear"
									        onclick="clearSearchElementsInSeikyuu();document.search_form.submit();">
										<i class="fe-edit"></i>
										<span>検索条件クリア</span>
									</button>
									<button class="btn btn-primary mr-3" type="submit" name="submit_btn" value="search">
										<i class="fe-edit"></i>
										<span>検索</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	?>

	<?= $this->Form->end(); ?>

	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
			<th scope="col"><?= $this->Paginator->sort('deliveryman_name', '配達員') ?></th>
			<th scope="col"><?= $this->Paginator->sort('customers_name', '得意先') ?></th>
			<th scope="col"><?= $this->Paginator->sort('appendix', '備考') ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', '作成日') ?></th>
			<th scope="col" class="actions"><?= __('操作') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($vouchers as $voucher): ?>
			<tr>
				<td class="align-middle"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'view', $voucher->id]); ?>" class="btn btn-info"><?= $this->Number->format($voucher->id) ?></a></td>
				<td class="align-middle"><?= h($voucher->deliveryman_name) ?></td>
				<td class="align-middle"><?= h($voucher->customers_name) ?></td>
				<td class="align-middle"><?= h($voucher->appendix) ?></td>
				<td class="align-middle"><?= h($voucher->created) ?></td>
				<td class="actions align-middle">
					<?= $this->Html->link(__('編集'), ['action' => 'edit', $voucher->id]) ?>
					<?= $this->Form->postLink(__('削除'), ['action' => 'delete', $voucher->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $voucher->id)]) ?>
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="sel[]" value="<?= $voucher->id ?>" id="customCheck<?= $voucher->id ?>">
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?= $this->element('pagenate'); ?>
</div>
