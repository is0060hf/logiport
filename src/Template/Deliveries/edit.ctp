<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Delivery $delivery
 */

use Cake\ORM\TableRegistry;

$deliveryList = TableRegistry::get('Deliveries')->find()->all();
$deliveryDestinationList = [];
$deliveryDestinationList['未選択'] = '未選択';

$myDeliveryList = TableRegistry::get('Deliveries')->find('All')->where(['voucher_id' => $delivery->id]);
$deliveryIdList = [];

$routeList = TableRegistry::get('Routes')->find()->all();
$routeNameList = [];
$routeNameList[''] = '未選択';

foreach ($deliveryList as $delivery) {
  if ($delivery->start_location != '') {
    $deliveryDestinationList[$delivery->start_location] = $delivery->start_location;
  }
  if ($delivery->destination != '') {
    $deliveryDestinationList[$delivery->destination] = $delivery->destination;
  }
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
    <li class="breadcrumb-item"><a
        href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'view', $delivery->voucher_id]); ?>">伝票詳細</a>
    </li>
    <li class="breadcrumb-item"><a
        href="<?php echo $this->Url->build(['controller' => 'Deliveries', 'action' => 'view', $delivery->id]); ?>">配達情報詳細</a>
    </li>
    <li class="breadcrumb-item active">配達情報編集</li>
  </ol>
</div>
<div class="deliveries form large-9 medium-8 columns content">
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

  <?= $this->Form->create($delivery, array(
    'url' => ['controller' => 'Deliveries', 'action' => 'edit'],
    'templates' => $form_template
  )); ?>
  <fieldset>
    <legend><?= __('Edit Delivery') ?></legend>
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
    echo $this->Form->control('additional_price', array(
      'label' => array(
        'text' => '追加料金',       // labelで出力するテキスト
        'class' => 'col-form-label' // labelタグのクラス名
      ),
      'type' => 'text',
      'templateVars' => array(
        'div_class' => 'form-group row',
        'div_tooltip' => 'tooltip',
        'div_tooltip_placement' => 'top',
        'div_tooltip_title' => '追加作業、待ち時間などの追加料金を入力してください。'
      ),
      'class' => 'form-control'      // inputタグのクラス名
    ));
    echo $this->Form->control('advances_paid', array(
      'label' => array(
        'text' => '立替金',       // labelで出力するテキスト
        'class' => 'col-form-label' // labelタグのクラス名
      ),
      'type' => 'text',
      'templateVars' => array(
        'div_class' => 'form-group row',
        'div_tooltip' => 'tooltip',
        'div_tooltip_placement' => 'top',
        'div_tooltip_title' => '立替金を入力してください。高速代などもこちらに入力してください。'
      ),
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
    ?>
  </fieldset>
  <div class="row mt-4">
    <div class="col-12 text-center">
      <button class="btn btn-success mr-3" type="submit">
        <i class="fe-check-circle"></i>
        <span>更新する</span>
      </button>
      <a href="<?= $this->Url->build(['controller'=>'Vouchers','action'=>'view',$delivery->id]); ?>" class="btn btn-info">
        <i class="fe-skip-back"></i>
        <span>詳細に戻る</span>
      </a>
    </div>
  </div>
  <?= $this->Form->end() ?>
</div>
