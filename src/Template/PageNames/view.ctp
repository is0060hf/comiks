<?php
	/**
	 * @var \App\View\AppView      $this
	 * @var \App\Model\Entity\PageName $pageName
	 */

use App\Utils\CategoryUtil;
use App\Utils\StringUtil;
use Cake\ORM\TableRegistry;
	$categoryNames = TableRegistry::get('CategoryNames')->find('All')->where(['page_name_id' => $pageName->id]);

	$userList = TableRegistry::get('Users')->find('All');
	$userNameList = [];
	foreach ($userList as $user) {
		$userNameList[$user->id] = $user->login_name;
	}
?>
<div class="container-fluid">
	<!-- Page-Title -->
	<div class="row">
		<div class="col-sm-12">
			<div class="page-title-box">
				<div class="float-right">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Posts', 'action' => 'index']); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'PageNames', 'action' => 'index']); ?>">固定ページ一覧</a></li>
						<li class="breadcrumb-item active">固定ページ詳細</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('固定ページ詳細') ?></h4>
			</div><!--end page-title-box-->
		</div><!--end col-->
	</div>

	<!-- end page title end breadcrumb -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<legend><?= __('基本情報') ?></legend>
					<p class="text-muted mb-3"><?= __('固定ページに関する基本的な情報はこちらに記載されています。') ?></p>

					<table class="table mb-4">
						<tr>
							<th scope="row"><?= __('ページ名') ?></th>
							<td><?= h($pageName->page_name) ?></td>
						</tr>
						<tr>
							<th scope="row"><?= __('スラッグ') ?></th>
							<td><?= h($pageName->slug) ?></td>
						</tr>
						<tr>
							<th scope="row"><?= __('コメント') ?></th>
							<td><?= h($pageName->comment) ?></td>
						</tr>
						<tr>
							<th scope="row"><?= __('ユーザー') ?></th>
							<td>
								<?php
								if ($pageName->user_id) {
									echo h($userNameList[$pageName->user_id]);
								}
								?>
							</td>
						</tr>
						<tr>
							<th scope="row"><?= __('作成日') ?></th>
							<td><?= h($pageName->created) ?></td>
						</tr>
						<tr>
							<th scope="row"><?= __('更新日') ?></th>
							<td><?= h($pageName->modified) ?></td>
						</tr>
					</table>
					<div class="row">
						<div class="col-12 text-center">
							<?php
							if ($this->request->session()->read('Auth.User.id') == $pageName->user_id) {
								?>
								<a href="<?= $this->Url->build(['controller' => 'PageNames',
									'action' => 'edit',
									'?' => ['id' => $pageName->id]]); ?>"
									 class="btn btn-success mr-3">
									<i class="fe-edit"></i>
									<span>編集する</span>
								</a>
								<?php
							}
							?>
							<a href="<?= $this->Url->build(['controller' => 'PageNames',
								'action' => 'index']); ?>" class="btn btn-info">
								<i class="fe-skip-back"></i>
								<span>一覧に戻る</span>
							</a>
						</div>
					</div>
				</div><!--end card-body-->
			</div><!--end card-->
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<legend><?= __('表示カテゴリ') ?></legend>
					<p class="text-muted mb-3"><?= __('固定ページに表示されるカテゴリの一覧です') ?></p>

					<div class="table-responsive">
						<table cellpadding="0" cellspacing="0" class="table table-hover mb-0" style="min-width: 1366px;">
							<thead>
							<tr>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('category_name', 'カテゴリ名') ?></th>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('comment', 'コメント') ?></th>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('created', '作成日') ?></th>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('modified', '更新日') ?></th>
								<th scope="col" class="actions" style="width: 20%;"><?= __('操作') ?></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($categoryNames as $categoryName): ?>
								<tr>
									<td class="align-middle"><a
											href="<?php echo $this->Url->build(['controller' => 'CategoryNames',
												'action' => 'view',
												$categoryName->id]); ?>"
											class="btn btn-info" style="display: block;"><?= h(StringUtil::getLimitedLengthStr(CategoryUtil::getCategoryNameFromId($categoryName->category_id), 12)) ?></a></td>
									<td class="align-middle"><?= h(StringUtil::getLimitedLengthStr($categoryName->comment)) ?></td>
									<td class="align-middle"><?= h($categoryName->created) ?></td>
									<td class="align-middle"><?= h($categoryName->modified) ?></td>
									<td class="align-middle actions">
										<?= $this->Html->link(__('編集'), ['controller' => 'CategoryNames', 'action' => 'edit',
											$categoryName->id]) ?>
										<?= $this->Form->postLink(__('削除'), ['controller' => 'CategoryNames', 'action' => 'deleteFromPageName',
											'id' => $categoryName->id, 'page_id' => $pageName->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $categoryName->category_name)]) ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>

					<div class="row mt-3">
						<div class="col-12 text-right">
							<a href="<?= $this->Url->build(['controller' => 'CategoryNames',
								'action' => 'add', 'page_id' => $pageName->id]); ?>" class="btn btn-success mt-2">
								<i class="fe-list"></i>
								<span>カテゴリを追加する</span>
							</a>
						</div>
					</div>
					<?= $this->element('pagenate'); ?>
				</div>
			</div>
		</div>
	</div>

</div><!-- container -->
