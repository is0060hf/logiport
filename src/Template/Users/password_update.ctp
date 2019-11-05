<?php
	/**
	 * @var \App\View\AppView      $this
	 * @var \App\Model\Entity\User $user
	 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Vouchers', 'action'=>'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Users', 'action'=>'index']); ?>">ユーザー一覧</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Users', 'action'=>'view',$user->id]); ?>">ユーザー詳細</a></li>
		<li class="breadcrumb-item active">パスワード更新</li>
	</ol>
</div>

<div class="users form large-9 medium-8 columns content">
	<?= $this->Form->create($user) ?>
	<fieldset>
		<legend><?= __('パスワード更新') ?></legend>
		<?php
			echo $this->Form->control('password', array(
					'label' => array(
							'text' => 'パスワード',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'password',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control',      // inputタグのクラス名
					'value' => ''
			));
		?>
	</fieldset>
	<div class="row mt-4">
		<div class="col-12 text-center">
			<button class="btn btn-success mr-3" type="submit">
				<i class="fe-check-circle"></i>
				<span>パスワード更新する</span>
			</button>
			<a href="<?= $this->Url->build(['controller'=>'Users','action'=>'view',$user->id]); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>詳細に戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
