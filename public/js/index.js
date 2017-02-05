$(document).ready(function() {
	$('#tasksList').DataTable({
		'order': []
	});

	$('#newTask').submit(function(event) {
		event.preventDefault();
		checkRequiredFields();
		$(this)[0].submit();
	});

	$('#preview').click(function(event) {
		switchPreview();
	});

	$('#closeOverlay').click(function(event) {
		switchPreview();
	});

	$('#imageInput').change(function() {
		showUploadedImage();
	});
});


checkRequiredFields = function() {
	var formElement = '#newTask',
		formUsername = '#username',
		formEmail 	= '#email',
		formTask 	= '#exercise',
		formImage	= '#imgUpload',
		requiredAttr = 'isRequired',
		errorClass	= 'has-error',
		fieldGroup	= '#group-';

	$("form" + formElement +" :input").each(function() {
		if($(this).attr(requiredAttr) && $(this).val().length == 0) {
			elemId = $(this).attr('id');
			$(fieldGroup + elemId).addClass(errorClass);

			return false;
		} 
	});
}


showUploadedImage = function() {
	var preview = '#imageUploaded',
		fileSource = '#imageInput',
		reader = new FileReader();

	file = $(fileSource).prop('files')[0];
	reader.addEventListener('load', function () {
		$(preview).attr('src', reader.result);
	}, false);

	if (file) {
		reader.readAsDataURL(file);
	}
}


switchPreview = function() {
	var overlayElem = '#previewOverlay';

	if($(overlayElem).css('width') == '0px') {
		$(overlayElem).css('width', '100%').css('height', '100%').append('<h1>bububu</h1>');
	} else {
		$(overlayElem).css('width', '0%').css('height', '0%');
	}
}
