<!-- leftbar-tab-menu -->
<div class="leftbar-tab-menu">
	<div class="main-icon-menu">
		<a href="../crm/crm-index.html" class="logo logo-metrica d-block text-center">
		<span>
			<img src="/metrica_assets/images/icon.jpg" alt="logo" class="rounded-circle thumb-sm mr-1">
		</span>
		</a>
		<nav class="nav">
			<a href="#MetricaDashboard" class="nav-link" data-toggle="tooltip-custom" data-placement="right" title=""
				 data-original-title="ダッシュボード">
				<i data-feather="monitor" class="align-self-center menu-icon icon-dual"></i>
			</a><!--end MetricaDashboards-->

			<a href="#MetricaPages" class="nav-link" data-toggle="tooltip-custom" data-placement="right" title=""
				 data-original-title="固定ページ情報">
				<i data-feather="layout" class="align-self-center menu-icon icon-dual"></i>
			</a><!--end MetricaDashboards-->

			<a href="#MetricaUsers" class="nav-link" data-toggle="tooltip-custom" data-placement="right" title=""
				 data-original-title="会員情報">
				<i data-feather="users" class="align-self-center menu-icon icon-dual"></i>
			</a><!--end MetricaApps-->

			<a href="#MetricaPosts" class="nav-link" data-toggle="tooltip-custom" data-placement="right" title=""
				 data-original-title="投稿情報">
				<i data-feather="file-text" class="align-self-center menu-icon icon-dual"></i>
			</a><!--end MetricaUikit-->

			<a href="#MetricaCategories" class="nav-link" data-toggle="tooltip-custom" data-placement="right" title=""
				 data-original-title="カテゴリ情報">
				<i data-feather="list" class="align-self-center menu-icon icon-dual"></i>
			</a><!--end MetricaPages-->
		</nav><!--end nav-->

		<div class="pro-metrica-end">
			<a href="" class="help" data-toggle="tooltip-custom" data-placement="right" title="" data-original-title="Chat">
				<i data-feather="message-circle" class="align-self-center menu-icon icon-md icon-dual mb-4"></i>
			</a>
			<a href="" class="profile">
				<img src="/metrica_assets/images/users/user-4.jpg" alt="profile-user" class="rounded-circle thumb-sm">
			</a>
		</div>
	</div><!--end main-icon-menu-->

	<div class="main-menu-inner">
		<!-- LOGO -->
		<div class="topbar-left">
			<a href="../dashboard/crm-index.html" class="logo">
				<span>
					<img src="/metrica_assets/images/logo-dark2.png" alt="logo-large" class="logo-lg logo-dark">
					<img src="/metrica_assets/images/logo2.png" alt="logo-large" class="logo-lg logo-light">
				</span>
			</a>
		</div>
		<!--end logo-->
		<div class="menu-body slimscroll">
			<div id="MetricaDashboard" class="main-icon-menu-pane">
				<div class="title-box">
					<h6 class="menu-title">Dashboard</h6>
				</div>
				<ul class="nav">
					<li class="nav-item"><a class="nav-link" href="../analytics/analytics-index.html">Analytic</a></li>
					<li class="nav-item"><a class="nav-link" href="../crypto/crypto-index.html">Crypto</a></li>
					<li class="nav-item"><a class="nav-link" href="../crm/crm-index.html">CRM</a></li>
					<li class="nav-item"><a class="nav-link" href="../projects/projects-index.html">Project</a></li>
					<li class="nav-item"><a class="nav-link" href="../ecommerce/ecommerce-index.html">Ecommerce</a></li>
					<li class="nav-item"><a class="nav-link" href="../helpdesk/helpdesk-index.html">Helpdesk</a></li>
					<li class="nav-item"><a class="nav-link" href="../hospital/hospital-index.html">Hospital</a></li>
				</ul>
			</div><!-- end Dashboards -->

			<div id="MetricaPages" class="main-icon-menu-pane">
				<div class="title-box">
					<h6 class="menu-title">固定ページ情報</h6>
				</div>
				<ul class="nav metismenu">
					<?php
					if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) :
						?>
						<li class="nav-item">
							<?= $this->Html->link(__('新規固定ページ'), ['controller' => 'PageNames',
								'action' => 'addAdmin'], ['class' => 'nav-link']) ?>
						</li>
					<?php
					else:
						?>
						<li class="nav-item">
							<?= $this->Html->link(__('新規固定ページ'), ['controller' => 'PageNames',
								'action' => 'add'], ['class' => 'nav-link']) ?>
						</li>
					<?php
					endif;
					?>
					<li class="nav-item">
						<?= $this->Html->link(__('固定ページ一覧'), ['controller' => 'PageNames',
							'action' => 'index'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item" style="display: none">
						<?= $this->Html->link(__('固定ページ詳細'), ['controller' => 'PageNames',
							'action' => 'view'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item" style="display: none">
						<?= $this->Html->link(__('固定ページ編集'), ['controller' => 'PageNames',
							'action' => 'edit'], ['class' => 'nav-link']) ?>
					</li>
				</ul>
			</div><!-- end Pages -->

			<div id="MetricaUsers" class="main-icon-menu-pane">
				<div class="title-box">
					<h6 class="menu-title">会員情報</h6>
				</div>
				<ul class="nav metismenu">
					<?php
					if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
						?>
						<li class="nav-item">
							<?= $this->Html->link(__('新規会員追加'), ['controller' => 'Users',
								'action' => 'add'], ['class' => 'nav-link']) ?>
						</li>
						<?php
					}
					?>
					<li class="nav-item">
						<?= $this->Html->link(__('会員情報一覧'), ['controller' => 'Users',
							'action' => 'index'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item" style="display: none">
						<?= $this->Html->link(__('会員情報詳細'), ['controller' => 'Users',
							'action' => 'view'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item" style="display: none">
						<?= $this->Html->link(__('会員情報編集'), ['controller' => 'Users',
							'action' => 'edit'], ['class' => 'nav-link']) ?>
					</li>
				</ul>
			</div><!-- end Crypto -->

			<div id="MetricaPosts" class="main-icon-menu-pane">
				<div class="title-box">
					<h6 class="menu-title">投稿情報</h6>
				</div>
				<ul class="nav metismenu">
					<li class="nav-item">
						<?= $this->Html->link(__('投稿一覧'), ['controller' => 'Posts',
							'action' => 'index'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item">
						<?= $this->Html->link(__('新規投稿'), ['controller' => 'Posts',
							'action' => 'add'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item" style="display: none">
						<?= $this->Html->link(__('投稿詳細'), ['controller' => 'Posts',
								'action' => 'view'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item" style="display: none">
						<?= $this->Html->link(__('投稿編集'), ['controller' => 'Posts',
								'action' => 'edit'], ['class' => 'nav-link']) ?>
					</li>
				</ul><!--end nav-->
			</div><!-- end Others -->

			<div id="MetricaCategories" class="main-icon-menu-pane">
				<div class="title-box">
					<h6 class="menu-title">カテゴリ情報</h6>
				</div>
				<ul class="nav metismenu">
					<li class="nav-item">
						<?= $this->Html->link(__('カテゴリ一覧'), ['controller' => 'Categories',
							'action' => 'index'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item">
						<?= $this->Html->link(__('カテゴリ登録'), ['controller' => 'Categories',
							'action' => 'add'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item" style="display: none">
						<?= $this->Html->link(__('カテゴリ詳細'), ['controller' => 'Categories',
								'action' => 'view'], ['class' => 'nav-link']) ?>
					</li>
					<li class="nav-item" style="display: none">
						<?= $this->Html->link(__('カテゴリ編集'), ['controller' => 'Categories',
								'action' => 'edit'], ['class' => 'nav-link']) ?>
					</li>
				</ul><!--end nav-->
			</div><!-- end Others -->
		</div><!--end menu-body-->
	</div><!-- end main-menu-inner-->
</div>
<!-- end leftbar-tab-menu-->
