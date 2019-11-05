
<!DOCTYPE html>
<html lang="ja">
<head>
	<?= $this->Html->charset() ?>
	<title><?= $this->fetch('title') ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="会員管理システム" name="description"/>
	<meta content="SoLA2" name="author"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<!-- App favicon -->
	<link rel="shortcut icon" href="/assets/images/favicon.ico">

	<!-- App css -->
	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/icons.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/app.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/styles.css" rel="stylesheet" type="text/css"/>
</head>

<body class="authentication-bg">

<div class="account-pages mt-5 mb-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-5">
				<div class="card">

					<div class="card-body p-4">

						<div class="text-center w-75 m-auto">
							<span><img src="/assets/images/logo.png" alt="" height="60"></span>
							<p class="text-muted mb-4 mt-3">ログイン情報を入力してください。</p>
						</div>

						<?= $this->Flash->render() ?>
						<?= $this->fetch('content') ?>
					</div> <!-- end card-body -->
				</div>
				<!-- end card -->

			</div> <!-- end col -->
		</div>
		<!-- end row -->
	</div>
	<!-- end container -->
</div>
<!-- end page -->


<!-- App js -->
<script src="/js/vendor.min.js"></script>
<script src="/js/app.min.js"></script>

</body>
</html>
