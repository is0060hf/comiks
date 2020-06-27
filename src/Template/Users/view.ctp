<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use App\Utils\FormUtil;
use App\Utils\StringUtil;
use App\Utils\UserUtil;
use App\Utils\CategoryUtil;
use App\Utils\PostUtil;

$form_template = FormUtil::getFormTemplate();
$categories = CategoryUtil::getCategoryListFromUserId($user->id);
$posts = PostUtil::getPostListFromUserId($user->id);
$contacts = UserUtil::getContactList($user->id);
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
								href="<?php echo $this->Url->build(['controller' => 'Users',
									'action' => 'index']); ?>">会員情報一覧</a></li>
						<li class="breadcrumb-item active">ユーザー詳細</li>
					</ol>
				</div>
				<h4 class="page-title">ユーザー詳細</h4>
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
										<?php if (isset($user->icon_image_path)) { ?>
											<img src="<?= h($user->icon_image_path) ?>" alt="user-icon" class="rounded-circle user-icon"
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
										: <?= h($user->created) ?></li>
									<li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b> メール </b>
										: <?= h($user->mail_address) ?></li>
									<li class="mt-2"><i class="dripicons-user-id text-info font-18 mt-2 mr-2"></i> <b>ID</b>
										: <?= h($user->login_cd) ?></li>
								</ul>
								<div class="button-list btn-social-icon">
									<?= UserUtil::getSNSButton($user->facebook_account, 'fa-facebook-f', 'btn-blue') ?>
									<?= UserUtil::getSNSButton($user->twitter_account, 'fa-twitter', 'btn-secondary ml-2') ?>
									<?= UserUtil::getSNSButton($user->instagram_account, 'fa-instagram', 'btn-pink ml-2') ?>
									<?= UserUtil::getSNSButton($user->youtube_account, 'fa-youtube', 'btn-danger ml-2') ?>
								</div>
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
							<a class="nav-link" id="post_tab" data-toggle="pill" href="#post"><?= __('投稿情報') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="category_tab" data-toggle="pill" href="#category"><?= __('カテゴリ') ?></a>
						</li>
						<?php
						if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM || $this->request->session()
								->read('Auth.User.id') == $user->id):
							?>
							<li class="nav-item" style="display: none;">
								<a class="nav-link" id="payment_tab" data-toggle="pill" href="#payment"><?= __('精算情報') ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="post_edit_tab" data-toggle="pill" href="#post_edit"><?= __('投稿設定') ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="contact_tab" data-toggle="pill" href="#contact"><?= __('問い合わせ') ?></a>
							</li>
						<?php
						endif;
						?>
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
									<h4 class="header-title mt-0 mb-4"><?= __('カテゴリ一覧') ?></h4>
									<div class="table-responsive">
										<table cellpadding="0" cellspacing="0" class="table table-striped table-hover mb-0"
													 style="min-width: 720px;">
											<thead class="thead-light">
											<tr>
												<th scope="col" style="width: 30%;"><?= $this->Paginator->sort('category_name', 'カテゴリ名') ?></th>
												<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('created', '作成日') ?></th>
												<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('modified', '更新日') ?></th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($categories as $category): ?>
												<tr>
													<td class="align-middle"><?= h($category->category_name) ?></td>
													<td class="align-middle"><?= h($category->created) ?></td>
													<td class="align-middle"><?= h($category->modified) ?></td>
												</tr>
											<?php endforeach; ?>
											</tbody>
										</table><!--end /table-->
									</div><!--end /tableresponsive-->
								</div><!--end card-body-->
							</div>
						</div><!--end col-->
					</div><!--end row-->

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<h4 class="header-title mt-0 mb-4"><?= __('お問合せ一覧') ?></h4>
									<div class="table-responsive">
										<table cellpadding="0" cellspacing="0" class="table table-striped table-hover mb-0"
										       style="min-width: 720px;">
											<thead class="thead-light">
											<tr>
												<th scope="col" style="width: 30%;"><?= $this->Paginator->sort('title', 'タイトル') ?></th>
												<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('created', '問い合わせ日') ?></th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($contacts as $contact): ?>
												<tr>
													<td class="align-middle"><?= h($contact->title) ?></td>
													<td class="align-middle"><?= h($contact->created) ?></td>
												</tr>
											<?php endforeach; ?>
											</tbody>
										</table><!--end /table-->
									</div><!--end /tableresponsive-->
								</div><!--end card-body-->
							</div><!--end card-->
						</div>
					</div>
				</div><!--end education detail-->

				<div class="tab-pane fade" id="post">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<h4 class="header-title mt-0 mb-4"><?= __('投稿一覧') ?></h4>
									<div class="table-responsive">
										<table cellpadding="0" cellspacing="0" class="table table-striped table-hover mb-0"
													 style="min-width: 720px;">
											<thead class="thead-light">
											<tr>
												<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('title', 'タイトル') ?></th>
												<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('category_id', 'カテゴリ') ?></th>
												<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('open_date', '公開日') ?></th>
												<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('created', '作成日') ?></th>
												<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('modified', '更新日') ?></th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($posts as $post): ?>
												<tr>
													<td class="align-middle"><a
															href="<?php echo $this->Url->build(['controller' => 'Posts',
																'action' => 'view',
																$post->id]); ?>"
															class="btn btn-info" style="display: block;"><?= h(StringUtil::getLimitedLengthStr($post->title, 15)) ?></a></td>
													<td class="align-middle">
														<?php CategoryUtil::getCategoryNameFromId($post->category_id) ?>
													</td>
													<td class="align-middle"><?= h($post->open_date) ?></td>
													<td class="align-middle"><?= h($post->created) ?></td>
													<td class="align-middle"><?= h($post->modified) ?></td>
												</tr>
											<?php endforeach; ?>
											</tbody>
										</table><!--end /table-->
									</div><!--end /tableresponsive-->
								</div><!--end card-body-->
							</div><!--end card-->
						</div><!--end col-->
					</div><!--end row-->
				</div><!--end education detail-->

				<div class="tab-pane fade" id="category">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<h4 class="header-title mt-0 mb-4"><?= __('カテゴリ一覧') ?></h4>
									<div class="table-responsive">
										<table cellpadding="0" cellspacing="0" class="table table-striped table-hover mb-0"
													 style="min-width: 720px;">
											<thead class="thead-light">
											<tr>
												<th scope="col" style="width: 30%;"><?= $this->Paginator->sort('category_name', 'カテゴリ名') ?></th>
												<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('created', '作成日') ?></th>
												<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('modified', '更新日') ?></th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($categories as $category): ?>
												<tr>
													<td class="align-middle"><?= h($category->category_name) ?></td>
													<td class="align-middle"><?= h($category->created) ?></td>
													<td class="align-middle"><?= h($category->modified) ?></td>
												</tr>
											<?php endforeach; ?>
											</tbody>
										</table><!--end /table-->
									</div><!--end /tableresponsive-->
								</div><!--end card-body-->
							</div><!--end card-->
						</div><!--end col-->
					</div><!--end row-->
				</div><!--end education detail-->

				<?php
				if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM || $this->request->session()
						->read('Auth.User.id') == $user->id):
					?>
					<div class="tab-pane fade" id="post_edit">
						<div class="row">
							<div class="col-lg-12 col-xl-9 mx-auto">
								<div class="card">
									<div class="card-body">
										<?= $this->Form->create($user, array('templates' => $form_template,
											'url' => [ 'controller' => 'users',
                                     'action' => 'edit', $user->id],
											'type' => 'file')); ?>
										<fieldset>
											<legend><?= __('画像関連') ?></legend>
											<p class="text-muted mb-3"><?= __('ユーザーに関する情報を入力してください。') ?></p>


											<div class="row">
												<div class="col-md-6">
													<?= $this->Form->control('icon_image_path', array('label' => array('text' => 'アイコン',
														'class' => 'col-form-label'),
														'type' => 'file',
														'id' => 'icon_image_path',
														'class' => 'form-control',
														'data-default-file' => $user->icon_image_path)); ?>
												</div>
												<div class="col-md-6">
													<?= $this->Form->control('default_featured_image_path',
														array('label' => array('text' => 'デフォルトアイキャッチ画像',
															'class' => 'col-form-label'),
															'type' => 'file',
															'id' => 'default_featured_image_path',
															'class' => 'form-control',
															'data-default-file' => $user->default_featured_image_path)); ?>
												</div>
											</div>
										</fieldset>
										<?= $this->Form->hidden('user_id', array('value' => $user->id, 'id' => 'view_user_id')); ?>
										<?= $this->Form->end() ?>
									</div>
								</div>
							</div> <!--end col-->
						</div><!--end row-->
					</div><!--end settings detail-->

					<div class="tab-pane fade" id="contact">
						<div class="row">
							<div class="col-lg-12 col-xl-9 mx-auto">
								<div class="card">
									<div class="card-body">
										<?= $this->Form->create(null, array('templates' => $form_template,
												'url' => [ 'controller' => 'users',
														'action' => 'contact'])); ?>
										<fieldset>
											<legend><?= __('お問合せ') ?></legend>
											<p class="text-muted mb-3"><?= __('お問合せやご要望、打ち合わせについてはこちらからお願いします。') ?></p>
											<div class="row">
												<div class="col-12">
													<?= $this->Form->control('title', array('label' => array('text' => '件名',
															'class' => 'col-form-label'),
															'type' => 'text',
															'id' => 'contact_title',
															'class' => 'form-control')); ?>
												</div>
												<div class="col-12">
													<?= $this->Form->control('body',
															array('label' => array('text' => '内容',
																	'class' => 'col-form-label'),
																	'type' => 'textarea',
																	'id' => 'body',
																	'class' => 'form-control')); ?>
												</div>
											</div>
										</fieldset>
										<?= $this->Form->hidden('user_id', array('value' => $user->id, 'id' => 'view_user_id')); ?>
										<button class="btn btn-primary mr-3" type="submit">
											<i class="fe-check-circle"></i>
											<span>送信する</span>
										</button>
										<?= $this->Form->end() ?>
									</div>
								</div>
							</div> <!--end col-->
						</div><!--end row-->
					</div><!--end settings detail-->


					<div class="tab-pane fade" id="payment">
						<div class="row">
						<div class="col-xl-6">

							<div class="card">
								<div class="card-body">
									<div class=" d-flex justify-content-between">
										<img src="/metrica_assets/images/widgets/wallet.png" alt="" height="75">
										<div class="align-self-center">
											<h2 class="mt-0 mb-2 font-weight-semibold"><i class="fas fa-yen-sign mr-2"></i>10,000
												<span	class="badge badge-soft-primary font-11">/ 月</span></h2>
											<h4 class="title-text mb-0 text-right">BusinessPlan</h4>
										</div>
									</div>
									<div class="bg-light p-3 mt-3 rounded">
										<div>
											<div class="table-responsive">
												<table class="table mb-0 table-centered">
													<thead>
													<tr>
														<th>提供サービス</th>
														<th>状態</th>
														<th>操作</th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td><img src="/metrica_assets/images/widgets/project1.jpg" alt="" class="rounded-circle thumb-sm mr-1">
															Micromin
														</td>
														<td>有効</td>
														<td>
															<div class="dropdown d-inline-block float-right">
																<a class="nav-link dropdown-toggle arrow-none" id="dLabel4" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
																	<i class="fas fa-ellipsis-v font-20 text-muted"></i>
																</a>
																<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel4" style="">
																	<a class="dropdown-item" href="#">Creat Project</a>
																	<a class="dropdown-item" href="#">Open Project</a>
																	<a class="dropdown-item" href="#">Tasks Details</a>
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td><img src="/metrica_assets/images/widgets/project2.jpg" alt="" class="rounded-circle thumb-sm mr-1">
															ZZ Diamond
														</td>
														<td>無効</td>
														<td>
															<div class="dropdown d-inline-block float-right">
																<a class="nav-link dropdown-toggle arrow-none" id="dLabel5" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
																	<i class="fas fa-ellipsis-v font-20 text-muted"></i>
																</a>
																<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel5">
																	<a class="dropdown-item" href="#">Creat Project</a>
																	<a class="dropdown-item" href="#">Open Project</a>
																	<a class="dropdown-item" href="#">Tasks Details</a>
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td><img src="/metrica_assets/images/widgets/project3.jpg" alt="" class="rounded-circle thumb-sm mr-1">
															Dairy Sweet
														</td>
														<td>有効</td>
														<td>
															<div class="dropdown d-inline-block float-right">
																<a class="nav-link dropdown-toggle arrow-none" id="dLabel6" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
																	<i class="fas fa-ellipsis-v font-20 text-muted"></i>
																</a>
																<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel6">
																	<a class="dropdown-item" href="#">Creat Project</a>
																	<a class="dropdown-item" href="#">Open Project</a>
																	<a class="dropdown-item" href="#">Tasks Details</a>
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td><img src="/metrica_assets/images/widgets/project4.jpg" alt="" class="rounded-circle thumb-sm mr-1">
															Corner Tea
														</td>
														<td>有効</td>
														<td>
															<div class="dropdown d-inline-block float-right">
																<a class="nav-link dropdown-toggle arrow-none" id="dLabel7" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
																	<i class="fas fa-ellipsis-v font-20 text-muted"></i>
																</a>
																<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel7">
																	<a class="dropdown-item" href="#">Creat Project</a>
																	<a class="dropdown-item" href="#">Open Project</a>
																	<a class="dropdown-item" href="#">Tasks Details</a>
																</div>
															</div>
														</td>
													</tr>
													</tbody>
												</table><!--end /table-->
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-12 text-right">
											<button type="button" class="btn btn-purple waves-effect waves-light"><i class="fas fa-clipboard-list mr-2"></i>プランを変更する</button>
										</div>
									</div>
								</div><!--end card-body-->
							</div><!--end card-->

						</div><!--end col-->

						<div class="col-lg-6">
							<div class="card dash-info-carousel">
								<div class="card-body">
									<div class=" d-flex justify-content-between">
										<img src="/metrica_assets/images/widgets/check.png" alt="" height="75">
										<div class="align-self-center">
											<h2 class="mt-0 mb-2 font-weight-semibold">クレジットカード</h2>
											<h4 class="title-text mb-0 text-right">お支払い情報</h4>
										</div>
									</div>
									<div class="bg-light p-3 mt-3 rounded">
										<div>
											<div class="table-responsive">
												<p>決済情報はセキュリティの観点から、決済サービス「stripe」で管理され、本システム「SPMS」上には保存されません。
													stripeでは、クレジットカード情報漏洩防止に関するセキュリティ水準として、世界で最も厳しいレベル「<a href="https://www.visa.com/splisting/searchGrsp.do?companyNameCriteria=stripe" target="_blank"><u>PCI Service Provider Level 1</u></a>」の認定を受けています。</p>
												<ul class="list-inline mb-0">
													<li class="list-inline-item">
														<i class="mdi mdi-circle-outline font-13 text-success mr-1"></i>
														stripeのプライバシーポリシーに関しては「<a href="https://stripe.com/jp/privacy" target="_blank"><u>こちら（日本語）</u></a>」をご参照ください。
													</li>
													<li class="list-inline-item">
														<i class="mdi mdi-circle-outline font-13 text-success mr-1"></i>
														stripeのセキュリティに関する取り組みに関しては「<a href="https://stripe.com/docs/security/stripe" target="_blank"><u>こちら（英語）</u></a>」をご参照ください。
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-12 text-right">
											<button type="button" class="btn btn-purple waves-effect waves-light"><i class="fas fa-money-check mr-2"></i>精算情報を変更する</button>
										</div>
									</div>
								</div>
							</div>
						</div><!--end col-->
					</div><!--end row-->
					</div><!--end settings detail-->
				<?php
				endif;
				?>
			</div><!--end tab-content-->

		</div><!--end col-->
	</div><!--end row-->

</div><!-- container -->
<?= $this->Html->script('metrica/users/view') ?>
