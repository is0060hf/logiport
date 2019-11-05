<?php
	$this->assign('title', '権限エラー');
?>

<h4 class="text-uppercase text-danger mt-3">権限エラーが発生しました。</h4>
<p class="text-muted mt-3">ご指定頂きました操作は、現在ログインしているユーザーでは実行権限がございません。恐れ入りますが、トップ画面より再度やり直してください。また、正規の操作をしているにもかかわらず、同様の現象が連続して発生する場合には、お手数おかけいたしますがシステム管理者までお問い合わせいただければ幸いです。</p>
<?= $this->Html->link("ホームへ戻る", ['controller'=>'Vouchers', 'action'=>'index'],['class'=>'btn btn-info btn-block mt-3']); ?>
