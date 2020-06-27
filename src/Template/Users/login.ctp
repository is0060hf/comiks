<?php

use App\Utils\FormUtil;

$this->assign('title', 'ログイン画面');
$form_template = FormUtil::getFormTemplate();

?>

<!-- Log In page -->
<div class="container">
	<div class="row vh-100 ">
		<div class="col-12 align-self-center">
			<div class="auth-page">
				<div class="card auth-card shadow-lg">
					<div class="card-body">
						<div class="px-3">
							<div class="auth-logo-box">
								<img src="/metrica_assets/images/icon.jpg" height="55" alt="logo" class="auth-logo">
							</div><!--end auth-logo-box-->

							<div class="text-center auth-logo-text">
								<h4 class="mt-0 mb-3 mt-5">Simple PMS</h4>
								<p class="text-muted mb-0">分析とコンテンツ制作を同時に行う。</p>
							</div> <!--end auth-logo-text-->

							<?= $this->Form->create(null, array('class' => 'form-horizontal auth-form my-4','templates' => $form_template)); ?>

							<?= $this->Form->control('login_cd', array(
								'placeholder' => 'ログインIDを入力してください',
								'label' => array('text' => 'ログインID',
								// labelで出力するテキスト
								'class' => 'col-form-label'
								// labelタグのクラス名
							),
								'type' => 'text',
								'templateVars' => array('div_class' => 'form-group',
									'span_icon' => '<span class="auth-form-icon"><i class="dripicons-user"></i></span>'),
								'class' => 'form-control'
								// inputタグのクラス名
							)); ?>

							<?= $this->Form->control('password', array(
								'placeholder' => 'パスワードを入力してください',
								'label' => array('text' => 'パスワード',
								// labelで出力するテキスト
								'class' => 'col-form-label'
								// labelタグのクラス名
							),
								'type' => 'password',
								'templateVars' => array('div_class' => 'form-group',
									'span_icon' => '<span class="auth-form-icon"><i class="dripicons-lock"></i></span>'),
								'class' => 'form-control'
								// inputタグのクラス名
							)); ?>

							<?= $this->Form->button('ログイン<i class="fas fa-sign-in-alt ml-1"></i>', array('class' => 'btn btn-gradient-primary btn-round btn-block waves-effect waves-light')); ?>

							<?= $this->Form->end(); ?>
						</div><!--end /div-->

						<div class="m-3 text-center text-muted">
							<p class="">アカウントを持っていない方は <a href="../authentication/auth-register.html"
																										 class="text-primary ml-2">新規登録</a>へ</p>
						</div>
					</div><!--end card-body-->
				</div><!--end card-->
				<div class="account-social text-center mt-4">
					<h6 class="my-4">Or Login With</h6>
					<ul class="list-inline mb-4">
						<li class="list-inline-item">
							<a href="" class="">
								<i class="fab fa-facebook-f facebook"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a href="" class="">
								<i class="fab fa-twitter twitter"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a href="" class="">
								<i class="fab fa-google google"></i>
							</a>
						</li>
					</ul>
				</div><!--end account-social-->
			</div><!--end auth-page-->
		</div><!--end col-->
	</div><!--end row-->
</div><!--end container-->
<!-- End Log In page -->
