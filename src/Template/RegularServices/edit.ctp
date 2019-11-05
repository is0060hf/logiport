<?php
	/**
	 * @var \App\View\AppView            $this
	 * @var \App\Model\Entity\RegularService $regularService
	 */

	use Cake\ORM\TableRegistry;

	$cst = TableRegistry::get('Customers')->find()->where(['id' => $regularService->customer_id])->first();
?>

<?php if ($cst): ?>
	<div class="breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a
						href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a>
			</li>
			<li class="breadcrumb-item"><a
						href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a>
			</li>
			<li class="breadcrumb-item"><a
						href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'view', $cst->id]); ?>">顧客情報</a>
			</li>
			<li class="breadcrumb-item active">定期便情報編集</li>
		</ol>
	</div>
<?php else: ?>
	<div class="breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a
						href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a>
			</li>
			<li class="breadcrumb-item"><a
						href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a>
			</li>
			<li class="breadcrumb-item active">定期便情報編集</li>
		</ol>
	</div>
<?php endif; ?>

<div class="priceTables form large-9 medium-8 columns content">
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

	<?= $this->Form->create($regularService, array(
			'templates' => $form_template
	)) ?>
	<fieldset>
		<div class="text-center">
			<legend><?= isset($cst) ? $cst->customers_name . __('様 定期便情報編集') : __('定期便情報編集') ?></legend>
			<p class="form-paragraph">
				※定期便の基本情報を編集してください。紐づく経路情報は基本情報登録後に実施ください。
			</p>
		</div>

		<?php
			echo $this->Form->control('customer_id', array(
					'label' => array(
							'text' => '顧客ID',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '顧客IDは変更できません。'
					),
					'required' => true,
					'value' => $cst->id,
					'readonly' => 'readonly',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('regular_service_name', array(
					'label' => array(
							'text' => '定期便名',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '基本料金を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('regular_service_name'),
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
			<a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'view', $cst->id]); ?>"
			   class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>顧客情報へ戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
