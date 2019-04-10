var datatable;
$(document).on('click', 'table#table-data tbody tr', function(){
	$(this).toggleClass('selected');
});
$(document).on('click', '#action #DtTabFilter', function() {
	$('table#table-data tfoot').toggleClass('hide');
});
$(document).on('click', '#action #dtSelectedAll', function(){
	$('table#table-data tbody tr').addClass('selected');
});
$(document).on('click', '#action #dtUnselectedAll', function(){
	$('table#table-data tbody tr').removeClass('selected');
});

$(document).on('click', '#action .tools', function(){
	var action = $(this).data('action');
	var conf = $(this).data('conf');
	var val = $(this).data('val');
	var sel = $(this).data('sel');
	var id = getDataId(sel);
	if(id == false){ return false; }
	var data = {};
	if(conf == true){
		data['title'] = 'Warning';
		data['type'] = 'info';
		data['text'] = 'Are You Sure Do '+action+' On Selected Data?';
		data['exe'] = {};
		data['exe']['url'] = tools_ajaxUrl;
		data['exe']['pcndt'] = true;
		data['exe']['input'] = {};
		data['exe']['input']['id'] = id;
		data['exe']['input']['val'] = val;
		data['exe']['input']['action'] = action;
		pnotifyConfirm(data);
	}else if(conf == false){
		data['url'] = tools_ajaxUrl;
		data['pcndt'] = true;
		data['input'] = {};
		data['input']['id'] = id;
		data['input']['val'] = val;
		data['input']['action'] = action;
		excute(data);
	}
	if(action == 'form'){ $('.content-wrapper section.content .nav-tabs a[href="#Open"]').tab('show'); }
	return false;
});

$(document).on('submit', 'form#storeData', function(){
	var url   = $(this).attr('action');
	var input  = new FormData($(this)[0]);
	var data = {};
	data['title'] = 'Warning';
	data['type'] = 'info';
	data['text'] = 'Are You Sure Do This?';
	data['exe'] = {};
	data['exe']['url'] = url;
	data['exe']['input'] = input;
	pnotifyConfirm(data);
	return false;
});

$(document).on('change', 'table#table-data tfoot input.search', function (keypress){
	confDtTable['reBuild'] = true;
	var post = {};
	$('table#table-data tfoot input.search').each(function(){
		if($(this).val() !== '' && $(this).val() !== null && $(this).val() !== undefined){
			post[$(this).attr('name')] = $(this).val();
		}
	});
	confDtTable['dataPost']['post'] = post;
	callDataTabless(confDtTable);
});

function callDataTabless(setConf) {

	if(setConf.reBuild == true){
		datatable.destroy();
	}

	$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
		return {
			"iStart": oSettings._iDisplayStart,
			"iEnd": oSettings.fnDisplayEnd(),
			"iLength": oSettings._iDisplayLength,
			"iTotal": oSettings.fnRecordsTotal(),
			"iFilteredTotal": oSettings.fnRecordsDisplay(),
			"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
			"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
		};
	};

	datatable = $('#table-data').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: setConf.ajaxUrl,
			type: "POST",
			data: setConf.dataPost
		},
		aaSorting: [ [setConf.fieldSort,'desc'] ],
		columns: setConf.ConfigColumns,
		rowCallback: function(row, data, iDisplayIndex) {
			var info = this.fnPagingInfo();
			var page = info.iPage;
			var length = info.iLength;
			var index = page * length + (iDisplayIndex + 1);
			$('td:eq(0)', row).html(index);
			$(row).attr('id', data.id);
		}
	});
}

function getDataId(data){
	if(data == false){ return true; }
	var idData = "";
	$('table#table-data tbody tr.selected').each(function(){
		idData += $(this).attr('id')+'^';
	});
	var getLength = idData.length-1;
	idData = idData.substr(0, getLength);
	if(idData === null || idData === '' || idData === undefined){
		var pndata = {};
		pndata['title'] = 'Info';
		pndata['type'] = 'error';
		pndata['text'] = 'No Data Selected!';
		pnotify(pndata);
		return false;
	}
	return idData;
}