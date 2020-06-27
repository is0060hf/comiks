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
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'view', $user->id]); ?>">会員情報詳細</a></li>
						<li class="breadcrumb-item active">会員情報編集</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('会員情報編集') ?></h4>
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
								<?= $this->Form->control('mail_address', array(
									'placeholder' => 'お知らせやパスワード変更時に通知',
									'label' => array('text' => 'メールアドレス',
										'class' => 'col-form-label'
									),
									'type' => 'mail',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="far fa-envelope"></i></span>'),
									'class' => 'form-control'
								)); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('job_name', array(
									'placeholder' => '職種や肩書',
									'label' => array('text' => '仕事',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="fas fa-user-tie"></i></span>'),
									'class' => 'form-control'
								)); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<?= $this->Form->control('youtube_account', array(
									'placeholder' => 'YoutubeチャンネルのURL',
									'label' => array('text' => 'Youtube URL',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="fab fa-youtube"></i></span>'),
									'class' => 'form-control'
								)); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('twitter_account', array(
									'placeholder' => 'TwitterアカウントのURL',
									'label' => array('text' => 'Twitter URL',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="fab fa-twitter"></i></span>'),
									'class' => 'form-control'
								)); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<?= $this->Form->control('instagram_account', array(
									'placeholder' => 'InstagramアカウントURL',
									'label' => array('text' => 'Instagram URL',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="fab fa-instagram"></i></span>'),
									'class' => 'form-control'
								)); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('facebook_account', array(
									'placeholder' => 'FacebookアカウントのURL',
									'label' => array('text' => 'Facebook URL',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="fab fa-facebook-f"></i></span>'),
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
