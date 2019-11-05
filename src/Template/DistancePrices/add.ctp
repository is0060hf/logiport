<?php
	/**
	 * @var \App\View\AppView               $this
	 * @var \App\Model\Entity\DistancePrice $distancePrice
	 */

	use Cake\ORM\TableRegistry;

	$cst = TableRegistry::get('Customers')->find()->where(['id' => $this->getRequest()->getQuery('customer_id')])->first();
	$pTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $this->getRequest()->getQuery('customer_id'), 'mode' => $this->getRequest()->getQuery('mode')])->first();
?>
<?php if ($cst): ?>
	<div class="breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'view', $cst->id]); ?>">顧客情報</a></li>
			<li class="breadcrumb-item active">新規料金区分登録</li>
		</ol>
	</div>
<?php else: ?>
	<div class="breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a></li>
			<li class="breadcrumb-item active">新規料金区分登録</li>
		</ol>
	</div>
<?php endif; ?>

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
	)) ?>
	<fieldset>
		<legend><?= isset($cst) ? $cst->customers_name . __('様 新規料金区分登録') : __('新規料金区分登録') ?></legend>
		<?php
			if($pTable){
				echo $this->Form->control('price_table_id', array(
						'label' => array(
								'text' => '料金表ID',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '料金表IDは変更できません。'
						),
						'required' => true,
						'value' => $pTable->id,
						'readonly' => 'readonly',
						'class' => 'form-control'      // inputタグのクラス名
				));
			}else{
				echo $this->Form->control('price_table_id', array(
						'label' => array(
								'text' => '料金表ID',       // labelで出力するテキスト
								'class' => 'col-form-label' // labelタグのクラス名
						),
						'type' => 'text',
						'templateVars' => array(
								'div_class' => 'form-group row',
								'div_tooltip' => 'tooltip',
								'div_tooltip_placement' => 'top',
								'div_tooltip_title' => '料金表IDを設定してください。'
						),
						'required' => true,
						'value' => $this->request->getData('price_table_id'),
						'class' => 'form-control'      // inputタグのクラス名
				));
			}

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
			<button class="btn btn-success mr-3" type="submit">
				<i class="fe-check-circle"></i>
				<span>登録する</span>
			</button>
			<?php if ($cst): ?>
				<a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'view', $cst->id]); ?>" class="btn btn-info">
					<i class="fe-skip-back"></i>
					<span>顧客情報へ戻る</span>
				</a>
			<?php else: ?>
				<a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>" class="btn btn-info">
					<i class="fe-skip-back"></i>
					<span>顧客一覧へ戻る</span>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
