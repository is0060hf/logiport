<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

	<div class="slimscroll-menu">

		<!-- LOGO -->
		<a href="<?php echo $this->Url->build(['controller' => 'Vouchers', 'action' => 'index']); ?>"
		   class="logo text-center mb-4">
			<span class="logo-lg">
				<img src="/assets/images/logo.png" alt="" height="60">
			</span>
			<span class="logo-sm">
				<img src="/assets/images/logo-sm.png" alt="" height="24">
			</span>
		</a>

		<!--- Sidemenu -->
		<div id="sidebar-menu">

			<ul class="metismenu" id="side-menu">

				<li class="menu-title">Navigation</li>

				<li>
					<a href="javascript: void(0);">
						<i class="fe-layers"></i>
						<span> 伝票 </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
						<li>
							<?= $this->Html->link(__('新規伝票追加'), ['controller' => 'Vouchers', 'action' => 'add']) ?>
						</li>
						<li>
							<?= $this->Html->link(__('伝票一覧表示'), ['controller' => 'Vouchers', 'action' => 'index']) ?>
						</li>
					</ul>
				</li>

				<?php
					if ($this->request->session()->read('Auth.User.user_role') == 'システム管理者') {
						?>
						<li>
							<a href="javascript: void(0);">
								<i class="fe-edit-1"></i>
								<span> 帳票 </span>
								<span class="menu-arrow"></span>
							</a>
							<ul class="nav-second-level" aria-expanded="false">
								<li>
									<?= $this->Html->link(__('FAX送付状生成'), ['controller' => 'Vouchers', 'action' => 'fax']) ?>
								</li>
								<li>
									<?= $this->Html->link(__('内訳明細書生成'), ['controller' => 'Vouchers', 'action' => 'seikyuu']) ?>
								</li>
								<li>
									<?= $this->Html->link(__('請求書生成'), ['controller' => 'Vouchers', 'action' => 'seikyuuFromUtiwake']) ?>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript: void(0);">
								<i class="fe-user-check"></i>
								<span> ドライバー情報 </span>
								<span class="menu-arrow"></span>
							</a>
							<ul class="nav-second-level" aria-expanded="false">
								<li>
									<?= $this->Html->link(__('新規ユーザ追加'), ['controller' => 'Users', 'action' => 'add']) ?>
								</li>
								<li>
									<?= $this->Html->link(__('ユーザ一覧表示'), ['controller' => 'Users', 'action' => 'index']) ?>
								</li>
								<li>
									<?= $this->Html->link(__('帳票生成'), ['controller' => 'Users', 'action' => 'urikake']) ?>
								</li>
							</ul>
						</li>

						<li>
							<a href="javascript: void(0);">
								<i class="fe-users"></i>
								<span> 顧客管理 </span>
								<span class="menu-arrow"></span>
							</a>
							<ul class="nav-second-level" aria-expanded="false">
								<li>
									<?= $this->Html->link(__('新規顧客追加'), ['controller' => 'Customers', 'action' => 'add']) ?>
								</li>
								<li>
									<?= $this->Html->link(__('顧客一覧表示'), ['controller' => 'Customers', 'action' => 'index']) ?>
								</li>
							</ul>
						</li>
						<?php
					}
				?>

			</ul>

		</div>
		<!-- End Sidebar -->

		<div class="clearfix"></div>

	</div>
	<!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
