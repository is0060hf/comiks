window.onload = function(){
	/**
	 * Theme: Metrica - Responsive Bootstrap 4 Admin Dashboard
	 * Author: Mannatthemes
	 * Upload Js
	 */
	$(function () {
		// Translated
		const drStatus = {
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
		};
		const drIcon = $('#icon_image_path').dropify(drStatus);
		const drFeatured = $('#default_featured_image_path').dropify(drStatus);

		drIcon.on('dropify.beforeClear', function(event, element){
			event.stopPropagation();

			Swal.fire({
				title: '削除してもよろしいですか？',
				text: "一度削除すると元に戻せません。",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '$success',
				cancelButtonColor: '$danger',
				confirmButtonText: '削除する'
			}).then(function(result) {
				return result.value;
			})
		});
		drIcon.on('dropify.afterClear', function(event, element){
			const csrf = $('input[name=_csrfToken]').val();
			const form_data = new FormData();
			form_data.append('user_id', $('#view_user_id').val());

			$.ajax({
				data: form_data,
				type: 'POST',
				dataType: 'json',
				url: '/users/ajaxDeleteIconImagePath',
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function (xhr) {
					xhr.setRequestHeader('X-CSRF-Token', csrf);
					xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
					xhr.setRequestHeader("ContentType", "application/json; charset=utf-8");
				},
				complete: function (xhr, textStatus) {}
			}).done(function (data) {
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					onOpen: function(toast) {
						toast.addEventListener('mouseenter', Swal.stopTimer);
						toast.addEventListener('mouseleave', Swal.resumeTimer);
					}
				});

				if (data.status) {
					Toast.fire({
						icon: 'success',
						title: '正常に画像が設定されました。'
					});
				} else {
					Toast.fire({
						icon: 'error',
						title: '画像が設定できませんでした。'
					});
				}
			}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					onOpen: function(toast) {
						toast.addEventListener('mouseenter', Swal.stopTimer);
						toast.addEventListener('mouseleave', Swal.resumeTimer);
					}
				});

				Toast.fire({
					icon: 'error',
					title: '画像が設定できませんでした。'
				});
			});

			var Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				onOpen: function(toast) {
					toast.addEventListener('mouseenter', Swal.stopTimer);
					toast.addEventListener('mouseleave', Swal.resumeTimer);
				}
			});

			Toast.fire({
				icon: 'success',
				title: '正常に画像が削除されました。'
			});
		});

		drFeatured.on('dropify.beforeClear', function(event, element){
			event.stopPropagation();

			Swal.fire({
				title: '削除してもよろしいですか？',
				text: "一度削除すると元に戻せません。",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '$success',
				cancelButtonColor: '$danger',
				confirmButtonText: '削除する'
			}).then(function(result) {
				return result.value;
			})
		});
		drFeatured.on('dropify.afterClear', function(event, element){
			const csrf = $('input[name=_csrfToken]').val();
			const form_data = new FormData();
			form_data.append('user_id', $('#view_user_id').val());

			$.ajax({
				data: form_data,
				type: 'POST',
				dataType: 'json',
				url: '/users/ajaxDeleteFeaturedImagePath',
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function (xhr) {
					xhr.setRequestHeader('X-CSRF-Token', csrf);
					xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
					xhr.setRequestHeader("ContentType", "application/json; charset=utf-8");
				},
				complete: function (xhr, textStatus) {}
			}).done(function (data) {
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					onOpen: function(toast) {
						toast.addEventListener('mouseenter', Swal.stopTimer);
						toast.addEventListener('mouseleave', Swal.resumeTimer);
					}
				});

				if (data.status) {
					Toast.fire({
						icon: 'success',
						title: '正常に画像が設定されました。'
					});
				} else {
					Toast.fire({
						icon: 'error',
						title: '画像が設定できませんでした。'
					});
				}
			}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					onOpen: function(toast) {
						toast.addEventListener('mouseenter', Swal.stopTimer);
						toast.addEventListener('mouseleave', Swal.resumeTimer);
					}
				});

				Toast.fire({
					icon: 'error',
					title: '画像が設定できませんでした。'
				});
			});

			var Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				onOpen: function(toast) {
					toast.addEventListener('mouseenter', Swal.stopTimer);
					toast.addEventListener('mouseleave', Swal.resumeTimer);
				}
			});

			Toast.fire({
				icon: 'success',
				title: '正常に画像が削除されました。'
			});
		});
	});

	$(document).on('change', '#icon_image_path', function() {
		const csrf = $('input[name=_csrfToken]').val();
		const form_data = new FormData();
		form_data.append('file', this.files[0]);
		form_data.append('user_id', $('#view_user_id').val());

		$.ajax({
			data: form_data,
			type: 'POST',
			dataType: 'json',
			url: '/users/ajaxUpdateIconImagePath',
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-Token', csrf);
				xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
				xhr.setRequestHeader("ContentType", "application/json; charset=utf-8");
			},
			complete: function (xhr, textStatus) {}
		}).done(function (data) {
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				onOpen: function(toast) {
					toast.addEventListener('mouseenter', Swal.stopTimer);
					toast.addEventListener('mouseleave', Swal.resumeTimer);
				}
			});

			if (data.status) {
				Toast.fire({
					icon: 'success',
					title: '正常に画像が設定されました。'
				});
			} else {
				Toast.fire({
					icon: 'error',
					title: '画像が設定できませんでした。'
				});
			}
		}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				onOpen: function(toast) {
					toast.addEventListener('mouseenter', Swal.stopTimer);
					toast.addEventListener('mouseleave', Swal.resumeTimer);
				}
			});

			Toast.fire({
				icon: 'error',
				title: '画像が設定できませんでした。'
			});
		});
	});

	$(document).on('change', '#default_featured_image_path', function() {
		const csrf = $('input[name=_csrfToken]').val();
		const form_data = new FormData();
		form_data.append('file', this.files[0]);
		form_data.append('user_id', $('#view_user_id').val());

		$.ajax({
			data: form_data,
			type: 'POST',
			dataType: 'json',
			url: '/users/ajaxUpdateFeaturedImagePath',
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-CSRF-Token', csrf);
				xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
				xhr.setRequestHeader("ContentType", "application/json; charset=utf-8");
			},
			complete: function (xhr, textStatus) {}
		}).done(function (data) {
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				onOpen: function(toast) {
					toast.addEventListener('mouseenter', Swal.stopTimer);
					toast.addEventListener('mouseleave', Swal.resumeTimer);
				}
			});

			if (data.status) {
				Toast.fire({
					icon: 'success',
					title: '正常に画像が設定されました。'
				});
			} else {
				Toast.fire({
					icon: 'error',
					title: '画像が設定できませんでした。'
				});
			}
		}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				onOpen: function(toast) {
					toast.addEventListener('mouseenter', Swal.stopTimer);
					toast.addEventListener('mouseleave', Swal.resumeTimer);
				}
			});

			Toast.fire({
				icon: 'error',
				title: '画像が設定できませんでした。'
			});
		});
	});
};
