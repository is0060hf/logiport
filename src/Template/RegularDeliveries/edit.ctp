<?php
	/**
	 * @var \App\View\AppView          $this
	 * @var \App\Model\Entity\RegularDelivery $regularDelivery
	 * @var string $id
	 */
	use Cake\ORM\TableRegistry;

	$rs = TableRegistry::get('RegularServices')->find()->where(['id' => $regularDelivery->regular_service_id])->first();

	$deliveryList = TableRegistry::get('Deliveries')->find()->all();
	$deliveryDestinationList = [];
	$deliveryDestinationList['未選択'] = '未選択';

	foreach ($deliveryList as $delivery) {
		if ($delivery->start_location != '') {
			$deliveryDestinationList[$delivery->start_location] = $delivery->start_location;
		}
		if ($delivery->destination != '') {
			$deliveryDestinationList[$delivery->destination] = $delivery->destination;
		}
	}
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a>
		</li>
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a>
		</li>
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'view', $rs->customer_id]); ?>">顧客情報</a>
		</li>
		<li class="breadcrumb-item active">新規定期便経路編集</li>
	</ol>
</div>
<div class="deliveries form large-9 medium-8 columns content">
	<?= $this->Form->create($regularDelivery) ?>
	<fieldset>
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

		<?= $this->Form->create(null, array(
				'url' => ['controller' => 'Deliveries', 'action' => 'add'],
				'templates' => $form_template
		)); ?>

		<legend><?= __('新規定期便経路編集') ?></legend>
		<?php
			echo $this->Form->control('regular_service_id', array(
					'label' => array(
							'text' => '定期便ID',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '定期便IDは変更できません。'
					),
					'required' => true,
					'value' => $rs->id,
					'readonly' => 'readonly',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('deliveries_or_cargo', array(
					'label' => array(
							'text' => '積込or納品',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'select',
					'options' => array(
							'納品' => '納品',
							'積込' => '積込'
					),
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '目的が積込か納品かを選択してください。'
					),
					'value' => $regularDelivery->deliveries_or_cargo,
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('outward_or_return', array(
					'label' => array(
							'text' => '往路or復路',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'select',
					'options' => array(
							'往路' => '往路',
							'復路' => '復路'
					),
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '積込もしくは納品が往路で行われるのか、復路で行われるのかを選択してください。'
					),
					'value' => $regularDelivery->outward_or_return,
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('delivery_dest', array(
					'label' => array(
							'text' => '積込地',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'select',
					'options' => $deliveryDestinationList,
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '届ける荷物を積み込んだ場所を入力してください。上の目的で積込を選択した場合はなにも入力しなくて大丈夫です。',
							'select_toggle' => 'select2'
					),
					'value' => $regularDelivery->delivery_dest,
					'id' => 'delivery_dest',
					'class' => 'form-control select2'      // inputタグのクラス名
			));
			echo $this->Form->control('start_location', array(
					'label' => array(
							'text' => '出発地',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'select',
					'options' => $deliveryDestinationList,
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '行先から一つ前で積込もしくは納品した場所を入力してください。',
							'select_toggle' => 'select2'
					),
					'value' => $regularDelivery->start_location,
					'id' => 'start_location',
					'class' => 'form-control select2'      // inputタグのクラス名
			));
			echo $this->Form->control('destination', array(
					'label' => array(
							'text' => '行先',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'select',
					'options' => $deliveryDestinationList,
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '上で積込を選択した場合は積込先の名前、納品を選択した場合は納品先の名前を入力してください。',
							'select_toggle' => 'select2'
					),
					'value' => $regularDelivery->destination,
					'id' => 'destination',
					'class' => 'form-control select2'      // inputタグのクラス名
			));
			echo $this->Form->control('distance', array(
					'label' => array(
							'text' => '距離（km）',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '距離を入力してください。'
					),
					'value' => $regularDelivery->distance,
					'id' => 'distance',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('appendix', array(
					'label' => array(
							'text' => '備考',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '備考がある場合は入力してください。'
					),
					'value' => $regularDelivery->appendix,
					'class' => 'form-control'      // inputタグのクラス名
			));
		?>
	</fieldset>
	<div class="row mt-4">
		<div class="col-12 text-center">
			<button class="btn btn-success mr-3" type="submit">
				<i class="fe-check-circle"></i>
				<span>登録する</span>
			</button>
			<a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'view', $rs->customer_id]); ?>"
			   class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>顧客情報へ戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end(); ?>
</div>
