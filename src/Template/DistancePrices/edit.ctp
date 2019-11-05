<?php
	/**
	 * @var \App\View\AppView               $this
	 * @var \App\Model\Entity\DistancePrice $distancePrice
	 */
	use Cake\ORM\TableRegistry;

	$priceTable = TableRegistry::get('PriceTables')->find()->where(['id' => $distancePrice->price_table_id])->first();
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'view', $priceTable->customer_id]); ?>">顧客情報</a></li>
		<li class="breadcrumb-item active">料金区分編集</li>
	</ol>
</div>
<div class="distancePrices form large-9 medium-8 columns content">
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
	<?= $this->Form->create($distancePrice, array(
			'templates' => $form_template
	)); ?>
	<fieldset>
		<legend>料金区分編集</legend>
		<?php
			echo $this->Form->control('distance', array(
					'label' => array(
							'text' => '距離',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '料金に対応する距離を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('distance'),
					'class' => 'form-control'      // inputタグのクラス名
			));

			echo $this->Form->control('price', array(
					'label' => array(
							'text' => '料金',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '料金を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('price'),
					'class' => 'form-control'      // inputタグのクラス名
			));
		?>
	</fieldset>
	<div class="row mt-4">
		<div class="col-12 text-center">
			<button class="btn btn-success mr-3" type="button" onclick="submit();">
				<i class="fe-check-circle"></i>
				<span>登録する</span>
			</button>
			<a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'view',$priceTable->customer_id]); ?>" class="btn btn-success">
				<i class="fe-skip-back"></i>
				<span>顧客情報へ戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
