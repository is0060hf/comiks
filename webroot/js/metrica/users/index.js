window.onload = function(){
	//Parameter
	$('#sa-params').click(function () {

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '$success',
			cancelButtonColor: '$danger',
			confirmButtonText: 'Yes, delete it!'
		}).then(function(result) {
			if (result.value) {
				Swal.fire(
					'Deleted!',
					'Your file has been deleted.',
					'success'
				)
			}
		})
	});
};
