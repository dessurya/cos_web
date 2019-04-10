$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function() {
  $('#loading-page').hide();
});

$(document).on('click', 'a#signout', function() {
	var data = {};
	data['url'] = $(this).attr('href');
	data['input'] = null;
	excute(data);
	return false;
})

function excute(data) {
	if (data.pcndt == true) {
		$.ajax({
			url: data.url,
			type: 'post',
			dataType: 'json',
			data: data.input,
			beforeSend: function (resp) {
				$('#loading-page').show();
			},
			error: function (resp) {
				$('#loading-page').hide();	
			},
			success: function (resp) {
				excuteResponse(resp);
				$('#loading-page').hide();
			}
		});	
	}else{
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
				excuteResponse(resp);
				$('#loading-page').hide();
			}
		});
	}
}

function excuteResponse(data) {
	if (data.msg !== '' && data.msg !== null && data.msg !== undefined) {
		var pndata = {};
		pndata['title'] = 'Info';
		pndata['type'] = 'success';
		pndata['text'] = data.msg;
		pnotify(pndata);
	}
	if (data.type == 'signout') {
		window.location.replace(data.url);
	}else if(data.type == 'form'){
		$('.content-wrapper section.content .tab-content #Open').html(data.result.view);
		$('.content-wrapper section.content .nav-tabs a[href="#Open"] small').html(data.result.title);
	}else if(data.type == 'store'){
		if (data.response == false) {
			$.each(data.result.error, function(key, value) {
				var inf = {};
				inf['title'] = key;
				inf['type'] = 'error';
				inf['text'] = value;
				pnotify(inf);
			});
		}else if (data.response == true) {
			if (data.result.newform == true) {
				$('.content-wrapper section.content .tab-content #Open').html(data.result.form.view);
				$('.content-wrapper section.content .nav-tabs a[href="#Open"] small').html(data.result.form.title);
			}
		}
	}else if(data.type == 'profile_store') {
		if (data.response == true) { location.reload(); }
		else if (data.response == false){
			$.each(data.error, function(key, value) {
				var inf = {};
				inf['title'] = key;
				inf['type'] = 'error';
				inf['text'] = value;
				pnotify(inf);
			});
		}
	}else if(data.type == 'dashboard_data'){
		dashboardReb(data);
	}

	if (data.refresh_tab == true) { datatable.ajax.reload(); }
}

function pnotify(data) {
	new PNotify({
	    title: data.title,
	    text: data.text,
	    type: data.type,
	    delay: 3000
	});
}

function pnotifyConfirm(data) {
	new PNotify({
        after_open: function(ui){
        	$(".true", ui.container).focus();
			$('#loading-page').show();
        },
        after_close: function(){
        	$('#loading-page').hide();
        },
	    title: data.title,
	    text: data.text,
	    type: data.type,
	    delay: 3000,
	    confirm: {
            confirm: true,
            buttons:[
            	{ text: 'Yes', addClass: 'true btn-primary', removeClass: 'btn-default'},
            	{ text: 'No', addClass: 'false'}
            ]
        }
	}).get().on('pnotify.confirm', function(){
        excute(data.exe);
    });
}