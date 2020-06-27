<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

	<div class="slimscroll-menu">

		<!-- LOGO -->
		<a href="<?php echo $this->Url->build(['controller' => 'Posts',
			'action' => 'index']); ?>"
			 class="logo text-center mb-4">
			<span class="logo-lg">
				<img src="/assets/images/logo_yoko.png" alt="" height="45">
			</span>
			<span class="logo-sm">
				<img src="/assets/images/logo-sm.png" alt="" height="40">
			</span>
		</a>

		<!--- Sidemenu -->
		<div id="sidebar-menu">

			<ul class="metismenu" id="side-menu">

				<?php
				if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
					?>
					<li>
						<a href="javascript: void(0);">
							<i class="fe-file"></i>
							<span> 固定ページ情報 </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="nav-second-level" aria-expanded="false">
							<li>
								<?= $this->Html->link(__('新規固定ページ'), ['controller' => 'PageNames',
									'action' => 'add']) ?>
							</li>
							<li>
								<?= $this->Html->link(__('固定ページ一覧'), ['controller' => 'PageNames',
									'action' => 'index']) ?>
							</li>
							<?php
							if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) :
								?>
								<li>
									<?= $this->Html->link(__('新規固定ページ（管理者）'), ['controller' => 'PageNames',
										'action' => 'addAdmin']) ?>
								</li>
							<?php
							endif;
							?>
						</ul>
					</li>
					<?php
				}
				?>
				<li>
					<a href="javascript: void(0);">
						<i class="fe-users"></i>
						<span> 会員情報 </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
						<?php
						if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
							?>
							<li>
								<?= $this->Html->link(__('新規会員追加'), ['controller' => 'Users',
									'action' => 'add']) ?>
							</li>
							<?php
						}
						?>
						<li>
							<?= $this->Html->link(__('会員情報一覧'), ['controller' => 'Users',
								'action' => 'index']) ?>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript: void(0);">
						<i class="fe-database"></i>
						<span> 投稿情報 </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
						<li>
							<?= $this->Html->link(__('投稿一覧'), ['controller' => 'Posts',
								'action' => 'index']) ?>
						</li>
						<li>
							<?= $this->Html->link(__('新規投稿'), ['controller' => 'Posts',
								'action' => 'add']) ?>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript: void(0);">
						<i class="fe-list"></i>
						<span> カテゴリ情報 </span>
						<span class="menu-arrow"></span>
					</a>
					<ul class="nav-second-level" aria-expanded="false">
						<li>
							<?= $this->Html->link(__('カテゴリ一覧'), ['controller' => 'Categories',
								'action' => 'index']) ?>
						</li>
						<li>
							<?= $this->Html->link(__('カテゴリ登録'), ['controller' => 'Categories',
								'action' => 'add']) ?>
						</li>
					</ul>
				</li>
			</ul>


		</div>
		<!-- End Sidebar -->

		<div class="clearfix"></div>

	</div>
	<!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
