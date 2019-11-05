<?php
	/**
	 * @var \App\View\AppView      $this
	 * @var \App\Model\Entity\User $user
	 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Form->postLink(
					__('Delete'),
					['action' => 'delete', $user->id],
					['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
			)
			?></li>
		<li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
	</ul>
</nav>
<div class="users form large-9 medium-8 columns content">
	<?= $this->Form->create($user) ?>
	<fieldset>
		<legend><?= __('Edit User') ?></legend>
		<?php
			echo $this->Form->control('username', array(
					'label' => array(
							'text' => '名前',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row'
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
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('mail_address', array(
					'label' => array(
							'text' => 'メールアドレス',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'password',
					'templateVars' => array(
							'div_class' => 'form-group row'
					),
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('setUser_role', array(
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
							'div_class' => 'form-group row'
					),
					'value' => 'システム管理者',
					'class' => 'form-control'      // inputタグのクラス名
			));
		?>
	</fieldset>
	<?= $this->Form->button(__('登録'), array(
			'class' => 'btn btn-success'
	)) ?>
	<?= $this->Form->end() ?>
</div>
