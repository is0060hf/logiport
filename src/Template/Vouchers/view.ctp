<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Voucher $voucher
 */

use Cake\ORM\TableRegistry;

$deliveryList = TableRegistry::get('Deliveries')->find()->all();
$deliveryDestinationList = [];
$deliveryDestinationList['未選択'] = '未選択';

$myDeliveryList = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $voucher->id]);
$deliveryIdList = [];

$routeList = TableRegistry::get('Routes')->find()->all();
$routeNameList = [];
$routeNameList[''] = '未選択';

$cst= TableRegistry::get('Customers')->find('All')->where(['customers_name' => $voucher->customers_name])->first();
$regularServices = TableRegistry::get('RegularServices')->find('All')->where(['customer_id' => $cst->id]);
$thisRegularService = TableRegistry::get('RegularServices')->find('All')->where(['id' => $voucher->regular_service_id])->first();
if($thisRegularService){
  $regularDeliveries = TableRegistry::get('RegularDeliveries')->find('All')->where(['regular_service_id' => $thisRegularService->id]);
}else{
  $regularDeliveries = [];
}
$regularServicesNameList = [];

foreach ($deliveryList as $delivery) {
  if ($delivery->start_location != '') {
    $deliveryDestinationList[$delivery->start_location] = $delivery->start_location;
  }
  if ($delivery->destination != '') {
    $deliveryDestinationList[$delivery->destination] = $delivery->destination;
  }
}

foreach ($regularServices as $regularService) {
  $regularServicesNameList[$regularService->id] = $regularService->regular_service_name;
}

foreach ($myDeliveryList as $delivery) {
  $deliveryIdList[$delivery->id] = $delivery->id;
}

foreach ($routeList as $route) {
  if ($route->on_ic != '') {
    $routeNameList[$route->on_ic] = $route->on_ic;
  }
  if ($route->off_ic != '') {
    $routeNameList[$route->off_ic] = $route->off_ic;
  }
}
?>

<div class="breadcrumb_div">
  <ol class="breadcrumb m-b-20">
    <li class="breadcrumb-item"><a
        href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">Home</a>
    </li>
    <li class="breadcrumb-item"><a
        href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>">伝票一覧</a>
    </li>
    <li class="breadcrumb-item active">伝票情報</li>
  </ol>
</div>

