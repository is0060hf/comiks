<?php
	/**
	 * @var \App\View\AppView $this
	 * @var \App\Model\Entity\Post $post
	 */

	use Cake\ORM\TableRegistry;
	$categoryList = TableRegistry::get('Categories')->find('All')->where(['user_id' => $this->request->session()->read('Auth.User.id')]);
	if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
		$categoryList = TableRegistry::get('Categories')->find('All')->where(['user_id' => $post->user_id]);
	}
	$categoryNameList = [];

	foreach ($categoryList as $category) {
		$categoryNameList[$category->id] = $category->category_name;
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
						<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller' => 'Posts', 'action' => 'index']); ?>">投稿一覧</a></li>
						<li class="breadcrumb-item active">投稿編集ページ</li>
					</ol>
				</div>
				<h4 class="page-title"><?= __('投稿編集ページ') ?></h4>
			</div><!--end page-title-box-->
		</div><!--end col-->
	</div>

	<!-- end page title end breadcrumb -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					<?= $this->Form->create($post, array(
							'templates' => $form_template,
							'type' => 'file'
					)); ?>

					<fieldset>
						<legend><?= __('投稿編集ページ') ?></legend>
						<p class="text-muted mb-3"><?= __('編集する情報を入力してください。') ?></p>

						<?= $this->Flash->render() ?>

						<div class="row">
							<div class="col-sm-12">
								<?= $this->Form->control('title', array(
										'placeholder' => 'トピックスのタイトルを入力してください。',
										'label' => array('text' => 'タイトル',
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
								<?= $this->Form->control('title_sub1', array(
										'placeholder' => 'トピックスのサブタイトルを入力してください。',
										'label' => array('text' => 'サブタイトル1',
												'class' => 'col-form-label'
										),
										'type' => 'text',
										'templateVars' => array('div_class' => 'form-group'),
										'class' => 'form-control'
								)); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('title_sub2', array(
										'placeholder' => 'トピックスのサブタイトルを入力してください。',
										'label' => array('text' => 'サブタイトル2',
												'class' => 'col-form-label'
										),
										'type' => 'text',
										'templateVars' => array('div_class' => 'form-group'),
										'class' => 'form-control'
								)); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<?= $this->Form->control('context', array(
										'placeholder' => 'トピックスのタイトルを入力してください。',
										'label' => array(
												'text' => '本文',       // labelで出力するテキスト
												'class' => 'col-form-label' // labelタグのクラス名
										),
										'type' => 'textarea',
										'templateVars' => array(
												'div_class' => 'form-group'
										),
										'class' => 'form-control',
										'value' => $this->request->getData('context'),
										'required' => true,
										"id" => "summernote",
								)); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<?= $this->Form->control('category_id', array(
										'placeholder' => 'トピックスのカテゴリーを入力してください。',
										'label' => array(
												'text' => 'カテゴリー',       // labelで出力するテキスト
												'class' => 'col-form-label' // labelタグのクラス名
										),
										'type' => 'select',
										'options' => $categoryNameList,
										'templateVars' => array(
												'div_class' => 'form-group'
										),
										'value' => $this->request->getData('category_id'),
										'required' => true,
										'id' => 'category_id',
										'class' => 'form-control')); ?>
							</div>
							<div class="col-sm-6">
								<?= $this->Form->control('open_date', array(
										'placeholder' => 'トピックスの公開日を入力してください。',
										'label' => array(
												'text' => '公開日',
												'class' => 'col-form-label'),
										'type' => 'text',
										'templateVars' => array(
												'div_class' => 'form-group'
										),
										'id' => 'open_date',
										'class' => 'form-control this-is-date')); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<?= $this->Form->control('is_open', array(
										'label' => array(
												'text' => '下書き',       // labelで出力するテキスト
												'class' => 'col-form-label' // labelタグのクラス名
										),
										'type' => 'select',
										'options' => array(
												'下書き' => '下書き',
												'公開する' => '公開する'
										),
										'templateVars' => array(
												'div_class' => 'form-group'),
										'id' => 'is_open',
										'class' => 'form-control'      // inputタグのクラス名
								)); ?>
							</div>
						</div>

						<?php
							echo $this->Form->hidden('user_id', array('value' => $this->request->session()->read('Auth.User.id')));
							echo $this->Form->hidden('mode', array('value' => 'confirm'));
						?>
					</fieldset>
					<div class="row mt-4">
						<div class="col-12 text-center">
							<button class="btn btn-primary mr-3" type="submit">
								<i class="fe-check-circle"></i>
								<span>登録する</span>
							</button>
							<a href="<?= $this->Url->build(['controller' => 'Posts',
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

