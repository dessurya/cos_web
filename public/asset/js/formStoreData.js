function formCall(data) {
	$.ajax({
		url: data.url,
		type: 'post',
		dataType: 'json',
		data: data.input,
		processData:false,
		contentType:false,
		beforeSend: function (resp) {
			$('#loading-page').show();
		},
		error: function (resp) {
			$('#loading-page').hide();	
		},
		success: function (resp) {
			$('#loading-page').hide();
			$('.content-wrapper section.content .tab-content #Open').html(resp.view);
		}
	});
}