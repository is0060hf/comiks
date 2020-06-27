<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

use App\Utils\FormUtil;
use App\Utils\StringUtil;
use Cake\ORM\TableRegistry;

$form_template = FormUtil::getFormTemplate();
$userList = TableRegistry::get('Users')->find()->all();
$usersNameList = [];
$usersNameList[''] = '未選択';
foreach ($userList as $usr) {
	if ($usr->username != '') {
		$usersNameList[$usr->username] = $usr->username;
	}
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
						<li class="breadcrumb-item active">会員情報一覧</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('会員情報一覧') ?></h4>
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
						<div class="col-sm-6">
							<?= $this->Form->control('mail_address', array('placeholder' => '入力値を部分一致で検索します。',
								'label' => array('text' => 'メールアドレス',
									'class' => 'col-form-label'),
								'type' => 'text',
								'templateVars' => array('div_class' => 'form-group',
									'span_icon' => '<span class="input-group-text"><i class="far fa-envelope"></i></span>'),
								'id' => 'mail_address',
								'value' => $this->request->getQuery('mail_address'),
								'class' => 'form-control')); ?>
						</div>
						<div class="col-sm-6">
							<?= $this->Form->control('login_name', array('placeholder' => '入力値を部分一致で検索します。',
								'label' => array('text' => 'ユーザー名',
									'class' => 'col-form-label'),
								'type' => 'text',
								'templateVars' => array('div_class' => 'form-group',
									'span_icon' => '<span class="input-group-text"><i class="far fa-user"></i></span>'),
								'id' => 'login_name',
								'value' => $this->request->getQuery('login_name'),
								'class' => 'form-control')); ?>
						</div>
					</div>

					<div class="row my-2">
						<div class="col-12 text-center">
							<button class="btn btn-outline-dark mr-3" type="button" name="clear_btn" value="clear"
											onclick="clearSearchElementsInUser();document.search_form.submit();">
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
								<th scope="col" style="width: 30%;"><?= $this->Paginator->sort('login_name', 'ログイン名') ?></th>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('mail_address', 'メールアドレス') ?></th>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('created', '作成日') ?></th>
								<th scope="col" style="width: 20%;"><?= $this->Paginator->sort('modified', '更新日') ?></th>
								<th scope="col" class="actions" style="width: 10%;"><?= __('操作') ?></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($users as $user): ?>
								<tr>
									<td class="align-middle">
										<a href="<?php echo $this->Url->build(['controller' => 'Users',
											'action' => 'view',
											'?' => ['id' => $user->login_cd]]); ?>"
											 class="" style="display: block;">
											<?php if (isset($user->icon_image_path)) { ?>
												<img src="<?= h($user->icon_image_path) ?>" alt="" class="rounded-circle thumb-sm mr-1">
											<?php } else { ?>
												<img src="/img/default_icon/antelope.svg" alt="" class="rounded-circle thumb-sm mr-1">
											<?php } ?>

											<i
												class="fas fa-link text-info font-16 mr-2 ml-3"></i><?= h(StringUtil::getLimitedLengthStr($user->login_name,
												12)) ?>
										</a>
									</td>
									<td class="align-middle"><?= h($user->mail_address) ?></td>
									<td class="align-middle"><?= h($user->created) ?></td>
									<td class="align-middle"><?= h($user->modified) ?></td>
									<td class="align-middle actions">
										<?php
										if ($this->request->session()
												->read('Auth.User.user_role') == ROLE_SYSTEM || $this->request->session()
												->read('Auth.User.id') == $user->id) :
											?>
											<?= $this->Html->link(__('<i class="fas fa-edit text-info font-16 mr-2"></i>'),
											['action' => 'edit',
												'?' => ['id' => $user->login_cd]], ['escape' => false]) ?>
										<?php
										endif;
										?>
										<?php
										if ($this->request->session()
												->read('Auth.User.user_role') == ROLE_SYSTEM ) :
											?>
											<?= $this->Form->postLink(__('<i class="fas fa-trash-alt text-danger font-16"></i>'),
											['action' => 'delete',
												$user->id], ['escape' => false,
												'confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $user->id)]) ?>
										<?php
										endif;
										?>
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
