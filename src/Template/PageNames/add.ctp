<?php
	/**
	 * @var \App\View\AppView      $this
	 * @var \App\Model\Entity\PageName $pageName
	 */

	use Cake\ORM\TableRegistry;
	use App\Utils\FormUtil;
	$userList = TableRegistry::get('Users')->find('All');
	$userNameList = [];
	foreach ($userList as $user) {
		$userNameList[$user->id] = $user->login_name;
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
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Posts', 'action' => 'index']); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'PageNames', 'action' => 'index']); ?>">固定ページ一覧</a></li>
						<li class="breadcrumb-item active">新規固定ページ</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('新規固定ページ') ?></h4>
			</div><!--end page-title-box-->
		</div><!--end col-->
	</div>

	<!-- end page title end breadcrumb -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					<?= $this->Form->create($pageName, array('templates' => $form_template)); ?>
					<fieldset>
						<legend><?= __('新規固定ページ') ?></legend>
						<p class="text-muted mb-3"><?= __('新規登録する固定ページの情報を入力してください。') ?></p>

						<?= $this->Flash->render() ?>

						<div class="row">
							<div class="col-sm-6">
								<?= $this->Form->control('page_name', array(
									'placeholder' => 'ページ名はホームページ等に表示されます',
									'label' => array('text' => 'ページ名',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group'),
									'class' => 'form-control'
								)); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('slug', array(
									'placeholder' => 'URL等に使用される値です',
									'label' => array('text' => 'スラッグ',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group'),
									'class' => 'form-control'
								)); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<?= $this->Form->control('comment', array(
									'placeholder' => 'メモ用の項目です',
									'label' => array('text' => 'コメント',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="fas fa-sticky-note"></i></span>'),
									'class' => 'form-control'
								)); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('view_order', array(
									'placeholder' => '表示順を調整するための値です',
									'label' => array('text' => '表示順',
										'class' => 'col-form-label'
									),
									'type' => 'text',
									'templateVars' => array('div_class' => 'form-group',
										'span_icon' => '<span class="input-group-text"><i class="fas fa-sort-amount-down"></i></span>'),
									'class' => 'form-control'
								)); ?>
							</div>
						</div>
						<?php
							echo $this->Form->hidden('user_id', array('user_id' => $this->request->getData('user_id')));
							echo $this->Form->hidden('mode', array('value' => 'confirm'));
						?>
					</fieldset>
					<div class="row mt-4">
						<div class="col-12 text-center">
							<button class="btn btn-primary mr-3" type="submit">
								<i class="fe-check-circle"></i>
								<span>登録する</span>
							</button>
							<a href="<?= $this->Url->build(['controller' => 'PageNames',
								'action' => 'index']); ?>" class="btn btn-info">
								<i class="fe-skip-back"></i>
								<span>一覧に戻る</span>
							</a>
						</div>
					</div>
					<?= $this->Form->end() ?>
				</div><!--end card-body-->
			</div><!--end card-->
		</div>
	</div>
</div><!-- container -->
