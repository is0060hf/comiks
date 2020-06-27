<?php

use Cake\ORM\TableRegistry;

$header_user = null;
if ($this->request->session()->check('Auth')) {
	$header_user_id = $this->request->session()->read('Auth.User.id');
	$header_user = TableRegistry::get('Users')->find('All')->where(['id' => $header_user_id])->first();
}

?>
<!-- Top Bar Start -->
<div class="topbar">
	<!-- Navbar -->
	<nav class="navbar-custom">
		<ul class="list-unstyled topbar-nav float-right mb-0">
			<li class="dropdown notification-list">
				<a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#"
					 role="button"
					 aria-haspopup="false" aria-expanded="false">
					<i class="ti-bell noti-icon"></i>
					<span class="badge badge-danger badge-pill noti-icon-badge">2</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">

					<h6
						class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
						Notifications <span class="badge badge-light badge-pill">2</span>
					</h6>
					<div class="slimscroll notification-list">
						<!-- item-->
						<a href="#" class="dropdown-item py-3">
							<small class="float-right text-muted pl-2">2 min ago</small>
							<div class="media">
								<div class="avatar-md bg-primary">
									<i class="la la-cart-arrow-down text-white"></i>
								</div>
								<div class="media-body align-self-center ml-2 text-truncate">
									<h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
									<small class="text-muted mb-0">Dummy text of the printing and industry.</small>
								</div><!--end media-body-->
							</div><!--end media-->
						</a><!--end-item-->
						<!-- item-->
						<a href="#" class="dropdown-item py-3">
							<small class="float-right text-muted pl-2">10 min ago</small>
							<div class="media">
								<div class="avatar-md bg-success">
									<i class="la la-group text-white"></i>
								</div>
								<div class="media-body align-self-center ml-2 text-truncate">
									<h6 class="my-0 font-weight-normal text-dark">Meeting with designers</h6>
									<small class="text-muted mb-0">It is a long established fact that a reader.</small>
								</div><!--end media-body-->
							</div><!--end media-->
						</a><!--end-item-->
						<!-- item-->
						<a href="#" class="dropdown-item py-3">
							<small class="float-right text-muted pl-2">40 min ago</small>
							<div class="media">
								<div class="avatar-md bg-pink">
									<i class="la la-list-alt text-white"></i>
								</div>
								<div class="media-body align-self-center ml-2 text-truncate">
									<h6 class="my-0 font-weight-normal text-dark">UX 3 Task complete.</h6>
									<small class="text-muted mb-0">Dummy text of the printing.</small>
								</div><!--end media-body-->
							</div><!--end media-->
						</a><!--end-item-->
						<!-- item-->
						<a href="#" class="dropdown-item py-3">
							<small class="float-right text-muted pl-2">1 hr ago</small>
							<div class="media">
								<div class="avatar-md bg-warning">
									<i class="la la-truck text-white"></i>
								</div>
								<div class="media-body align-self-center ml-2 text-truncate">
									<h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
									<small class="text-muted mb-0">It is a long established fact that a reader.</small>
								</div><!--end media-body-->
							</div><!--end media-->
						</a><!--end-item-->
						<!-- item-->
						<a href="#" class="dropdown-item py-3">
							<small class="float-right text-muted pl-2">2 hrs ago</small>
							<div class="media">
								<div class="avatar-md bg-info">
									<i class="la la-check-circle text-white"></i>
								</div>
								<div class="media-body align-self-center ml-2 text-truncate">
									<h6 class="my-0 font-weight-normal text-dark">Payment Successfull</h6>
									<small class="text-muted mb-0">Dummy text of the printing.</small>
								</div><!--end media-body-->
							</div><!--end media-->
						</a><!--end-item-->
					</div>
					<!-- All-->
					<a href="javascript:void(0);" class="dropdown-item text-center text-primary">
						View all <i class="fi-arrow-right"></i>
					</a>
				</div>
			</li>

			<li class="dropdown">
				<a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#"
					 role="button"
					 aria-haspopup="false" aria-expanded="false">
					<?php
					if ($this->request->session()->check('Auth')) {
						?>
						<?php if ($header_user->icon_image_path) { ?>
							<img src="<?= $header_user->icon_image_path ?>" alt="profile-user" class="rounded-circle"/>
						<?php } else { ?>
							<img src="/assets/images/users/avatar.png" alt="profile-user" class="rounded-circle"/>
						<?php } ?>
						<span class="pro-user-name ml-1"><?= $header_user->login_name ?></span>
						<?php
					} else {
						?>
						<i class="fe-user noti-icon"></i>
						<?php
					}
					?>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<?php
					if ($this->request->session()->check('Auth')) {
						?>
						<a
							href="<?= $this->Url->build(['controller' => 'Users',
								'action' => 'view',
								$this->request->session()->read('Auth.User.id')]); ?>"
							class="dropdown-item notify-item">
							<i class="mdi mdi-account-details mr-2"></i>
							<span>ユーザー情報</span>
						</a>
						<a
							href="<?= $this->Url->build(['controller' => 'Users',
								'action' => 'edit',
								$this->request->session()->read('Auth.User.id')]); ?>"
							class="dropdown-item notify-item">
							<i class="mdi mdi-account-edit mr-2"></i>
							<span>ユーザー設定</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="<?= $this->Url->build(['controller' => 'Users',
							'action' => 'logout']); ?>"
							 class="dropdown-item notify-item">
							<i class="mdi mdi-logout mr-2"></i>
							<span>ログアウト</span>
						</a>
						<?php
					} else {
						?>
						<a href="<?= $this->Url->build(['controller' => 'Users',
							'action' => 'add']); ?>"
							 class="dropdown-item notify-item">
							<i class="mdi mdi-account-plus-outline mr-2"></i>
							<span>新規会員登録</span>
						</a>
						<a href="<?= $this->Url->build(['controller' => 'Users',
							'action' => 'login']); ?>"
							 class="dropdown-item notify-item">
							<i class="mdi mdi-login mr-2">
							<span>ログイン</span>
						</a>
						<?php
					}
					?>
				</div>
			</li>
			<li class="mr-2">
				<a href="#" class="nav-link" data-toggle="modal" data-animation="fade" data-target=".modal-rightbar">
					<i data-feather="align-right" class="align-self-center"></i>
				</a>
			</li>
		</ul><!--end topbar-nav-->

		<ul class="list-unstyled topbar-nav mb-0">
			<li>
				<span class="responsive-logo">
				<img src="/metrica_assets//images/logo-sm.png" alt="logo-small"
						 class="logo-sm align-self-center" height="34">
				</span>
			</li>
			<li>
				<button class="button-menu-mobile nav-link waves-effect waves-light">
					<i class="dripicons-menu nav-icon"></i>
				</button>
			</li>
			<li class="dropdown">
				<a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#"
					 role="button"
					 aria-haspopup="false" aria-expanded="false">
					<span class="ml-1 p-2 bg-soft-classic nav-user-name hidden-sm rounded">System <i
							class="mdi mdi-chevron-down"></i> </span>
				</a>
				<div class="dropdown-menu dropdown-xl dropdown-menu-left p-0">
					<div class="row no-gutters">
						<div class="col-12 col-lg-6">
							<div class="text-center system-text">
								<h4 class="text-white">The Poworfull Dashboard</h4>
								<p class="text-white">See all the pages Metrica.</p>
								<a href="https://mannatthemes.com/metrica/" class="btn btn-sm btn-pink mt-2">See Dashboard</a>
							</div>
							<div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
								<div class="carousel-inner">
									<div class="carousel-item active">
										<img src="/metrica_assets//images/dashboard/dash-1.png" class="d-block img-fluid" alt="...">
									</div>
									<div class="carousel-item">
										<img src="/metrica_assets//images/dashboard/dash-4.png" class="d-block img-fluid" alt="...">
									</div>
									<div class="carousel-item">
										<img src="/metrica_assets//images/dashboard/dash-2.png" class="d-block img-fluid" alt="...">
									</div>
									<div class="carousel-item">
										<img src="/metrica_assets//images/dashboard/dash-3.png" class="d-block img-fluid" alt="...">
									</div>
								</div>
							</div>
						</div><!--end col-->
						<div class="col-12 col-lg-6">
							<div class="divider-custom mb-0">
								<div class="divider-text bg-light">All Dashboard</div>
								</divi>
								<div class="p-4">
									<div class="row">
										<div class="col-6">
											<a class="dropdown-item mb-2" href="../analytics/analytics-index.html"> Analytics</a>
											<a class="dropdown-item mb-2" href="../crypto/crypto-index.html"> Crypto</a>
											<a class="dropdown-item mb-2" href="../crm/crm-index.html"> CRM</a>
											<a class="dropdown-item" href="../projects/projects-index.html"> Project</a>
										</div>
										<div class="col-6">
											<a class="dropdown-item mb-2" href="../ecommerce/ecommerce-index.html"> Ecommerce</a>
											<a class="dropdown-item mb-2" href="../helpdesk/helpdesk-index.html"> Helpdesk</a>
											<a class="dropdown-item" href="../hospital/hospital-index.html"> Hospital</a>
										</div>
									</div>
								</div>
							</div><!--end col-->
						</div><!--end row-->
					</div>
			</li>
			<li class="hide-phone app-search">
				<form role="search" class="">
					<input type="text" id="AllCompo" placeholder="Search..." class="form-control">
					<a href=""><i class="fas fa-search"></i></a>
				</form>
			</li>
		</ul>
	</nav>
	<!-- end navbar-->
</div>
<!-- Top Bar End -->
