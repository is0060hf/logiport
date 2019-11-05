<?php
	/**
	 * @var \App\View\AppView            $this
	 * @var \App\Model\Entity\PriceTable $priceTable
	 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'index']); ?>">顧客一覧</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Customers', 'action' => 'view', $priceTable->customer_id]); ?>">顧客情報</a></li>
		<li class="breadcrumb-item active">料金表編集</li>
	</ol>
</div>
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
	<?= $this->Form->create($priceTable, array(
			'templates' => $form_template
	)); ?>
	<fieldset>
		<div class="text-center">
			<legend>料金表編集</legend>
			<p class="form-paragraph">※距離単価、作業時間単価、配達回数単価、待機単価、積込距離単価の設定は登録後の詳細画面で行います。<br>※帰り荷による料金倍率と追加料金はどちらか一方を設定ください。両方設定した場合、料金倍率を優先します。</p>
		</div>
		<?php
			echo $this->Form->control('basic_price', array(
					'label' => array(
							'text' => '基本料金',       // labelで出力するテキスト
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
					'value' => $this->request->getData('basic_price'),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('return_magnification', array(
					'label' => array(
							'text' => '帰り荷による料金倍率',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '帰り荷による料金倍率を設定してください。'
					),
					'value' => $this->request->getData('return_magnification'),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('return_additional_fee', array(
					'label' => array(
							'text' => '帰り荷による追加料金',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '帰り荷による追加料金を設定してください。こちらを設定すると、「帰り荷による料金倍率」は使用されません。'
					),
					'value' => $this->request->getData('return_additional_fee'),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('waiting_basic_min', array(
					'label' => array(
							'text' => '待機無料時間',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '待機無料時間（分）を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('waiting_basic_min'),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('waiting_fee', array(
					'label' => array(
							'text' => '待機料金',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '待機料金（円/30分）を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('waiting_fee'),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('handling_basic_min', array(
					'label' => array(
							'text' => '作業無料時間',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '作業無料時間（分）を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('handling_basic_min'),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('handling_fee', array(
					'label' => array(
							'text' => '作業料金',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '作業料金（円/30分）を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('handling_fee'),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('cancel_fee', array(
					'label' => array(
							'text' => 'キャンセル料金',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => 'キャンセル料金を設定してください。請求書に表示されます。'
					),
					'required' => true,
					'value' => $this->request->getData('return_magnification'),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('cargo_basic_dist', array(
					'label' => array(
							'text' => '積込無料区間',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '積込無料区間（km）を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('cargo_basic_dist'),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('cargo_fee', array(
					'label' => array(
							'text' => '積込割増',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '積込割増（％）を設定してください。'
					),
					'required' => true,
					'value' => $this->request->getData('cargo_fee'),
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
			<a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'view',$priceTable->customer_id]); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>顧客情報へ戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
