<!DOCTYPE html>
<html lang="ja">
<head>
	<?= $this->Html->charset() ?>
	<title><?= $this->fetch('title') ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
	<meta content="Coderthemes" name="author"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<!-- App favicon -->
	<link rel="shortcut icon" href="/assets/images/favicon.ico">

	<!-- Sweet Alert-->
	<link href="/css/vendor/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

	<!-- Summernote css -->
	<link href="/css/vendor/summernote-bs4.css" rel="stylesheet" type="text/css"/>

	<!-- Notification css (Toastr) -->
	<link href="/css/vendor/toastr.min.css" rel="stylesheet" type="text/css"/>

	<!-- plugins css-->
	<link href="/css/vendor/switchery.min.css" rel="stylesheet" type="text/css">

	<!-- App css -->
	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/icons.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/app.css" rel="stylesheet" type="text/css"/>
	<link href="/css/styles.css" rel="stylesheet" type="text/css"/>
</head>

<body>

<!-- Begin page -->
<div id="wrapper">

	<?= $this->element('sidebar') ?>

	<div class="content-page">

		<div class="content">

			<?= $this->element('header') ?>
			<?= $this->Flash->render() ?>

			<?= $this->fetch('content') ?>

		</div> <!-- content -->

	</div>
</div>
<!-- END wrapper -->


<!-- App js -->
<script src="/js/search.js"></script>
<script src="/js/vendor.min.js"></script>
<script src="/js/app.min.js"></script>

<!-- Summernote js -->
<script src="/js/vendor/summernote-bs4.min.js"></script>

<!-- App js -->
<script src="/js/vendor/sweetalert2.min.js"></script>
<script src="/js/pages/sweet-alerts.init.js"></script>

<!-- Toaster js -->
<script src="/js/vendor/toastr.min.js"></script>
<script src="/js/pages/toastr.init.js"></script>

<script src="/js/vendor/switchery.min.js"></script>
<script src="/js/vendor/bootstrap-maxlength.min.js"></script>
<script src="/js/pages/form-advanced.init.js"></script>

<script>
	jQuery(document).ready(function () {
		$('#summernote').summernote({
			height: 300,
			width: $(window).width(),
			fontNames: ["YuGothic", "Yu Gothic", "Hiragino Kaku Gothic Pro", "Meiryo", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New", "Helvetica Neue", "Helvetica", "Impact", "Lucida Grande", "Tahoma", "Times New Roman", "Verdana"],
			lang: "ja-JP",
			toolbar: [
				['insert', ['picture', 'link']],
				['misc', ['undo', 'redo', 'fullscreen', 'codeview']],
				['fontsize', ['fontsize']],
				['color', ['color']]
			],
			callbacks: {
				onImageUpload: function (files, editor, welEditable) {

					for (var i = files.length - 1; i >= 0; i--) {
						sendFile(files[i], this);
					}
				}
			}
		});
	});

	function sendFile(file, el) {
		var form_data = new FormData();
		form_data.append('file', file);
		$.ajax({
			data: form_data,
			type: "POST",
			url: '/ajax/_save_images.php',
			cache: false,
			contentType: false,
			processData: false,
			success: function (url) {
				$(el).summernote('editor.insertImage', url);
			}
		});
	}

	/**
	 * Get the URL parameter value
	 *
	 * @param  name {string} パラメータのキー文字列
	 * @return  url {url} 対象のURL文字列（任意）
	 */
	function getParam(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
	}
</script>
</body>
</html>
