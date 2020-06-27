<?php
	/**
	 * @var \App\View\AppView $this
	 * @var \App\Model\Entity\CategoryName[]|\Cake\Collection\CollectionInterface $categoryNames
	 */

use App\Utils\CategoryUtil;
use Cake\ORM\TableRegistry;
	$pageList = TableRegistry::get('PageNames')->find('All');
	$pageNameList = [];
	foreach ($pageList as $page) {
		$pageNameList[$page->id] = $page->page_name;
	}

	$userList = TableRegistry::get('Users')->find('All');
	$userNameList = [];
	foreach ($userList as $user) {
		$userNameList[$user->id] = $user->login_name;
	}
?>
<div class="row">
	<div class="col-6 breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a
						href="<?php echo $this->Url->build(['controller' => 'Posts',
								'action' => 'index']); ?>">Home</a></li>
			<li class="breadcrumb-item active">カテゴリ一覧</li>
		</ol>
	</div>
</div>

<div class="users index large-9 medium-8 columns content">
	<legend><?= __('カテゴリ一覧') ?></legend>
	
	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('category_name', 'カテゴリ名') ?></th>
			<th scope="col"><?= $this->Paginator->sort('page_name_id', '固定ページ') ?></th>
			<th scope="col"><?= $this->Paginator->sort('comment', 'コメント') ?></th>
			<th scope="col"><?= $this->Paginator->sort('user_id', '登録者') ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', '作成日') ?></th>
			<th scope="col"><?= $this->Paginator->sort('modified', '更新日') ?></th>
			<th scope="col" class="actions"><?= __('操作') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($categoryNames as $categoryName): ?>
			<tr>
				<td class="align-middle"><a
							href="<?php echo $this->Url->build(['controller' => 'CategoryNames',
									'action' => 'view',
									$categoryName->id]); ?>"
							class="btn btn-info"><?= h(CategoryUtil::getCategoryNameFromId($categoryName->category_id)) ?></a></td>
				<td class="align-middle">
					<?php
						if ($pageNameList[$categoryName->page_name_id]) {
							echo h($pageNameList[$categoryName->page_name_id]);
						}
					?>
				</td>
				<td class="align-middle"><?= h($categoryName->comment) ?></td>
				<td class="align-middle">
					<?php
						if ($categoryName->user_id) {
							echo h($userNameList[$categoryName->user_id]);
						}
					?>
				</td>
				<td class="align-middle"><?= h($categoryName->created) ?></td>
				<td class="align-middle"><?= h($categoryName->modified) ?></td>
				<td class="align-middle actions">
					<?= $this->Html->link(__('編集'), ['action' => 'edit',
							$categoryName->id]) ?>
					<?= $this->Form->postLink(__('削除'), ['action' => 'delete',
							$categoryName->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $categoryName->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?= $this->element('pagenate'); ?>
</div>
