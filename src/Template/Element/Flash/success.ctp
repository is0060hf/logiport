<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert" style="z-index: 100;">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<?= $message ?>
</div>