<div class="vouchers view large-9 medium-8 columns content">
  <div class="row mb-4">
    <div class="col-sm-6">
      <div class="pull-left">
        <legend>伝票情報</legend>
        <p class="text-muted">伝票の情報確認及び、積込・納品先の追加、経路情報の追加を行ってください。必要に応じて、各種帳票を出力可能です。</p>
      </div>
      <div class="text-left mt-4">
        <a href="<?= $this->Url->build(['controller' => 'Vouchers', 'action' => 'edit', $voucher->id]); ?>"
           class="btn btn-success mr-3">
          <i class="fe-edit"></i>
          <span>編集する</span>
        </a>
        <a href="<?= $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>"
           class="btn btn-info">
          <i class="fe-skip-back"></i>
          <span>一覧に戻る</span>
        </a>
      </div>
    </div>

    <div class="col-sm-4 offset-sm-2">
      <div class="mt-3 float-right">
        <p class="m-b-10"><strong>作成日 : </strong> <span class="float-right"> <?= h($voucher->created) ?></span>
        </p>
        <p class="m-b-10"><strong>発行歴 : </strong> <span class="float-right"><span
              class="badge badge-danger">Unpaid</span></span>
        </p>
        <p class="m-b-10"><strong>更新日 : </strong> <span class="float-right"> <?= h($voucher->modified) ?></span>
        </p>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <h4><?= __('基本情報') ?></h4>
      <table class="table mb-4">
        <tr>
          <th scope="row"><?= __('配達員名') ?></th>
          <td><?= h($voucher->deliveryman_name) ?></td>
        </tr>
        <tr>
          <th scope="row"><?= __('定期便/スポット') ?></th>
          <td><?= h($voucher->is_regular) ?></td>
        </tr>
        <tr>
          <th scope="row"><?= __('車番') ?></th>
          <td><?= h($voucher->car_numb) ?></td>
        </tr>
        <tr>
          <th scope="row"><?= __('得意先') ?></th>
          <td><?= h($voucher->customers_name) ?></td>
        </tr>
        <tr>
          <th scope="row"><?= __('得意先の連絡先') ?></th>
          <td><?= h($voucher->customers_phone) ?></td>
        </tr>
	      <tr>
		      <th scope="row"><?= __('運賃・追加料金合計（税抜）') ?></th>
		      <td><?= h($voucher->sum_price1) ?></td>
	      </tr>
	      <tr>
		      <th scope="row"><?= __('消費税') ?></th>
		      <td><?= h($voucher->tax) ?></td>
	      </tr>
	      <tr>
		      <th scope="row"><?= __('合計金額（税込）') ?></th>
		      <td><?= h($voucher->sum_price2) ?></td>
	      </tr>
        <tr>
          <th scope="row"><?= __('備考') ?></th>
          <td><?= h($voucher->appendix) ?></td>
        </tr>
      </table>
    </div>
  </div>

  <?php if ($voucher->is_regular == "定期便") {
    if($thisRegularService){
    ?>
    <div class="row mb-4">
      <div class="col-12">
        <h4><?= __('定期便情報') ?></h4>
        <table class="table mb-4">
          <tr>
            <th scope="row"><?= __('定期便名') ?></th>
            <td><?= h($thisRegularService->regular_service_name) ?></td>
          </tr>
        </table>
      </div>
    </div>
    <?php } ?>

    <div class="row mb-4">
      <div class="col-12">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
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

                <?= $this->Form->create($voucher, array(
                  'url' => ['controller' => 'Vouchers', 'action' => 'addAllDeliveriesFromRegularService'],
                  'templates' => $form_template
                )); ?>

                <fieldset>
                  <legend><?= __('定期便選択') ?></legend>
                  <?php

                  echo $this->Form->control('regular_service_id', array(
                    'label' => array(
                      'text' => '定期便名',       // labelで出力するテキスト
                      'class' => 'col-form-label' // labelタグのクラス名
                    ),
                    'type' => 'select',
                    'options' => $regularServicesNameList,
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '定期便名を選択してください。'
                    ),
                    'required' => 'required',
                    'value' => $voucher->regular_service_id,
                    'class' => 'form-control'      // inputタグのクラス名
                  ));
                  echo $this->Form->hidden('customers_name', array('value' => $voucher->customers_name, 'id' => 'customers_name'));
                  ?>

                </fieldset>

                <?= $this->Form->hidden('voucher_id', ['value' => $voucher->id]); ?>

                <?= $this->Form->button('定期便の設定をする', array(
                  'class' => 'btn btn-success'
                )); ?>

                <?= $this->Form->end(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	<?php } ?>

	<div class="row mb-4">
      <div class="col-12">
        <?php if (count($voucher->deliveries)) : ?>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <legend>積込・納品情報一覧 <span
                      class="badge badge-secondary float-right"><?= count($voucher->deliveries); ?>
										件</span></legend>
                  <table class="table">
                    <tr>
                      <th>ID</th>
                      <th>積込/納品</th>
                      <th>出発地</th>
                      <th>宛先</th>
                      <th>距離</th>
                      <th>追加</th>
                      <th>立替</th>
                      <th>備考</th>
                      <th>操作</th>
                    </tr>
                    <?php foreach ($voucher->deliveries as $delivery) : ?>
                      <tr>
                        <td>
                          <a
                            href="<?php echo $this->Url->build(['controller' => 'Deliveries', 'action' => 'view', $delivery->id]); ?>">
                            <?= h($delivery->id); ?>
                          </a>
                        </td>
                        <td><?= h($delivery->deliveries_or_cargo); ?></td>
                        <td><?= h($delivery->start_location); ?></td>
                        <td><?= h($delivery->destination); ?></td>
                        <td><?= h($delivery->distance); ?></td>
                        <td><?= h($delivery->additional_price); ?></td>
                        <td><?= h($delivery->advances_paid); ?></td>
                        <td>
                          <?= h($delivery->appendix); ?>
                          <?php
                          $deliveryRoute = TableRegistry::get('Routes')->find('All')->where(['delivery_id' => $delivery->id]);
                          foreach ($deliveryRoute as $route) : ?>
                            <br>
                            <?= h($route->on_ic . '~' . $route->off_ic . '(' . $route->price . '円 / ' . $route->advances_or_additional . ' )'); ?>
                          <?php endforeach; ?>
                        </td>
                        <td>
                          <?=
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
                  'error' => '<div class="col-sm-12 error-message alert alert-danger mt-1 mb-2 py-1">{{content}}</div>',
                  'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                  'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10 d-flex align-items-center">{{input}}</div>',
                  'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
                  'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
                  'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
                  'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>'
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
                      '納品' => '納品',
                      '積込' => '積込'
                    ),
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '目的が積込か納品かを選択してください。'
                    ),
                    'value' => '納品',
                    'class' => 'form-control'      // inputタグのクラス名
                  ));
                  echo $this->Form->control('outward_or_return', array(
                    'label' => array(
                      'text' => '往路or復路',       // labelで出力するテキスト
                      'class' => 'col-form-label' // labelタグのクラス名
                    ),
                    'type' => 'select',
                    'options' => array(
                      '往路' => '往路',
                      '復路' => '復路'
                    ),
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '積込もしくは納品が往路で行われるのか、復路で行われるのかを選択してください。'
                    ),
                    'value' => '往路',
                    'class' => 'form-control'      // inputタグのクラス名
                  ));
                  echo $this->Form->control('delivery_dest', array(
                    'label' => array(
                      'text' => '積込地',       // labelで出力するテキスト
                      'class' => 'col-form-label' // labelタグのクラス名
                    ),
                    'type' => 'select',
                    'options' => $deliveryDestinationList,
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '届ける荷物を積み込んだ場所を入力してください。上の目的で積込を選択した場合はなにも入力しなくて大丈夫です。',
                      'select_toggle' => 'select2'
                    ),
                    'value' => $voucher->delivery_dest,
                    'id' => 'delivery_dest',
                    'class' => 'form-control select2'      // inputタグのクラス名
                  ));
                  echo $this->Form->control('start_location', array(
                    'label' => array(
                      'text' => '出発地',       // labelで出力するテキスト
                      'class' => 'col-form-label' // labelタグのクラス名
                    ),
                    'type' => 'select',
                    'options' => $deliveryDestinationList,
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '行先から一つ前で積込もしくは納品した場所を入力してください。',
                      'select_toggle' => 'select2'
                    ),
                    'id' => 'start_location',
                    'class' => 'form-control select2'      // inputタグのクラス名
                  ));
                  echo $this->Form->control('destination', array(
                    'label' => array(
                      'text' => '行先',       // labelで出力するテキスト
                      'class' => 'col-form-label' // labelタグのクラス名
                    ),
                    'type' => 'select',
                    'options' => $deliveryDestinationList,
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '上で積込を選択した場合は積込先の名前、納品を選択した場合は納品先の名前を入力してください。',
                      'select_toggle' => 'select2'
                    ),
                    'id' => 'destination',
                    'class' => 'form-control select2'      // inputタグのクラス名
                  ));
                  echo $this->Form->control('distance', array(
                    'label' => array(
                      'text' => '距離（km）',       // labelで出力するテキスト
                      'class' => 'col-form-label' // labelタグのクラス名
                    ),
                    'type' => 'text',
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '距離を入力してください。'
                    ),
                    'id' => 'distance',
                    'class' => 'form-control'      // inputタグのクラス名
                  ));
                  echo $this->Form->control('is_exception', array(
                    'label' => array(
                      'text' => '特殊な事情',       // labelで出力するテキスト
                      'class' => 'col-form-label' // labelタグのクラス名
                    ),
                    'type' => 'select',
                    'options' => array(
                      'あり' => 'あり',
                      'なし' => 'なし'
                    ),
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '特殊な事情により、通常の距離と異なる場合は「あり」を選択してください。'
                    ),
                    'value' => 'なし',
                    'class' => 'form-control'      // inputタグのクラス名
                  ));
                  echo $this->Form->control('appendix', array(
                    'label' => array(
                      'text' => '備考',       // labelで出力するテキスト
                      'class' => 'col-form-label' // labelタグのクラス名
                    ),
                    'type' => 'text',
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '備考がある場合は入力してください。'
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
                      'あり' => 'あり',
                      'なし' => 'なし'
                    ),
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '領収書の有無を選択してください。'
                    ),
                    'value' => 'あり',
                    'class' => 'form-control'      // inputタグのクラス名
                  ));
                  echo $this->Form->control('has_take_out', array(
                    'label' => array(
                      'text' => '持ち帰りの有無',       // labelで出力するテキスト
                      'class' => 'col-form-label' // labelタグのクラス名
                    ),
                    'type' => 'select',
                    'options' => array(
                      'あり' => 'あり',
                      'なし' => 'なし'
                    ),
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '持ち帰りの有無を選択してください。'
                    ),
                    'value' => 'なし',
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
                      'class' => 'custom-select',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '宛先に到着した時刻を選択してください。'
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
                      'class' => 'custom-select',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '宛先に到着し、作業を完了した時刻を選択してください。'
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
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '設定温度を入力してください。'
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
                      'あり' => 'あり',
                      'なし' => 'なし'
                    ),
                    'templateVars' => array(
                      'div_class' => 'form-group row',
                      'div_tooltip' => 'tooltip',
                      'div_tooltip_placement' => 'top',
                      'div_tooltip_title' => '受領サインの有無を選択してください。'
                    ),
                    'value' => 'あり',
                    'class' => 'form-control'      // inputタグのクラス名
                  ));
                  echo $this->Form->hidden('customers_name', array('value' => $voucher->customers_name, 'id' => 'customers_name'));
                  ?>

                </fieldset>

                <?= $this->Form->hidden('voucher_id', ['value' => $voucher->id]); ?>

                <?= $this->Form->button('追加する', array(
                  'class' => 'btn btn-success'
                )); ?>

                <?= $this->Form->end(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php if (count($deliveryIdList)) : ?>
        <div class="col-12">
          <?php if (count($voucher->routes)) : ?>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <legend>経路情報一覧 <span
                        class="badge badge-secondary float-right"><?= count($voucher->routes); ?>
											件</span></legend>

                    <?php foreach ($voucher->routes as $route) : ?>
                      <div class="row">
                        <div class="col-sm-11">
                          <p><?= h($route->on_ic . '~' . $route->off_ic . '(' . $route->price . '円)'); ?></p>
                        </div>
                        <div class="col-sm-1" style="text-align: right;">
                          <?=
                          $this->Form->postLink(
                            '[削除]',
                            ['controller' => 'Routes', 'action' => 'deletePart', $route->id],
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
                    'url' => ['controller' => 'Routes', 'action' => 'addPart'],
                    'templates' => $form_template
                  )); ?>

                  <fieldset>
                    <legend><?= __('経路情報 追加') ?></legend>
                    <?php
                    echo $this->Form->control('delivery_id', array(
                      'label' => array(
                        'text' => '積込・納品先ID',       // labelで出力するテキスト
                        'class' => 'col-form-label' // labelタグのクラス名
                      ),
                      'type' => 'select',
                      'options' => $deliveryIdList,
                      'templateVars' => array(
                        'div_class' => 'form-group row',
                        'div_tooltip' => 'tooltip',
                        'div_tooltip_placement' => 'top',
                        'div_tooltip_title' => '紐づける積込・納品情報のIDを選択してください。'
                      ),
                      'class' => 'form-control'      // inputタグのクラス名
                    ));
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

                  <?= $this->Form->hidden('voucher_id', ['value' => $voucher->id]); ?>
                  <?= $this->Form->hidden('car_kind', ['value' => '軽自動車等']); ?>

                  <?= $this->Form->button('追加する', array(
                    'class' => 'btn btn-success mr-3'
                  )); ?>

                  <button type="button"
                          onclick="window.open('https://kosoku.jp/route.php?f=' + form.on_ic.value + '&t=' + form.off_ic.value +'&c=' + form.car_kind.value);"
                          class="btn btn-outline-success mr-3">ＩＣ間の料金を調べる
                  </button>

                  <?= $this->Form->end(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

    </div>

  <div class="row">
    <div class="col-12 text-center">
      <a href="<?= $this->Url->build(['controller' => 'Vouchers', 'action' => 'edit', $voucher->id]); ?>"
         class="btn btn-success mr-3">
        <i class="fe-edit"></i>
        <span>編集する</span>
      </a>
      <a href="<?= $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>"
         class="btn btn-info">
        <i class="fe-skip-back"></i>
        <span>一覧に戻る</span>
      </a>
    </div>
  </div>
</div>
