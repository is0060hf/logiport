<script type="text/javascript">
	$(function () {
		function inverseCheck() {
			$(':checkbox.index_selecter').each(function () {
				$(this).prop('checked', !$(this).prop('checked'));
			});
		}

		$('#index_selector_header').on('click', function (event) {
			inverseCheck();
			event.preventDefault();
		});
	});
</script>