<?php
	/**
	 * @var \App\View\AppView      $this
	 * @var \App\Model\Entity\User $user
	 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Vouchers', 'action'=>'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Users', 'action'=>'index']); ?>">ユーザ一覧</a></li>
		<li class="breadcrumb-item active">ユーザー登録</li>
	</ol>
</div>

<div class="users form large-9 medium-8 columns content">
	<?php
		$form_template = array(
				'error' => '<div class="col-sm-12 error-message alert alert-danger mt-2 mb-0 py-1">{{content}}</div>',
				'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
				'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10">{{input}}</div>',
				'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
				'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
				'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
				'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>',
		);
	?>

	<?= $this->Form->create($user, array(
			'templates' => $form_template
	)); ?>
	<fieldset>
		<legend><?= __('ユーザー登録') ?></legend>
		<?php
			echo $this->Form->control('username', array(
					'label' => array(
							'text' => '名前',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => 'ユーザーの名前を入力してください。'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('password', array(
					'label' => array(
							'text' => 'パスワード',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'password',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => 'パスワードを入力してください。'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('mail_address', array(
					'label' => array(
							'text' => 'メールアドレス',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => 'ユーザーのメールアドレスを入力してください。'
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
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '車番を入力してください。'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('insurance_fee', array(
					'label' => array(
							'text' => '保険料',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '保険料（月額料金）を整数で入力してください。'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('car_fee', array(
					'label' => array(
							'text' => '車輌代',          // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '車輌代（月額料金）を整数で入力してください。'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('commition', array(
					'label' => array(
							'text' => '手数料',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '手数料（％）を整数で入力してください。'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('user_role', array(
					'label' => array(
							'text' => '役割',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'select',
					'options' => array(
							'システム管理者' => 'システム管理者',
							'配達員' => '配達員'
					),
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => 'ユーザーの役割を選択してください。'
					),
					'value' => 'システム管理者',
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
			<a href="<?= $this->Url->build(['controller'=>'Users','action'=>'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
