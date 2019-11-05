<?php
	/**
	 * @var \App\View\AppView         $this
	 * @var \App\Model\Entity\Voucher $voucher
	 */
?>
<div class="vouchers view large-9 medium-8 columns content">

	<div class="row mb-4">
		<div class="col-sm-6">
			<div class="pull-left mt-3">
				<h4>伝票情報</h4>
				<p class="text-muted">伝票の情報確認及び、積込・納品先の追加、経路情報の追加を行ってください。必要に応じて、各種帳票を出力可能です。</p>
			</div>
		</div>

		<div class="col-sm-4 offset-sm-2">
			<div class="mt-3 float-right">
				<p class="m-b-10"><strong>作成日 : </strong> <span class="float-right"> <?= h($voucher->created) ?></span></p>
				<p class="m-b-10"><strong>発行歴 : </strong> <span class="float-right"><span class="badge badge-danger">Unpaid</span></span></p>
				<p class="m-b-10"><strong>更新日 : </strong> <span class="float-right"> <?= h($voucher->modified) ?></span></p>
			</div>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-sm-6">
			<h4><?= __('基本情報') ?></h4>
			<table class="table mb-4">
				<tr>
					<th scope="row"><?= __('配達員名') ?></th>
					<td><?= h($voucher->deliveryman_name) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('車番') ?></th>
					<td><?= h($voucher->car_numb) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('c/s' ) ?></th>
					<td><?= h($voucher->cs) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('得意先') ?></th>
					<td><?= h($voucher->customers_name) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('積込先') ?></th>
					<td><?= h($voucher->delivery_dest) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('得意先の連絡先') ?></th>
					<td><?= h($voucher->customers_phone) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('入庫時間') ?></th>
					<td><?= h($voucher->arrival_time) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('出庫時間') ?></th>
					<td><?= h($voucher->departure_time) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('荷主サイン有無') ?></th>
					<td><?= $this->Number->format($voucher->shipper_sign) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('帰り荷の有無') ?></th>
					<td><?= $this->Number->format($voucher->has_return_cargo) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('備考') ?></th>
					<td><?= h($voucher->appendix) ?></td>
				</tr>
			</table>
		</div>
		<div class="col-sm-6">
			<h4><?= __('運賃明細') ?></h4>
			<table class="table">
				<tr>
					<th scope="row"><?= __('往路距離/金額') ?></th>
					<td><?= h($voucher->dist_outward) ?>/<?= h($voucher->price_outword) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('復路距離/金額') ?></th>
					<td><?= h($voucher->dist_return) ?>/<?= h($voucher->price_return) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('荷扱い料') ?></th>
					<td><?= h($voucher->cargo_handling_fee) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('貨物待料') ?></th>
					<td><?= h($voucher->cargo_waiting_fee) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('小計') ?></th>
					<td><?= h($voucher->sum_price1) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('消費税') ?></th>
					<td><?= h($voucher->tax) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('合計') ?></th>
					<td><?= h($voucher->sum_price2) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('作成日') ?></th>
					<td><?= h($voucher->created) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('更新日') ?></th>
					<td><?= h($voucher->modified) ?></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-12">
			<?php if (count($voucher->deliveries)) : ?>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<legend>積込・納品情報一覧 <span class="badge badge-secondary float-right"><?= count($voucher->deliveries); ?>件</span></legend>
								<table class="table">
									<tr>
										<th>#</th>
										<th>積込/納品</th>
										<th>宛先</th>
										<th>距離</th>
										<th>受領有無</th>
										<th>到着</th>
										<th>完了</th>
										<th>庫温</th>
										<th>サイン有無</th>
										<th>削除</th>
									</tr>
									<?php foreach ($voucher->deliveries as $delivery) : ?>
										<tr>
											<td><?= h($delivery->id); ?></td>
											<td><?= h($delivery->deliveries_or_cargo); ?></td>
											<td><?= h($delivery->destination); ?></td>
											<td><?= h($delivery->distance); ?></td>
											<td><?= h($delivery->receipt_flg); ?></td>
											<td><?= h($delivery->arrival_time); ?></td>
											<td><?= h($delivery->complete_time); ?></td>
											<td><?= h($delivery->temperature); ?></td>
											<td><?= h($delivery->receipt_sign); ?></td>
											<td><?=
													$this->Form->postLink(
															'[削除]',
															['controller' => 'Deliveries', 'action' => 'delete', $delivery->id],
															['confirm' => '本当に削除してよろしいですか?', 'class' => 'btn btn-link']
													);
												?>
											</td>
										</tr>
										<div class="row">
											<div class="col-sm-11">
												<p></p>
											</div>
											<div class="col-sm-1" style="text-align: right;">

											</div>
										</div>
									<?php endforeach; ?>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<?php
								$form_template = array(
										'error' => '<div class="error-message alert alert-danger">{{content}}</div>',
										'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
										'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10">{{input}}</div>',
										'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
										'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}">{{content}}</div>'
								);
							?>

							<?= $this->Form->create(null, array(
									'url' => ['controller' => 'Deliveries', 'action' => 'add'],
									'templates' => $form_template
							)); ?>

							<fieldset>
								<legend><?= __('積込・納品情報 追加') ?></legend>
								<?php
									echo $this->Form->control('deliveries_or_cargo', array(
											'label' => array(
													'text' => '積込or納品',       // labelで出力するテキスト
													'class' => 'col-form-label' // labelタグのクラス名
											),
											'type' => 'select',
											'options' => array(
													'1' => '納品',
													'0' => '積込'
											),
											'templateVars' => array(
													'div_class' => 'form-group row'
											),
											'value' => '1',
											'class' => 'form-control'      // inputタグのクラス名
									));
									echo $this->Form->control('destination', array(
											'label' => array(
													'text' => '納品/積込先',       // labelで出力するテキスト
													'class' => 'col-form-label' // labelタグのクラス名
											),
											'type' => 'text',
											'templateVars' => array(
													'div_class' => 'form-group row'
											),
											'class' => 'form-control'      // inputタグのクラス名
									));
									echo $this->Form->control('distance', array(
											'label' => array(
													'text' => '距離（km）',       // labelで出力するテキスト
													'class' => 'col-form-label' // labelタグのクラス名
											),
											'type' => 'text',
											'templateVars' => array(
													'div_class' => 'form-group row'
											),
											'class' => 'form-control'      // inputタグのクラス名
									));
									echo $this->Form->control('receipt_flg', array(
											'label' => array(
													'text' => '受領書有無',       // labelで出力するテキスト
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
									echo $this->Form->control('arrival_time', array(
											'label' => array(
													'text' => '到着時刻',       // labelで出力するテキスト
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
									echo $this->Form->control('complete_time', array(
											'label' => array(
													'text' => '完了時刻',       // labelで出力するテキスト
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
									echo $this->Form->control('temperature', array(
											'label' => array(
													'text' => '設定温度',       // labelで出力するテキスト
													'class' => 'col-form-label' // labelタグのクラス名
											),
											'type' => 'text',
											'templateVars' => array(
													'div_class' => 'form-group row'
											),
											'class' => 'form-control'      // inputタグのクラス名
									));
									echo $this->Form->control('receipt_sign', array(
											'label' => array(
													'text' => '受領サイン有無',       // labelで出力するテキスト
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
								?>
							</fieldset>

							<?= $this->Form->hidden('vouchers_id', ['value' => $voucher->id]); ?>

							<?= $this->Form->button('追加', array(
									'class' => 'btn btn-success'
							)); ?>

							<?= $this->Form->end(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12">
			<?php if (count($voucher->routes)) : ?>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<h4>経路情報一覧 <span class="badge badge-secondary"><?= count($voucher->routes); ?>件</span></h4>

								<?php foreach ($voucher->routes as $route) : ?>
									<div class="row">
										<div class="col-sm-11">
											<p><?= h($route->on_ic.'~'.$route->off_ic.'('.$route->price.'円)'); ?></p>
										</div>
										<div class="col-sm-1" style="text-align: right;">
											<?=
												$this->Form->postLink(
														'[削除]',
														['controller' => 'Routes', 'action' => 'delete', $route->id],
														['confirm' => '本当に削除してよろしいですか?', 'class' => 'btn btn-link']
												);
											?>
										</div>
									</div>
								<?php endforeach; ?>

							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<?php
								$form_template = array(
										'error' => '<div class="error-message alert alert-danger">{{content}}</div>',
										'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
										'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10">{{input}}</div>',
										'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
										'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}">{{content}}</div>'
								);
							?>

							<?= $this->Form->create(null, array(
									'url' => ['controller' => 'Routes', 'action' => 'add'],
									'templates' => $form_template
							)); ?>

							<fieldset>
								<legend><?= __('経路情報 追加') ?></legend>
								<?php
									echo $this->Form->control('on_ic', array(
											'label' => array(
													'text' => '乗りIC',       // labelで出力するテキスト
													'class' => 'col-form-label' // labelタグのクラス名
											),
											'type' => 'text',
											'templateVars' => array(
													'div_class' => 'form-group row'
											),
											'class' => 'form-control'      // inputタグのクラス名
									));
									echo $this->Form->control('off_ic', array(
											'label' => array(
													'text' => '降りIC',       // labelで出力するテキスト
													'class' => 'col-form-label' // labelタグのクラス名
											),
											'type' => 'text',
											'templateVars' => array(
													'div_class' => 'form-group row'
											),
											'class' => 'form-control'      // inputタグのクラス名
									));
									echo $this->Form->control('price', array(
											'label' => array(
													'text' => '料金',       // labelで出力するテキスト
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

							<?= $this->Form->hidden('vouchers_id', ['value' => $voucher->id]); ?>

							<?= $this->Form->button('追加', array(
									'class' => 'btn btn-success'
							)); ?>

							<?= $this->Form->end(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12 text-center">
			<a href="<?= $this->Url->build(['controller'=>'Vouchers','action'=>'edit',$voucher->id]); ?>" class="btn btn-success mr-3">
				<i class="fe-edit"></i>
				<span>編集</span>
			</a>
			<a href="<?= $this->Url->build(['controller'=>'Vouchers','action'=>'index']); ?>" class="btn btn-info">
				<i class="fe-edit"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
</div>
