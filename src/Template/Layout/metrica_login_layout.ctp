<!DOCTYPE html>
<html lang="ja">
<head>
	<?= $this->Html->charset() ?>
	<title><?= $this->fetch('title') ?></title>
	<?= $this->element('metrica_load_css') ?>

</head>
<body class="account-body accountbg">
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>

<?= $this->element('metrica_load_script') ?>
</body>
</html>
