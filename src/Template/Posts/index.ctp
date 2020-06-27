<?php
	/**
	 * @var \App\View\AppView $this
	 * @var \App\Model\Entity\Post[]|\Cake\Collection\CollectionInterface $posts
	 */

	use App\Utils\FormUtil;
	use App\Utils\StringUtil;

use Cake\ORM\TableRegistry;
	if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
		$categoryList = TableRegistry::get('Categories')->find('All');
	} else {
		$categoryList = TableRegistry::get('Categories')->find('All')->where(['user_id' => $this->request->session()->read('Auth.User.id')]);
	}
	$categoryNameList = [];
	$categoryNameList['-1'] = '未選択';

	foreach ($categoryList as $category) {
		$categoryNameList[$category->id] = $category->category_name;
	}

	$form_template = FormUtil::getFormTemplate();
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
						<li class="breadcrumb-item active">投稿一覧</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('投稿一覧') ?></h4>
			</div><!--end page-title-box-->
		</div><!--end col-->
	</div>

	<!-- end page title end breadcrumb -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="mt-0 header-title"><?= __('検索フォーム') ?></h4>
					<p class="text-muted mb-3"><?= __('絞り込みたい条件を入力してください。') ?></p>

					<?= $this->Flash->render() ?>

					<?= $this->Form->create(null, array('templates' => $form_template,
							'type' => 'get',
							'idPrefix' => 'search_form',
							'name' => 'search_form')); ?>

					<div class="row">
						<?php	if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM): ?>
							<div class="col-sm-6">
								<?= $this->Form->control('title', array('placeholder' => 'タイトルを部分一致で検索します。',
										'label' => array('text' => 'タイトル',
												'class' => 'col-form-label'),
										'type' => 'text',
										'templateVars' => array('div_class' => 'form-group',
												'span_icon' => '<span class="input-group-text"><i class="mdi mdi-format-title"></i></span>'),
										'id' => 'title',
										'value' => $this->request->getQuery('title'),
										'class' => 'form-control')); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('category_id', array(
										'label' => array('text' => 'カテゴリ',
												'class' => 'col-form-label'
										),
										'options' => $categoryNameList,
										'type' => 'select',
										'id' => 'category_id',
										'value' => $this->request->getQuery('category_id'),
										'templateVars' => array('div_class' => 'form-group'),
										'class' => 'form-control select2'
								)); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('under_open_date', array('placeholder' => '指定以降の公開日で絞り込みます。',
										'label' => array('text' => '公開日（から）',
												'class' => 'col-form-label'),
										'type' => 'text',
										'templateVars' => array('div_class' => 'form-group'),
										'id' => 'under_open_date',
										'value' => $this->request->getQuery('under_open_date'),
										'class' => 'form-control this-is-date')); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('upper_open_date', array('placeholder' => '指定以前の公開日で絞り込みます。',
										'label' => array('text' => '公開日（まで）',
												'class' => 'col-form-label'),
										'type' => 'text',
										'templateVars' => array('div_class' => 'form-group'),
										'id' => 'upper_open_date',
										'value' => $this->request->getQuery('upper_open_date'),
										'class' => 'form-control this-is-date')); ?>
							</div>
						<?php else: ?>
							<div class="col-12">
								<?= $this->Form->control('page_name', array('placeholder' => '入力値を部分一致で検索します。',
										'label' => array('text' => 'ページ名',
												'class' => 'col-form-label'),
										'type' => 'text',
										'templateVars' => array('div_class' => 'form-group',
												'span_icon' => '<span class="input-group-text"><i class="mdi mdi-format-title"></i></span>'),
										'id' => 'page_name',
										'value' => $this->request->getQuery('page_name'),
										'class' => 'form-control')); ?>
							</div>
						<?php endif; ?>
					</div>

					<div class="row my-2">
						<div class="col-12 text-center">
							<button class="btn btn-outline-dark mr-3" type="button" name="submit_btn" value="clear"
							        onclick="clearPostSearchElements();document.search_form.submit();">
								<i class="fe-edit"></i>
								<span>検索条件クリア</span>
							</button>
							<button class="btn btn-primary mr-3" type="submit" name="submit_btn" value="search">
								<i class="fe-edit"></i>
								<span>検索</span>
							</button>
						</div>
					</div>
					<?= $this->Form->end(); ?>
				</div><!--end card-body-->
			</div><!--end card-->
		</div>
	</div>


	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="mt-0 mb-3 header-title"><?= __('検索結果一覧') ?></h4>

					<div class="table-responsive">
						<table cellpadding="0" cellspacing="0" class="table table-striped table-hover mb-0"
						       style="min-width: 720px;">
							<thead class="thead-light">
							<tr>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('title', 'タイトル') ?></th>
								<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('category_id', 'カテゴリ') ?></th>
								<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('open_date', '公開日') ?></th>
								<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('user_id', '投稿者') ?></th>
								<th scope="col" class="actions" style="width: 20%;"><?= __('操作') ?></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($posts as $post):
								$authorData = TableRegistry::get('Users')->find()->where(['id' => $post->user_id])->first();
							?>
								<tr>
									<td class="align-middle">
										<a href="<?php echo $this->Url->build(['controller' => 'Posts',
												'action' => 'view',
												'?' => ['id' => $post->id]]); ?>"
										   class="" style="display: block;"><i
													class="fas fa-link text-info font-16 mr-2 ml-3"></i><?= h(StringUtil::getLimitedLengthStr($post->title, 12)) ?>
										</a>
									</td>
									<td class="align-middle">
										<?php
											if ($categoryNameList[$post->category_id]) {
												echo h($categoryNameList[$post->category_id]);
											}
										?>
									</td>
									<td class="align-middle"><?= h($post->open_date) ?></td>
									<td class="align-middle">
										<?php if (isset($authorData->icon_image_path)) { ?>
											<img src="<?= h($authorData->icon_image_path) ?>" alt="" class="rounded-circle thumb-sm mr-1">
										<?php } else { ?>
											<img src="/img/default_icon/antelope.svg" alt="" class="rounded-circle thumb-sm mr-1">
										<?php } ?>
										<?= h($authorData->login_name) ?>
									</td>
									<td class="align-middle actions">
										<?= $this->Html->link(__('<i class="fas fa-edit text-info font-16 mr-2"></i>'), ['action' => 'edit',
												'?' => ['id' => $post->id]], ['escape' => false]) ?>
										<?= $this->Form->postLink(__('<i class="fas fa-trash-alt text-danger font-16"></i>'), ['action' => 'delete',
												$post->id], ['escape' => false, 'confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $post->id)]) ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table><!--end /table-->
					</div><!--end /tableresponsive-->
					<div class="row mt-3">
						<div class="col-12 text-right">
							<a href="<?= $this->Url->build(['controller' => 'Posts',
									'action' => 'add']); ?>" class="btn btn-success mt-2">
								<i class="fe-git-pull-request"></i>
								<span>新規投稿する</span>
							</a>
						</div>
					</div>
				</div><!--end card-body-->
			</div><!--end card-->
		</div> <!-- end col -->
	</div><!--end row-->
	<?= $this->element('pagenate'); ?>

</div><!-- container -->