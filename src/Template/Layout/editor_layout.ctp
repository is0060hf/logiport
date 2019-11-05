<!DOCTYPE html>
<html lang="ja">
	<head>
		<?= $this->Html->charset() ?>
		<title><?= $this->fetch('title') ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
		<meta content="Coderthemes" name="author"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<!-- App favicon -->
		<link rel="shortcut icon" href="/assets/images/favicon.ico">

		<!-- Sweet Alert-->
		<link href="/css/vendor/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

		<!-- Summernote css -->
		<link href="/css/vendor/summernote-bs4.css" rel="stylesheet" type="text/css"/>

		<!-- Notification css (Toastr) -->
		<link href="/css/vendor/toastr.min.css" rel="stylesheet" type="text/css"/>

		<!-- plugins css-->
		<link href="/css/vendor/switchery.min.css" rel="stylesheet" type="text/css">

		<!-- App css -->
		<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="/css/icons.min.css" rel="stylesheet" type="text/css"/>
		<link href="/css/app.min.css" rel="stylesheet" type="text/css"/>
		<link href="/css/styles.css" rel="stylesheet" type="text/css"/>
	</head>

	<body>

		<!-- Begin page -->
		<div id="wrapper">

			<?= $this->element('sidebar') ?>

			<div class="content-page">

				<div class="content">

					<?= $this->element('header') ?>
					<?= $this->Flash->render() ?>

					<?= $this->fetch('content') ?>

				</div> <!-- content -->

			</div>
		</div>
		<!-- END wrapper -->


		<!-- App js -->
		<script src="/js/search.js"></script>
		<script src="/js/vendor.min.js"></script>
		<script src="/js/app.min.js"></script>

		<!-- Summernote js -->
		<script src="/js/vendor/summernote-bs4.min.js"></script>

		<!-- App js -->
		<script src="/js/vendor/sweetalert2.min.js"></script>
		<script src="/js/pages/sweet-alerts.init.js"></script>

		<!-- Toaster js -->
		<script src="/js/vendor/toastr.min.js"></script>
		<script src="/js/pages/toastr.init.js"></script>

		<script src="/js/vendor/switchery.min.js"></script>
		<script src="/js/vendor/bootstrap-maxlength.min.js"></script>
		<script src="/js/pages/form-advanced.init.js"></script>

		<script>
			jQuery(document).ready(function () {
				$('.summernote-editor').summernote({
					height: 250,                 // set editor height
					minHeight: null,             // set minimum height of editor
					maxHeight: null,             // set maximum height of editor
					focus: false,                 // set focus to editable area after initializing summernote
					onImageUpload: function (files, editor, welEditable) {
						sendFile(files[0], editor, welEditable);
					}
				});
			});

			function sendFile(file, editor, welEditable) {
				data = new FormData();
				data.append("file", file);
				$.ajax({
					url: "/ajax/_save_images.php",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST',
					success: function (data) {
						alert(data);
						editor.insertImage(welEditable, data);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(textStatus + " " + errorThrown);
					}
				});
			}
		</script>
		<script type="text/javascript">
			$(function () {
				if($('#deliveryman_name').length){
					if(!$('#deliveryman_name').is(':hidden')){
						$("#deliveryman_name").select2({
							tags: true
						});
					}
				}

				if($('#customers_name').length){
					if(!$('#customers_name').is(':hidden')){
						$("#customers_name").select2({
							tags: true
						});
					}
				}

				if($('#delivery_dest').length){
					if(!$('#delivery_dest').is(':hidden')){
						$("#delivery_dest").select2({
							tags: true
						});
					}
				}

				if($('#start_location').length){
					if(!$('#start_location').is(':hidden')){
						$("#start_location").select2({
							tags: true
						});
					}
				}

				if($('#destination').length){
					if(!$('#destination').is(':hidden')){
						$("#destination").select2({
							tags: true
						});
					}
				}

				$('#deliveryman_name').on('change', function () {
					$.ajax({
						url: "<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'ajaxGetUserInfo']); ?>",
						type: 'get',
						async: false,
						data: {
							'userid': $('#deliveryman_name').val()
						}
					})
					// Ajaxリクエストが成功した時発動
						.done((data) => {
							if (data.status) {
								$('#car_numb').val(data.result['car_numb']);
							} else {
								console.log("対象データなし");
								console.log(data);
							}
						})
						// Ajaxリクエストが失敗した時発動
						.fail((data) => {
							console.log(data);
						})
				});
				$('#customers_name').on('change', function () {
					$.ajax({
						url: "<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'ajaxGetDeliveryDest']); ?>",
						type: 'get',
						async: false,
						data: {
							'customersName': $('#customers_name').val()
						}
					})
					// Ajaxリクエストが成功した時発動
						.done((data) => {
							if (data.status) {
								$('#customers_phone').val(data.result['customers_phone']);
								$('#delivery_dest').val(data.result['delivery_dest']);
								$('#dist_outward').trigger('change');
								$('#dist_return').trigger('change');
								$('#cargo_handling_fee').trigger('change');
							} else {
								console.log("対象データなし");
								console.log(data);
							}
						})
						// Ajaxリクエストが失敗した時発動
						.fail((data) => {
							console.log(data);
						})
				});
				$('#dist_outward').on('change', function () {
					$.ajax({
						url: "<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'ajaxGetPriceFromDistance']); ?>",
						type: 'get',
						async: false,
						data: {
							'dist': $('#dist_outward').val(),
							'cst_name': $('#customers_name').val()
						}
					})
					// Ajaxリクエストが成功した時発動
						.done((data) => {
							if (data.status) {
								$('#price_outword').val(data.result['price']);
								$('#price_outword').trigger('change');
							} else {
								console.log("対象データなし");
								console.log(data);
							}
						})
						// Ajaxリクエストが失敗した時発動
						.fail((data) => {
							console.log(data);
						})
				});
				$('#dist_return').on('change', function () {
					$.ajax({
						url: "<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'ajaxGetPriceFromDistance']); ?>",
						type: 'get',
						async: false,
						data: {
							'dist': $('#dist_return').val(),
							'cst_name': $('#customers_name').val()
						}
					})
					// Ajaxリクエストが成功した時発動
						.done((data) => {
							if (data.status) {
								$('#price_return').val(data.result['price']);
								$('#price_return').trigger('change');
								$('#has_return_cargo').trigger('change');
							} else {
								console.log("対象データなし");
								console.log(data);
							}
						})
						// Ajaxリクエストが失敗した時発動
						.fail((data) => {
							console.log(data);
						})
				});
				$('#distance').on('change', function () {
					$.ajax({
						url: "<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'ajaxGetPriceFromDistance']); ?>",
						type: 'get',
						async: false,
						data: {
							'dist': $('#distance').val(),
							'cst_name': $('#customers_name').val()
						}
					})
					// Ajaxリクエストが成功した時発動
						.done((data) => {
							if (data.status) {
								$('#price').val(data.result['price']);
								$('#price').trigger('change');
							} else {
								console.log("対象データなし");
								console.log(data);
							}
						})
						// Ajaxリクエストが失敗した時発動
						.fail((data) => {
							console.log(data);
						})
				});
				$('#start_location').on('change', function () {
					$.ajax({
						url: "<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'ajaxGetDistanceLongest']); ?>",
						type: 'get',
						async: false,
						data: {
							'start_location': $('#start_location').val(),
							'destination': $('#destination').val()
						}
					})
					// Ajaxリクエストが成功した時発動
						.done((data) => {
							if (data.status) {
								$('#distance').val(data.result['distance']);
								$('#distance').trigger('change');
							} else {
								console.log("対象データなし");
								console.log(data);
								$('#distance').val(0);
								$('#distance').trigger('change');
							}
						})
						// Ajaxリクエストが失敗した時発動
						.fail((data) => {
							console.log(data);
						})
				});
				$('#destination').on('change', function () {
					$.ajax({
						url: "<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'ajaxGetDistanceLongest']); ?>",
						type: 'get',
						async: false,
						data: {
							'start_location': $('#start_location').val(),
							'destination': $('#destination').val()
						}
					})
					// Ajaxリクエストが成功した時発動
						.done((data) => {
							if (data.status) {
								$('#distance').val(data.result['distance']);
								$('#distance').trigger('change');
							} else {
								console.log("対象データなし");
								console.log(data);
								$('#distance').val(0);
								$('#distance').trigger('change');
							}
						})
						// Ajaxリクエストが失敗した時発動
						.fail((data) => {
							console.log(data);
						})
				});

				function getSumPrice() {
					var price_outword = parseInt($('#price_outword').val());
					var price_return = parseInt($('#price_return').val());
					var cargo_handling_fee = parseInt($('#cargo_handling_fee').val());
					var cargo_waiting_fee = parseInt($('#cargo_waiting_fee').val());

					if (isNaN(price_outword)) {
						price_outword = 0;
					}

					if (isNaN(price_return)) {
						price_return = 0;
					}

					if (isNaN(cargo_handling_fee)) {
						cargo_handling_fee = 0;
					}

					if (isNaN(cargo_waiting_fee)) {
						cargo_waiting_fee = 0;
					}

					return price_outword + price_return + cargo_handling_fee + cargo_waiting_fee;
				}

				function getTax() {
					var sum_price1 = parseInt($('#sum_price1').val());

					if (isNaN(sum_price1)) {
						sum_price1 = 0;
					}

					return Math.round(sum_price1 * 0.0008)*100;

				}

				function getSumPrice2() {
					var sum_price1 = parseInt($('#sum_price1').val());
					var tax = parseInt($('#tax').val());

					if (isNaN(sum_price1)) {
						sum_price1 = 0;
					}

					if (isNaN(tax)) {
						tax = 0;
					}

					return sum_price1 + tax;
				}

				function inverseCheck(){
					$(':checkbox.index_selecter').each(function() {
							$(this).prop('checked', !$(this).prop('checked'));
					});
				}

				$('#index_selector_header').on('click', function (event) {
					inverseCheck();
					event.preventDefault();
				});
				$('#price_outword').on('change', function () {
					$('#sum_price1').val(getSumPrice());
					$('#sum_price1').trigger('change');
				});
				$('#price_return').on('change', function () {
					$('#sum_price1').val(getSumPrice());
					$('#sum_price1').trigger('change');
				});
				$('#cargo_handling_fee').on('change', function () {
					$('#sum_price1').val(getSumPrice());
					$('#sum_price1').trigger('change');
				});
				$('#cargo_waiting_fee').on('change', function () {
					$('#sum_price1').val(getSumPrice());
					$('#sum_price1').trigger('change');
				});
				$('#sum_price1').on('change', function () {
					$('#tax').val(getTax());
					$('#sum_price2').val(getSumPrice2());
				});
				$('#has_return_cargo').on('change', function () {
					if ($('#has_return_cargo').val() == "あり") {
						$.ajax({
							url: "<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'ajaxGetCargoHandlingFee']); ?>",
							type: 'get',
							async: false,
							data: {
								'price_return': $('#price_return').val(),
								'cst_name': $('#customers_name').val()
							}
						})
						// Ajaxリクエストが成功した時発動
							.done((data) => {
								if (data.status) {
									$('#cargo_handling_fee').val(data.result['price']);
									$('#cargo_handling_fee').trigger('change');
								} else {
									console.log("対象データなし");
									console.log(data);
								}
							})
							// Ajaxリクエストが失敗した時発動
							.fail((data) => {
								console.log(data);
							});
					} else {
						$('#cargo_handling_fee').val("");
						$('#cargo_handling_fee').trigger('change');
					}
				});
			});
		</script>
	</body>
</html>