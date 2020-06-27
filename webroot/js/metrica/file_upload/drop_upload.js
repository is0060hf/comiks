window.onload = function(){
	/**
	 * Theme: Metrica - Responsive Bootstrap 4 Admin Dashboard
	 * Author: Mannatthemes
	 * Upload Js
	 */
	$(function () {
		// Translated
		const dr = $('.dropify-jp').dropify({
			messages: {
				default: 'ここにファイルをドラッグ&ドロップするかクリックしてください。',
				replace: 'ここにファイルをドラッグ&ドロップするかクリックしてください。',
				remove:  '削除',
				error:   'エラーが発生しました。'
			},
			error: {
				'fileSize': 'ファイルサイズが大きすぎます ({{ value }} max)',
				'minWidth': '画像幅が小さすぎます ({{ value }}}px min)',
				'maxWidth': '画像幅が大きすぎます ({{ value }}}px max)',
				'minHeight': '画像高が小さすぎます ({{ value }}}px min)',
				'maxHeight': '画像高が大きすぎます ({{ value }}px max)',
				'imageFormat': 'アップロードできる画像フォーマットは ({{ value }}) のみです'
			}
		});

		dr.on('dropify.beforeClear', function(event, element){
			return confirm("既存の\"" + element.file.name + "\"は削除してよろしいですか?");
		});

		dr.on('dropify.afterClear', function(event, element){
			alert('ファイルを削除しました。');
		});
		dr.on('dropify.errors', function(event, element){
			alert('エラーが発生しました。');
		});
	});
};
