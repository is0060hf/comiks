<?php
	/**
	 * @var \App\View\AppView $this
	 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
	 */

use App\Utils\StringUtil;
use App\Utils\UserUtil;

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
						<li class="breadcrumb-item active">カテゴリ一覧</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('カテゴリ一覧') ?></h4>
			</div><!--end page-title-box-->
		</div><!--end col-->
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					<h4 class="mt-0 mb-3 header-title"><?= __('検索結果一覧') ?></h4>
					<?= $this->Flash->render() ?>

					<div class="table-responsive">
						<table cellpadding="0" cellspacing="0" class="table table-striped table-hover mb-0"
						       style="min-width: 720px;">
							<thead class="thead-light">
							<tr>
								<th scope="col" style="width: 30%;"><?= $this->Paginator->sort('login_name', 'カテゴリ名') ?></th>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('mail_address', '登録者') ?></th>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('created', '作成日') ?></th>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('modified', '更新日') ?></th>
								<th scope="col" class="actions" style="width: 10%;"><?= __('操作') ?></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($categories as $category): ?>
								<tr>
									<td class="align-middle">
										<a href="<?php echo $this->Url->build(['controller' => 'Categories',
												'action' => 'view', '?' => ['id' => $category->id]]); ?>"
										   class="" style="display: block;">
											<i class="fas fa-link text-info font-16 mr-2 ml-3"></i>
											<?= h(StringUtil::getLimitedLengthStr($category->category_name, 12)) ?>
										</a>
									</td>
									<td class="align-middle"><?= h(UserUtil::getUserNameFromId($category->user_id)) ?></td>
									<td class="align-middle"><?= h($category->created) ?></td>
									<td class="align-middle"><?= h($category->modified) ?></td>
									<td class="align-middle actions">
										<?= $this->Html->link(__('<i class="fas fa-edit text-info font-16 mr-2"></i>'),
												['action' => 'edit', '?' => ['id' => $category->id]], ['escape' => false]) ?>
										<?= $this->Form->postLink(__('<i class="fas fa-trash-alt text-danger font-16"></i>'),
												['action' => 'delete',	$category->id], ['escape' => false,
														'confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $category->id)]) ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table><!--end /table-->
					</div><!--end /tableresponsive-->
				</div><!--end card-body-->
			</div><!--end card-->
		</div> <!-- end col -->
	</div><!--end row-->
	<?= $this->element('pagenate'); ?>

</div><!-- container -->