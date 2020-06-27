<?php
	/**
	 * @var \App\View\AppView              $this
	 * @var \App\Model\Entity\Category $category
	 */

use App\Utils\UserUtil;

?>
<div class="container-fluid">
	<!-- Page-Title -->
	<div class="row">
		<div class="col-sm-12">
			<div class="page-title-box">
				<div class="float-right">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Posts', 'action' => 'index']); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Categories', 'action' => 'index']); ?>">カテゴリ一覧</a></li>
						<li class="breadcrumb-item active">カテゴリ詳細</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('カテゴリ詳細') ?></h4>
			</div><!--end page-title-box-->
		</div><!--end col-->
	</div>

	<!-- end page title end breadcrumb -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<legend><?= __('基本情報') ?></legend>
					<p class="text-muted mb-3"><?= __('カテゴリに関する基本的な情報はこちらに記載されています。') ?></p>

					<table class="table mb-4">
						<tr>
							<th scope="row"><?= __('カテゴリ名') ?></th>
							<td><?= h($category->category_name) ?></td>
						</tr>
						<tr>
							<th scope="row"><?= __('登録ユーザー') ?></th>
							<td><?= h(UserUtil::getUserNameFromId($category->user_id)) ?></td>
						</tr>
						<tr>
							<th scope="row"><?= __('デフォルトアイキャッチ') ?></th>
							<td>
								<?= $this->Form->create($user, array('templates' => $form_template,
										'type' => 'file')); ?>
								<?= $this->Form->control('default_featured_image_path', array('label' => array('text' => 'デフォルトアイキャッチ',
										'class' => 'col-form-label'),
										'type' => 'file',
										'id' => 'default_featured_image_path',
										'class' => 'form-control',
										'data-default-file' => $category->default_featured_image_path)); ?>
								<?= $this->Form->hidden('category_id', array('value' => $category->id, 'id' => 'view_category_id')); ?>
								<?= $this->Form->end() ?>
							</td>
						</tr>
						<tr>
							<th scope="row"><?= __('作成日') ?></th>
							<td><?= h($category->created) ?></td>
						</tr>
						<tr>
							<th scope="row"><?= __('更新日') ?></th>
							<td><?= h($category->modified) ?></td>
						</tr>
					</table>
					<div class="row">
						<div class="col-12 text-center">
							<a href="<?= $this->Url->build(['controller' => 'Categories',
									'action' => 'edit',
									'?' => ['id' => $category->id]]); ?>"
							   class="btn btn-success mr-3">
								<i class="fe-edit"></i>
								<span>編集する</span>
							</a>
							<a href="<?= $this->Url->build(['controller' => 'Categories',
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
</div><!-- container -->
<?= $this->Html->script('metrica/categories/view') ?>
