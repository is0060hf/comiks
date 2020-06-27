<?php
	/**
	 * @var \App\View\AppView      $this
	 * @var \App\Model\Entity\User $user
	 */

	use App\Utils\FormUtil;
	$form_template = FormUtil::getFormTemplate();
 ?>
<div class="container-fluid">
	<!-- Page-Title -->
	<div class="row">
		<div class="col-sm-12">
			<div class="page-title-box">
				<div class="float-right">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Posts', 'action' => 'index']); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>">会員情報一覧</a></li>
						<li class="breadcrumb-item active">新規会員登録</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('新規会員登録') ?></h4>
			</div><!--end page-title-box-->
		</div><!--end col-->
	</div>

	<!-- end page title end breadcrumb -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					<?= $this->Form->create($user, array('templates' => $form_template,
						'type' => 'file')); ?>
					<fieldset>
						<legend><?= __('新規ユーザー登録') ?></legend>
						<p class="text-muted mb-3"><?= __('新規登録するユーザーの情報を入力してください。') ?></p>

						<?= $this->Flash->render() ?>

						<div class="row">
							<div class="col-sm-6">
								<?= $this->Form->control('login_cd', array(
									'placeholder' => '他のユーザーと重複しないログイン用のID',
									'label' => array('text' => 'ログインID',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group'),
									'class' => 'form-control'
								)); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('login_name', array(
									'placeholder' => 'あなたの名前もしくはペンネーム',
									'label' => array('text' => 'ユーザー名',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group'),
									'class' => 'form-control'
								)); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<?= $this->Form->control('password', array(
									'placeholder' => 'ログインに使用するパスワード',
									'label' => array('text' => 'パスワード',
										'class' => 'col-form-label'
									),
									'type' => 'password',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="fas fa-lock"></i></span>'),
									'class' => 'form-control'
								)); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('confirm_password', array(
									'placeholder' => '確認用に同じパスワードを入力',
									'label' => array('text' => 'パスワード（確認用）',
										'class' => 'col-form-label'
									),
									'type' => 'password',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="fas fa-lock"></i></span>'),
									'class' => 'form-control'
								)); ?>
							</div>
						</div>
					</fieldset>
					<div class="row mt-4">
						<div class="col-12 text-center">
							<button class="btn btn-primary mr-3" type="submit">
								<i class="fe-check-circle"></i>
								<span>登録する</span>
							</button>
							<a href="<?= $this->Url->build(['controller' => 'Users',
								'action' => 'index']); ?>" class="btn btn-info">
								<i class="fe-skip-back"></i>
								<span>一覧に戻る</span>
							</a>
						</div>
					</div>
					<?= $this->Form->end() ?>
				</div><!--end card-body-->
			</div><!--end card-->
		</div>
	</div>
</div><!-- container -->
