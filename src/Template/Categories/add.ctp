<?php
	/**
	 * @var \App\View\AppView      $this
	 * @var \App\Model\Entity\Category $category
	 */

	// 引数から初期ページを取得する
	use App\Utils\FormUtil;

	$user_id = $this->request->session()->read('Auth.User.id');
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
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Categories', 'action' => 'index']); ?>">カテゴリ一覧</a></li>
						<li class="breadcrumb-item active">新規カテゴリ登録</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('新規カテゴリ登録') ?></h4>
			</div><!--end page-title-box-->
		</div><!--end col-->
	</div>

	<!-- end page title end breadcrumb -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					<?= $this->Form->create($category, array('templates' => $form_template)); ?>
					<fieldset>
						<legend><?= __('新規カテゴリ登録') ?></legend>
						<p class="text-muted mb-3"><?= __('新規登録するカテゴリの情報を入力してください。') ?></p>

						<?= $this->Flash->render() ?>
						<div class="row">
							<div class="col-sm-6">
								<?= $this->Form->control('category_name', array(
										'placeholder' => 'カテゴリ名を入力してください',
										'label' => array('text' => 'カテゴリ名',
												'class' => 'col-form-label'
										),
										'type' => 'text',
										'templateVars' => array('div_class' => 'form-group'),
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
										'templateVars' => array('div_class' => 'form-group'),
										'class' => 'form-control'
								)); ?>
							</div>
						</div>

						<?php
							echo $this->Form->hidden('user_id', array('value' => $user_id));
							echo $this->Form->hidden('mode', array('value' => 'confirm'));
						?>
					</fieldset>
					<div class="row mt-4">
						<div class="col-12 text-center">
							<button class="btn btn-primary mr-3" type="submit">
								<i class="fe-check-circle"></i>
								<span>登録する</span>
							</button>
							<a href="<?= $this->Url->build(['controller' => 'Categories',
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

