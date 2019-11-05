<?php
	/**
	 * @var \App\View\AppView               $this
	 * @var String              $customer_id
	 * @var \App\Model\Entity\DistancePrice $distancePrice
	 */

	use Cake\ORM\TableRegistry;

	$cst = TableRegistry::get('Customers')->find()->where(['id' => $customer_id])->first();
	$pTable = TableRegistry::get('PriceTables')->find()->where(['customer_id' => $cst->id, 'mode' => ''])->first();
	if ($pTable) {
		$distancePriceTable = TableRegistry::get('DistancePrices')->find()->where(['price_table_id' => $pTable->id])->orderAsc('distance');
	}
?>
<?php if ($cst): ?>
	<div class="breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'view', $cst->id]); ?>">顧客情報</a></li>
			<li class="breadcrumb-item active">料金表コピー</li>
		</ol>
	</div>
<?php else: ?>
	<div class="breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a></li>
			<li class="breadcrumb-item active">料金表コピー</li>
		</ol>
	</div>
<?php endif; ?>

<!--料金表欄-->
<div class="related">
	<div class="row mb-4">
		<div class="col-sm-6">
			<div class="pull-left">
				<legend>料金表</legend>
				<p class="text-muted">顧客用の料金区分は下記の通りです。</p>
			</div>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-12">
			<?php if (!empty($pTable)): ?>
				<table cellpadding="0" cellspacing="0" class="table mb-4">
					<?php if (!empty($distancePriceTable)): ?>
						<tr>
							<th scope="col"><?= __('距離（km）') ?></th>
							<th scope="col"><?= __('値段（円）') ?></th>
						</tr>
						<?php foreach ($distancePriceTable as $tItem): ?>
							<tr>
								<td><?= h($tItem->distance) ?></td>
								<td><?= h($tItem->price) ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</table>
			<?php endif; ?>
		</div>
	</div>
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
	)) ?>
	<fieldset>
		<legend><?= __('ドライバー用料金区分登録') ?></legend>
		<?php
			echo $this->Form->control('magnification', array(
					'label' => array(
							'text' => '倍率',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '顧客用テーブルの料金にかける倍率を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('magnification'),
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
