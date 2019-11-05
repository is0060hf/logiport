<?php
	/**
	 * @var \App\View\AppView                                             $this
	 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
	 */

	use Cake\ORM\TableRegistry;

	$userList = TableRegistry::get('Users')->find()->all();
	$usersNameList = [];
	$usersNameList[''] = '未選択';
	foreach ($userList as $usr) {
		if ($usr->username != '') {
			$usersNameList[$usr->username] = $usr->username;
		}
	}
?>
<div class="row">
	<div class="col-6 breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>">ユーザー一覧</a>
			</li>
			<li class="breadcrumb-item active">売掛金明細生成</li>
		</ol>
	</div>
</div>

<div class="users index large-9 medium-8 columns content">
	<?php
		$form_template = array(
				'error' => '<div class="col-sm-12 error-message alert alert-danger mt-1 mb-2 py-1">{{content}}</div>',
				'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
				'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10 d-flex align-items-center">{{input}}</div>',
				'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
				'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
				'input' => '<input class="form-control" type="{{type}}" name="{{name}}" {{attrs}} data-toggle="{{data_toggle}}" maxlength="{{max_length}}" data-mask-format="{{data_mask_format}}">',
				'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
				'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>'
		);
	?>

	<?= $this->Form->create(null, array(
			'templates' => $form_template,
			'type' => 'get',
			'idPrefix' => 'search_form',
			'name' => 'search_form'
	)); ?>

	<legend><?= __('売掛金明細生成') ?></legend>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="text-center">
						<p class="form-paragraph">ユーザーを検索するための条件を入力してください。</p>
					</div>

					<?php
						echo $this->Form->control('deliveryman_name', array(
								'label' => array(
										'text' => '配達員名',       // labelで出力するテキスト
										'class' => 'col-form-label' // labelタグのクラス名
								),
								'type' => 'select',
								'options' => $usersNameList,
								'templateVars' => array(
										'div_class' => 'form-group row',
										'div_tooltip' => 'tooltip',
										'div_tooltip_placement' => 'top',
										'div_tooltip_title' => '絞り込みたい配達員の名前を入力してください。',
										'select_toggle' => 'select2'
								),
								'value' => $this->request->getQuery('deliveryman_name'),
								'id' => 'deliveryman_name',
								'class' => 'form-control select2'      // inputタグのクラス名
						));
					?>

					<div class="row my-2">
						<div class="col-12 text-center">
							<button class="btn btn-outline-dark mr-3" type="button" name="submit_btn" value="clear"
							        onclick="clearSearchElementsInUser();document.search_form.submit();">
								<i class="fe-edit"></i>
								<span>検索条件クリア</span>
							</button>
							<button class="btn btn-primary mr-3" type="submit" name="submit_btn" value="search">
								<i class="fe-edit"></i>
								<span>検索</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= $this->Form->end(); ?>

	<?= $this->Form->create(null, array(
			'templates' => $form_template,
			'type' => 'post',
			'idPrefix' => 'list_form',
			'name' => 'list_form'
	)); ?>

	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('username', '氏名') ?></th>
			<th scope="col"><?= $this->Paginator->sort('mail_address', 'メールアドレス') ?></th>
			<th scope="col"><?= $this->Paginator->sort('user_role', '役割') ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', '作成日') ?></th>
			<th scope="col"><?= $this->Paginator->sort('modified', '更新日') ?></th>
			<th scope="col" class="actions"><?= __('選択') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user): ?>
			<tr>
				<td class="align-middle"><a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'view', $user->id]); ?>" class="btn btn-info"><?= h($user->username) ?></a></td>
				<td class="align-middle"><?= h($user->mail_address) ?></td>
				<td class="align-middle"><?= h($user->user_role) ?></td>
				<td class="align-middle"><?= h($user->created) ?></td>
				<td class="align-middle"><?= h($user->modified) ?></td>
				<td class="actions align-middle">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="sel[]" value="<?= $user->id ?>"
						       id="customCheck<?= $user->id ?>">
						<label class="custom-control-label" for="customCheck<?= $user->id ?>">選択</label>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?= $this->element('pagenate'); ?>

	<!--伝票情報の入力欄-->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="text-center">
						<p class="form-paragraph">伝票を作成するための情報を入力してください。</p>
					</div>

					<?php
						echo $this->Form->control('under_term', array(
								'label' => array(
										'text' => '発行期間（から）',       // labelで出力するテキスト
										'class' => 'col-form-label' // labelタグのクラス名
								),
								'type' => 'text',
								'templateVars' => array(
										'div_class' => 'form-group row',
										'div_tooltip' => 'tooltip',
										'div_tooltip_placement' => 'top',
										'div_tooltip_title' => '発行期間の始まりを入力してください。',
										'data_mask_format' => '0000/00/00',
										'data_toggle' => 'input-mask',
										'max_length' => '10'
								),
								'value' => date('Y/m/d'),
								'id' => 'under_term',
								'class' => 'form-control'      // inputタグのクラス名
						));

						echo $this->Form->control('upper_term', array(
								'label' => array(
										'text' => '発行期間（まで）',       // labelで出力するテキスト
										'class' => 'col-form-label' // labelタグのクラス名
								),
								'type' => 'text',
								'templateVars' => array(
										'div_class' => 'form-group row',
										'div_tooltip' => 'tooltip',
										'div_tooltip_placement' => 'top',
										'div_tooltip_title' => '発行期間の終わりを入力してください。',
										'data_mask_format' => '0000/00/00',
										'data_toggle' => 'input-mask',
										'max_length' => '10'
								),
								'value' => date('Y/m/d'),
								'id' => 'upper_term',
								'class' => 'form-control'      // inputタグのクラス名
						));
					?>

					<div class="row my-2">
						<div class="col-12 text-center">
							<button class="btn btn-success mr-3" type="submit" name="submit_btn" value="kanrihu_hakkou">
								<i class="fe-edit"></i>
								<span>売上管理普を生成する</span>
							</button>
							<button class="btn btn-success mr-3" type="submit" name="submit_btn" value="urikake_hakkou">
								<i class="fe-edit"></i>
								<span>売掛明細書を生成する</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= $this->Form->end(); ?>
</div>
