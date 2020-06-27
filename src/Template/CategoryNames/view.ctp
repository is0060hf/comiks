<?php
	/**
	 * @var \App\View\AppView              $this
	 * @var \App\Model\Entity\CategoryName $categoryName
	 */

use App\Utils\CategoryUtil;
use Cake\ORM\TableRegistry;

	$pageList = TableRegistry::get('PageNames')->find('All')->where(['user_id' => $this->request->session()->read('Auth.User.id')]);
	$pageNameList = [];
	foreach ($pageList as $page) {
		$pageNameList[$page->id] = $page->page_name;
	}
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Posts',
							'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'CategoryNames',
							'action' => 'index']); ?>">カテゴリ一覧</a></li>
		<li class="breadcrumb-item active">カテゴリ詳細</li>
	</ol>
</div>

<div class="users view large-9 medium-8 columns content">
	<div class="row user_info_div pt-4" data-rellax-speed="1">
		<div class="col-12">
			<legend>カテゴリ詳細</legend>
			<table class="table mb-4">
				<tr>
					<th scope="row"><?= __('カテゴリ名') ?></th>
					<td><?= h(CategoryUtil::getCategoryNameFromId($categoryName->category_id)) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('スラッグ') ?></th>
					<td><?= h($categoryName->slug) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('固定ページ') ?></th>
					<td>
						<?php
							if ($pageNameList[$categoryName->page_name_id]) {
								?>
								<a
										href="<?php echo $this->Url->build(['controller' => 'PageNames',
												'action' => 'view',
												$categoryName->page_name_id]); ?>"
										class="btn btn-info"><?= h($pageNameList[$categoryName->page_name_id]) ?></a>
								<?php
							}
						?>
					</td>
				</tr>
				<tr>
					<th scope="row"><?= __('コメント') ?></th>
					<td><?= h($categoryName->comment) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('作成日') ?></th>
					<td><?= h($categoryName->created) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('更新日') ?></th>
					<td><?= h($categoryName->modified) ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-12 text-center">
			<?php
				if ($this->request->session()->read('Auth.User.id') == $categoryName->user_id) {
					?>
					<a href="<?= $this->Url->build(['controller' => 'CategoryNames',
							'action' => 'edit',
							$categoryName->id]); ?>"
					   class="btn btn-success mr-3">
						<i class="fe-edit"></i>
						<span>編集する</span>
					</a>
					<?php
				}
				if ($pageNameList[$categoryName->page_name_id]) {
					?>
					<a
						href="<?php echo $this->Url->build(['controller' => 'PageNames',
							'action' => 'view',
							$categoryName->page_name_id]); ?>"
						class="btn btn-info"><?= h($pageNameList[$categoryName->page_name_id]) ?>へ戻る</a>
					<?php
				}
			?>
		</div>
	</div>
</div>
