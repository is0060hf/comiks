<?php
	/**
	 * @var \App\View\AppView $this
	 * @var \App\Model\Entity\CategoryName $categoryName
	 */
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
					href="<?php echo $this->Url->build(['controller' => 'Posts', 'action' => 'index']); ?>">Home</a>
		</li>
		<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'CategoryNames', 'action' => 'index']); ?>">カテゴリ一覧</a>
		</li>
		<li class="breadcrumb-item active">カテゴリ編集</li>
	</ol>
</div>
<div class="posts form large-9 medium-8 columns content">
	<?php
		$form_template = array(
				'error' => '<div class="col-sm-12 error-message alert alert-danger mt-1 mb-2 py-1">{{content}}</div>',
				'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
				'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10 d-flex align-items-center">{{input}}</div>',
				'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
				'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
				'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
				'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>'
		);
	?>
	<?= $this->Form->create($categoryName, array(
			'templates' => $form_template
	)); ?>
	<fieldset>
		<div class="text-center">
			<legend><?= __('カテゴリ編集') ?></legend>
		</div>
		<?php
			echo $this->Form->control('category_name', array(
					'label' => array(
							'text' => 'カテゴリ名',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => 'カテゴリ名はホームページ等に表示されます。'
					),
					'value' => $this->request->getData('category_name'),
					'required' => true,
					'id' => 'category_name',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('slug', array(
					'label' => array(
							'text' => 'スラッグ',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => 'URL等に使用される値です。'
					),
					'value' => $this->request->getData('slug'),
					'required' => true,
					'id' => 'slug',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('page_name_id', array(
					'label' => array(
							'text' => 'ページ',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'select',
					'options' => $pageNameList,
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '紐づくページを選択してください。'
					),
					'value' => $this->request->getData('page_name_id'),
					'id' => 'page_name_id',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('view_order', array(
					'label' => array(
							'text' => '表示順',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '表示順を調整するための値です。'
					),
					'value' => $this->request->getData('view_order'),
					'required' => true,
					'id' => 'view_order',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->control('comment', array(
					'label' => array(
							'text' => 'コメント',       // labelで出力するテキスト
							'class' => 'col-form-label' // labelタグのクラス名
					),
					'type' => 'text',
					'templateVars' => array(
							'div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => 'メモ用の項目です。'
					),
					'value' => $this->request->getData('comment'),
					'required' => true,
					'id' => 'comment',
					'class' => 'form-control'      // inputタグのクラス名
			));
			echo $this->Form->hidden('user_id', array('value' => $this->request->getData('user_id')));
			echo $this->Form->hidden('mode', array('value' => 'confirm'));
		?>
	</fieldset>
	<div class="row mt-4">
		<div class="col-12 text-center">
			<button class="btn btn-success mr-3" type="button" onclick="submit();">
				<i class="fe-check-circle"></i>
				<span>登録する</span>
			</button>
			<a href="<?= $this->Url->build(['controller' => 'CategoryNames', 'action' => 'index']); ?>" class="btn btn-primary">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>

