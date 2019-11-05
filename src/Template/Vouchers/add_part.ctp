<?php
	/**
	 * @var \App\View\AppView         $this
	 * @var \App\Model\Entity\Voucher $voucher
	 */

	use Cake\ORM\TableRegistry;

	$cstList = TableRegistry::get('Customers')->find()->all();
	$userList = TableRegistry::get('Users')->find()->all();
	$deliveryList = TableRegistry::get('Deliveries')->find()->all();

	$deliveryDestinationList = [];
	$deliveryDestinationList[''] = '未選択';
	$customersNameList = [];
	$customersNameList[''] = '未選択';
	$usersNameList = [];
	$usersNameList[''] = '未選択';

	foreach ($deliveryList as $delivery) {
		if ($delivery->start_location != '') {
			$deliveryDestinationList[$delivery->start_location] = $delivery->start_location;
		}
		if ($delivery->destination != '') {
			$deliveryDestinationList[$delivery->destination] = $delivery->destination;
		}
	}

	foreach ($cstList as $cst) {
		$customersNameList[$cst->customers_name] = $cst->customers_name;
	}

	foreach ($userList as $usr) {
		$usersNameList[$usr->username] = $usr->username;
	}

?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a>
		</li>
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">伝票一覧</a>
		</li>
		<li class="breadcrumb-item active">新規伝票登録</li>
	</ol>
</div>

<div class="vouchers form large-9 medium-8 columns content">
	<?php
		$form_template = array(
				'error' => '<div class="col-sm-12 error-message alert alert-danger mt-1 mb-2 py-1">{{content}}</div>',
				'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
				'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10 d-flex align-items-center">{{input}}</div>',
				'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
				'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
				'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
				'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>'
		);
	?>

	<?= $this->Form->create($voucher, array(
			'templates' => $form_template
	)); ?>
	<fieldset>
		<div class="text-center">
			<legend><?= __('新規伝票登録') ?></legend>
			<p class="form-paragraph">※積込先、納品先、経路の設定は登録後の詳細画面で行います。</p>
		</div>
		<div class="row">
			<div class="col-12">
				<h3>基本情報</h3>
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
									'div_tooltip_title' => '担当した配達員の名前を入力してください。',
									'select_toggle' => 'select2'
							),
							'value' => $this->request->getData('deliveryman_name'),
							'id' => 'deliveryman_name',
							'class' => 'form-control select2'      // inputタグのクラス名
					));
					echo $this->Form->control('car_numb', array(
							'label' => array(
									'text' => '車番',       // labelで出力するテキスト
									'class' => 'col-form-label' // labelタグのクラス名
							),
							'type' => 'text',
							'templateVars' => array(
									'div_class' => 'form-group row',
									'div_tooltip' => 'tooltip',
									'div_tooltip_placement' => 'top',
									'div_tooltip_title' => '配達した車のナンバーを入力してください。'
							),
							'value' => $this->request->getData('car_numb'),
							'id' => 'car_numb',
							'class' => 'form-control'      // inputタグのクラス名
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
									'div_tooltip_title' => '得意先を選択してください。',
									'select_toggle' => 'select2'
							),
							'value' => $this->request->getData('customers_name'),
							'id' => 'customers_name',
							'class' => 'form-control select2'      // inputタグのクラス名
					));
					echo $this->Form->control('customers_phone', array(
							'label' => array(
									'text' => '得意先の連絡先',       // labelで出力するテキスト
									'class' => 'col-form-label' // labelタグのクラス名
							),
							'type' => 'text',
							'templateVars' => array(
									'div_class' => 'form-group row',
									'div_tooltip' => 'tooltip',
									'div_tooltip_placement' => 'top',
									'div_tooltip_title' => '得意先の電話番号を入力してください。'
							),
							'value' => $this->request->getData('customers_phone'),
							'id' => 'customers_phone',
							'class' => 'form-control'      // inputタグのクラス名
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
									'div_tooltip_title' => '備考を入力してください。いつもと違う経路の場合はその理由を入力ください。'
							),
							'value' => $this->request->getData('appendix'),
							'class' => 'form-control',      // inputタグのクラス名
							'rows' => '3'
					));
				?>
			</div>
		</div>
	</fieldset>
	<div class="row mt-4">
		<div class="col-12 text-center">
			<button class="btn btn-success mr-3" type="button" onclick="submit();">
				<i class="fe-check-circle"></i>
				<span>登録する</span>
			</button>
			<a href="<?= $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
