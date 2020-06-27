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
		<?= $this->element('metrica_modal') ?>
		<?= $this->element('metrica_footer') ?>
	</div>
</div>

<?= $this->element('metrica_load_script') ?>

<!-- 後から追加したスクリプト -->
<?= $this->fetch('script') ?>

<!-- Summernote js -->
<script src="/js/vendor/summernote-bs4.min.js"></script>
<script src="/js/vendor/summernote-image-attributes.js"></script>
<script src="/js/vendor/lang/summernote-ja-JP.js"></script>
<script>
	jQuery(document).ready(function () {
		$('#summernote').summernote({
			height: 300,
			width: $(window).width(),
			fontNames: ["YuGothic", "Yu Gothic", "Hiragino Kaku Gothic Pro", "Meiryo", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New", "Helvetica Neue", "Helvetica", "Impact", "Lucida Grande", "Tahoma", "Times New Roman", "Verdana"],
			lang: "ja-JP",
			popover: {
				image: [
					['custom', ['imageAttributes']],
					['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
					['float', ['floatLeft', 'floatRight', 'floatNone']],
					['remove', ['removeMedia']]
				],
			},
			imageAttributes:{
				icon:'<i class="note-icon-pencil"/>',
				removeEmpty:false, // true = remove attributes | false = leave empty if present
				disableUpload: true // true = don't display Upload Options | Display Upload Options
			},
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

		$('.this-is-date').each((index) => {
			$('.this-is-date').get(index).type = 'date';
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
</script>
</body>
</html>
