<!DOCTYPE html>
<html lang="ja">
<head>
	<?= $this->Html->charset() ?>
	<title><?= $this->fetch('title') ?></title>
	<?= $this->element('metrica_load_css') ?>

</head>
<body>
<?= $this->Flash->render() ?>
<?= $this->element('metrica_sidebar') ?>
<?= $this->element('metrica_header') ?>

<div class="page-wrapper">
	<div class="page-content-tab">
		<?= $this->fetch('content') ?>
		<?= $this->Flash->render() ?>
		<?= $this->element('metrica_modal') ?>
		<?= $this->element('metrica_footer') ?>
	</div>
</div>

<?= $this->element('metrica_load_script') ?>

<!-- 後から追加したスクリプト -->
<?= $this->fetch('script') ?>

</body>
</html>
