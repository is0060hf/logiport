<script type="text/javascript">
	$(function () {
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

			return Math.round(sum_price1 * 0.0008) * 100;

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