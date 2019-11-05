<?php
	/**
	 * @var \App\View\AppView         $this
	 * @var \App\Model\Entity\Voucher $voucher
	 */
?>
<div class="vouchers form large-9 medium-8 columns content">
	<?php
		$form_template = array(
				'error' => '<div class="error-message alert alert-danger">{{content}}</div>',
				'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
				'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10">{{input}}</div>',
				'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
				'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}">{{content}}</div>'
		);
	?>

	<?= $this->Form->create($voucher, array(
			'templates' => $form_template
	)); ?>
	<fieldset>
		<legend><?= __('新規伝票登録') ?></legend>
		<p class="form-paragraph">※積込先、納品先、経路の設定は次の画面で行います。</p>
		<h3>基本情報</h3>
		<?php
			echo $this->Form->control('deliveryman_name', array(
					'label' => array(
							'text' => '配達員名',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('car_numb', array(
					'label' => array(
							'text' => '車番',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('cs', array(
					'label' => array(
							'text' => 'c/s',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('shipper_sign', array(
					'label' => array(
							'text' => '荷主サイン有無',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'select',
					'options' => array(
							'1' => 'あり',
							'0' => 'なし'
					),
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'value' => '1',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('customers_name', array(
					'label' => array(
							'text' => '得意先',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('delivery_dest', array(
					'label' => array(
							'text' => '積込先',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
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
							'class' => 'custom-select'
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
							'class' => 'custom-select'
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
					'default' => date('Y-m-d H:i'),  //初期値指定
			));
			echo $this->Form->control('customers_phone', array(
					'label' => array(
							'text' => '得意先の連絡先',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('has_return_cargo', array(
					'label' => array(
							'text' => '帰り荷の有無',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'select',
					'options' => array(
							'1' => 'あり',
							'0' => 'なし'
					),
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'value' => '1',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('appendix', array(
					'label' => array(
							'text' => '備考',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'templateVars' => array(
							'div_class' => 'form-group row'    // divタグのクラス名
					),
					'class' => 'form-control',      // inputタグのクラス名
					'rows' => '3'
			));
		?>

		<h3>運賃明細</h3>
		<?php
			echo $this->Form->control('dist_outward', array(
					'label' => array(
							'text' => '往路距離',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));

			echo $this->Form->control('price_outword', array(
					'label' => array(
							'text' => '往路金額',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));

			echo $this->Form->control('dist_return', array(
					'label' => array(
							'text' => '復路距離',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));

			echo $this->Form->control('price_return', array(
					'label' => array(
							'text' => '復路金額',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));

			echo $this->Form->control('cargo_handling_fee', array(
					'label' => array(
							'text' => '荷扱い料金',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('cargo_waiting_fee', array(
					'label' => array(
							'text' => '貨物待料金',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('sum_price1', array(
					'label' => array(
							'text' => '小計',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('tax', array(
					'label' => array(
							'text' => '消費税',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('sum_price2', array(
					'label' => array(
							'text' => '合計',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
		?>
	</fieldset>
	<?= $this->Form->button(__('登録'), array(
			'class' => 'btn btn-success'
	)) ?>
	<?= $this->Form->end() ?>
</div>
