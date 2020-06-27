<?php
	/**
	 * @var \App\View\AppView      $this
	 * @var \App\Model\Entity\Post $post
	 */

use App\Utils\CategoryUtil;
use Cake\ORM\TableRegistry;
	$authorData = TableRegistry::get('Users')->find()->where(['id' => $post->user_id])->first();
?>
<div class="container-fluid">
	<!-- Page-Title -->
	<div class="row">
		<div class="col-sm-12">
			<div class="page-title-box">
				<div class="float-right">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a
									href="<?php echo $this->Url->build(['controller' => 'Posts',
											'action' => 'index']); ?>">Home</a></li>
						<li class="breadcrumb-item"><a
									href="<?php echo $this->Url->build(['controller' => 'Posts',
											'action' => 'index']); ?>">投稿一覧</a></li>
						<li class="breadcrumb-item active">投稿詳細</li>
					</ol>
				</div>
				<h4 class="page-title">投稿詳細</h4>
			</div><!--end page-title-box-->
		</div><!--end col-->
	</div>

	<!-- end page title end breadcrumb -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body  met-pro-bg">
					<div class="met-profile">
						<div class="row">
							<div class="col-lg-4 align-self-center mb-3 mb-lg-0">
								<div class="met-profile-main">
									<div class="met-profile-main-pic">
										<?php if (isset($authorData->icon_image_path)) { ?>
											<img src="<?= h($authorData->icon_image_path) ?>" alt="user-icon" class="rounded-circle user-icon"
											     style="width: 128px;">
										<?php } else { ?>
											<img src="/img/default_icon/antelope.svg" alt="user-icon" class="rounded-circle"
											     style="width: 128px;">
										<?php } ?>
										<span class="fro-profile_main-pic-change">
											<i class="fas fa-camera"></i>
										</span>
									</div>
									<div class="met-profile_user-detail">
										<h5 class="met-user-name"><?= h($user->login_name) ?><span class="btn btn-outline-orange shadow-none btn-circle ml-3"><i class="fas fa-chess-queen"></i></span></h5>
										<p class="mb-0 met-user-name-post"><?= h($user->job_name) ?></p>
									</div>
								</div>
							</div><!--end col-->
							<div class="col-lg-4 ml-auto">
								<ul class="list-unstyled personal-detail">
									<li class=""><i class="dripicons-calendar mr-2 text-info font-18"></i> <b> 登録日 </b>
										: <?= h($post->created) ?></li>
									<li class="mt-2"><i class="dripicons-article text-info font-18 mt-2 mr-2"></i> <b> 公開日 </b>
										: <?= h($post->open_date) ?></li>
									<li class="mt-2"><i class="dripicons-lock text-info font-18 mt-2 mr-2"></i> <b>状態</b>
										: <?= h($post->is_open) ?></li>
								</ul>
							</div><!--end col-->
						</div><!--end row-->
					</div><!--end f_profile-->
				</div><!--end card-body-->
				<div class="card-body">
					<ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="basic_tab" data-toggle="pill" href="#basic"><?= __('基本情報') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="feature_image_tab" data-toggle="pill" href="#feature_image"><?= __('アイキャッチ画像') ?></a>
						</li>
					</ul>
				</div><!--end card-body-->
			</div><!--end card-->
		</div><!--end col-->
	</div><!--end row-->
	<div class="row">
		<div class="col-12">
			<div class="tab-content detail-list" id="pills-tabContent">
				<div class="tab-pane fade show active" id="basic">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<h4 class="header-title mt-0">><?= h($post->title) ?></h4>
									<h6 class="sub-header-title">><?= h($post->title_sub1) ?></h6>
									<p class="sub-header-title mb-4">><?= h($post->title_sub2) ?></p>
									<div class="row">
										<div class="col-12">
											<?= $post->context ?>
										</div>
									</div>
								</div><!--end card-body-->
							</div><!--end card-->
						</div><!--end col-->
					</div><!--end row-->
				</div><!--end education detail-->

				<div class="tab-pane fade" id="feature_image">
					<div class="row">
						<div class="col-lg-12 col-xl-9 mx-auto">
							<div class="card">
								<div class="card-body">
									<?= $this->Form->create($user, array('templates' => $form_template,
											'url' => [ 'controller' => 'posts',
													'action' => 'edit', $user->id],
											'type' => 'file')); ?>
									<fieldset>
										<legend><?= __('アイキャッチ画像') ?></legend>
										<p class="text-muted mb-3"><?= __('アイキャッチとなる画像の設定') ?></p>


										<div class="row">
											<div class="col-md-6">
												<?= $this->Form->control('featured_image', array('label' => array('text' => 'アイキャッチ画像',
														'class' => 'col-form-label'),
														'type' => 'file',
														'id' => 'featured_image',
														'class' => 'form-control',
														'data-default-file' => $post->featured_image)); ?>
											</div>
										</div>
									</fieldset>
									<?= $this->Form->hidden('post_id', array('value' => $post->id, 'id' => 'view_post_id')); ?>
									<?= $this->Form->end() ?>
								</div>
							</div>
						</div> <!--end col-->
					</div><!--end row-->
				</div><!--end settings detail-->
			</div><!--end tab-content-->

		</div><!--end col-->
	</div><!--end row-->

</div><!-- container -->