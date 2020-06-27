<?php
	/**
	 * @var \App\View\AppView $this
	 * @var \App\Model\Entity\PageName[]|\Cake\Collection\CollectionInterface $pageNames
	 */

use App\Utils\FormUtil;
use App\Utils\StringUtil;
use Cake\ORM\TableRegistry;

	$form_template = FormUtil::getFormTemplate();
	$userList = TableRegistry::get('Users')->find('All');
	$userNameList = [];
	$userNameList[0] = '未選択';
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
						<li class="breadcrumb-item"><a
								href="<?php echo $this->Url->build(['controller' => 'Posts',
									'action' => 'index']); ?>">Home</a></li>
						<li class="breadcrumb-item active">固定ページ一覧</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('固定ページ一覧') ?></h4>
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
							<div class="col-sm-6">
								<?= $this->Form->control('user_id', array(
									'label' => array('text' => 'ユーザー',
										'class' => 'col-form-label'
									),
									'options' => $userNameList,
									'type' => 'select',
									'id' => 'user_id',
									'value' => $this->request->getQuery('user_id'),
									'templateVars' => array('div_class' => 'form-group'),
									'class' => 'form-control select2'
								)); ?>
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
							<button class="btn btn-outline-dark mr-3" type="button" name="clear_btn" value="clear"
											onclick="clearSearchElementsInPageName();document.search_form.submit();">
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
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('page_name', 'ページ名') ?></th>
								<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('comment', 'コメント') ?></th>
								<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('user_id', '登録者') ?></th>
								<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('created', '作成日') ?></th>
								<th scope="col" style="width: 15%;"><?= $this->Paginator->sort('modified', '更新日') ?></th>
								<th scope="col" class="actions" style="width: 10%;"><?= __('操作') ?></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($pageNames as $pageName): ?>
								<tr>
									<td class="align-middle">
										<a href="<?php echo $this->Url->build(['controller' => 'PageNames',
											'action' => 'view',
											'?' => ['id' => $pageName->id]]); ?>"
											 class="" style="display: block;"><i
												class="fas fa-link text-info font-16 mr-2 ml-3"></i><?= h(StringUtil::getLimitedLengthStr($pageName->page_name, 12)) ?>
										</a></td>
									<td class="align-middle"><?= h(StringUtil::getLimitedLengthStr($pageName->comment)) ?></td>
									<td class="align-middle">
										<?php
										if ($pageName->user_id) {
											echo h($userNameList[$pageName->user_id]);
										}
										?>
									</td>
									<td class="align-middle"><?= h($pageName->created) ?></td>
									<td class="align-middle"><?= h($pageName->modified) ?></td>
									<td class="align-middle actions">
										<?= $this->Html->link(__('<i class="fas fa-edit text-info font-16 mr-2"></i>'), ['action' => 'edit',
											'?' => ['id' => $pageName->id]], ['escape' => false]) ?>
										<?= $this->Form->postLink(__('<i class="fas fa-trash-alt text-danger font-16"></i>'), ['action' => 'delete',
											$pageName->id], ['escape' => false, 'confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $pageName->id)]) ?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table><!--end /table-->
					</div><!--end /tableresponsive-->
					<div class="row mt-3">
						<div class="col-12 text-right">
							<a href="<?= $this->Url->build(['controller' => 'PageNames',
								'action' => 'add']); ?>" class="btn btn-success mt-2">
								<i class="fe-git-pull-request"></i>
								<span>新規登録する</span>
							</a>
						</div>
					</div>
				</div><!--end card-body-->
			</div><!--end card-->
		</div> <!-- end col -->
	</div><!--end row-->
	<?= $this->element('pagenate'); ?>

</div><!-- container -->
