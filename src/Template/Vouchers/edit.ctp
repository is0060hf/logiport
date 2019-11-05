<?php
	/**
	 * @var \App\View\AppView         $this
	 * @var \App\Model\Entity\Voucher $voucher
	 */
	use Cake\ORM\TableRegistry;

	$cstList =  TableRegistry::get('Customers')->find()->all();
	$userList =  TableRegistry::get('Users')->find()->all();
	$deliveryList = TableRegistry::get('Deliveries')->find()->all();

	$deliveryDestinationList = [];
	$customersNameList = [];
	$usersNameList = [];

	foreach ($deliveryList as $delivery) {
		if ($delivery->start_location != '') {
			$deliveryDestinationList[$delivery->start_location] = $delivery->start_location;
		}
		if ($delivery->destination != '') {
			$deliveryDestinationList[$delivery->destination] = $delivery->destination;
		}
	}

	foreach ($cstList as $cst){
		$customersNameList[$cst->customers_name] = $cst->customers_name;
	}

	foreach ($userList as $usr){
		$usersNameList[$usr->username] = $usr->username;
	}

?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Vouchers', 'action'=>'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Vouchers', 'action'=>'index']); ?>">伝票一覧</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Vouchers', 'action'=>'view',$voucher->id]); ?>">伝票詳細</a></li>
		<li class="breadcrumb-item active">伝票編集</li>
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
	)) ?>
	<div class="text-center">
		<legend><?= __('伝票編集') ?></legend>
		<p class="form-paragraph">※積込先、納品先、経路の設定は詳細画面で行います。</p>
	</div>

	<div class="row">
		<div class="col-12 col-xl-6">
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
				echo $this->Form->control('cs', array(
						'label' => array(
								'text' => 'c/s',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '荷物の数を半角数字で入力してください。'
						),
						'value' => $this->request->getData('cs'),
						'class' => 'form-control'      // inputタグのクラス名
				));
				echo $this->Form->control('shipper_sign', array(
						'label' => array(
								'text' => '荷主サイン有無',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'select',
						'options' => array(
								'あり' => 'あり',
								'なし' => 'なし'
						),
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '荷主サインの有無を選択してください。'
						),
						'value' => $this->request->getData('shipper_sign'),
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
								'div_tooltip_title' => '積込先の名称を入力してください。',
								'select_toggle' => 'select2'
						),
						'value' => $this->request->getData('delivery_dest'),
						'id' => 'delivery_dest',
						'class' => 'form-control select2'      // inputタグのクラス名
				));
				echo $this->Form->control('arrival_time', array(
						'label' => array(
								'text' => '入庫時刻',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'datetime',
						'dateFormat' => 'YMD',
						'monthNames' => false,
						'timeFormat' => '24',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'class' => 'custom-select',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '積込先に入庫した時刻を入力してください。'
						),
						'year' => array(
								'class' => 'custom-select datetime-picker'
						),
						'month' => array(
								'class' => 'custom-select datetime-picker'
						),
						'day' => array(
								'class' => 'custom-select datetime-picker'
						),
						'hour' => array(
								'class' => 'custom-select datetime-picker'
						),
						'minute' => array(
								'class' => 'custom-select datetime-picker'
						),
						'value' => $this->request->getData('arrival_time'),
						'default' => date('Y-m-d H:i'),  //初期値指定
				));
				echo $this->Form->control('departure_time', array(
						'label' => array(
								'text' => '出庫時刻',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'datetime',
						'dateFormat' => 'YMD',
						'monthNames' => false,
						'timeFormat' => '24',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'class' => 'custom-select',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '積込先から出庫した時刻を入力してください。'
						),
						'year' => array(
								'class' => 'custom-select datetime-picker'
						),
						'month' => array(
								'class' => 'custom-select datetime-picker'
						),
						'day' => array(
								'class' => 'custom-select datetime-picker'
						),
						'hour' => array(
								'class' => 'custom-select datetime-picker'
						),
						'minute' => array(
								'class' => 'custom-select datetime-picker'
						),
						'value' => $this->request->getData('departure_time'),
						'default' => date('Y-m-d H:i'),  //初期値指定
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
				echo $this->Form->control('has_return_cargo', array(
						'label' => array(
								'text' => '帰り荷の有無',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'select',
						'options' => array(
								'なし' => 'なし',
								'あり' => 'あり'
						),
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '帰り荷の有無を選択してください。'
						),
						'value' => $this->request->getData('has_return_cargo'),
						'id' => 'has_return_cargo',
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
		<div class="col-12 col-xl-6">
			<h3>運賃明細</h3>
			<?php
				echo $this->Form->control('dist_outward', array(
						'label' => array(
								'text' => '往路距離',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '往路距離(km)を整数で入力してください。経路設定後に入力することも可能です。'
						),
						'value' => $this->request->getData('dist_outward'),
						'id' => 'dist_outward',
						'class' => 'form-control'      // inputタグのクラス名
				));

				echo $this->Form->control('price_outword', array(
						'label' => array(
								'text' => '往路金額',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '往路金額（円）を整数で入力してください。経路設定後に入力することも可能です。'
						),
						'value' => $this->request->getData('price_outword'),
						'id' => 'price_outword',
						'class' => 'form-control'      // inputタグのクラス名
				));

				echo $this->Form->control('dist_return', array(
						'label' => array(
								'text' => '復路距離',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '復路距離(km)を整数で入力してください。経路設定後に入力することも可能です。'
						),
						'value' => $this->request->getData('dist_return'),
						'id' => 'dist_return',
						'class' => 'form-control'      // inputタグのクラス名
				));

				echo $this->Form->control('price_return', array(
						'label' => array(
								'text' => '復路金額',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '復路金額(円)を整数で入力してください。経路設定後に入力することも可能です。'
						),
						'value' => $this->request->getData('price_return'),
						'id' => 'price_return',
						'class' => 'form-control'      // inputタグのクラス名
				));

				echo $this->Form->control('cargo_handling_min', array(
						'label' => array(
								'text' => '荷扱い時間',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '荷扱い時間(分)を整数で入力してください。'
						),
						'value' => $this->request->getData('cargo_handling_min'),
						'id' => 'cargo_handling_min',
						'class' => 'form-control'      // inputタグのクラス名
				));
				echo $this->Form->control('cargo_handling_fee', array(
						'label' => array(
								'text' => '荷扱い料金',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '荷扱い料金(円)を整数で入力してください。'
						),
						'value' => $this->request->getData('cargo_handling_fee'),
						'id' => 'cargo_handling_fee',
						'class' => 'form-control'      // inputタグのクラス名
				));
				echo $this->Form->control('cargo_waiting_min', array(
						'label' => array(
								'text' => '貨物待時間',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '貨物待時間(分)を整数で入力してください。'
						),
						'value' => $this->request->getData('cargo_waiting_min'),
						'id' => 'cargo_waiting_min',
						'class' => 'form-control'      // inputタグのクラス名
				));
				echo $this->Form->control('cargo_waiting_fee', array(
						'label' => array(
								'text' => '貨物待料金',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '貨物待料金(円)を整数で入力してください。'
						),
						'value' => $this->request->getData('cargo_waiting_fee'),
						'id' => 'cargo_waiting_fee',
						'class' => 'form-control'      // inputタグのクラス名
				));
				echo $this->Form->control('sum_price1', array(
						'label' => array(
								'text' => '小計',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '小計金額(円)を整数で入力してください。'
						),
						'value' => $this->request->getData('sum_price1'),
						'id' => 'sum_price1',
						'class' => 'form-control'      // inputタグのクラス名
				));
				echo $this->Form->control('tax', array(
						'label' => array(
								'text' => '消費税',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '消費税(円)を整数で入力してください。'
						),
						'value' => $this->request->getData('tax'),
						'id' => 'tax',
						'class' => 'form-control'      // inputタグのクラス名
				));
				echo $this->Form->control('sum_price2', array(
						'label' => array(
								'text' => '合計',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '税込み合計金額(円)を整数で入力してください。'
						),
						'value' => $this->request->getData('sum_price2'),
						'id' => 'sum_price2',
						'class' => 'form-control'      // inputタグのクラス名
				));
			?>
		</div>
	</div>

	</fieldset>
	<div class="row mt-4">
		<div class="col-12 text-center">
			<button class="btn btn-success mr-3" type="submit">
				<i class="fe-check-circle"></i>
				<span>更新する</span>
			</button>
			<a href="<?= $this->Url->build(['controller'=>'Vouchers','action'=>'view',$voucher->id]); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>詳細に戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
