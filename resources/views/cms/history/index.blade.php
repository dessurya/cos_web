@extends('cms.master')

@section('title')
  <title>CMS - Accounts History</title>
@endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('asset/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('asset/css/datatables_call.css') }}">
@endsection

@section('content')
	<section class="content-header">
		<h1>Accounts <small>History</small></h1>
	</section>

	<section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#List" data-toggle="tab">
					List
				</a></li>
			</ul>
			<div class="tab-content">
				<div class="active tab-pane" id="List">
					<div style="position: relative; width: 100%;">
						<div style="position: absolute; right: 0;">
							<div id="action" class="btn-group">
								<button type="button" class="btn btn-info"><i class="fa fa-wrench"></i> Tools</button>
								<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<span class="caret"></span>
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li id="DtTabFilter">Filter</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
							<thead>
								<tr role="row">
									@foreach($config['table'] as $list)
									<th>{{ $list['label'] }}</th>
									@endforeach
								</tr>
							</thead>
							<tfoot class="hide">
								<tr role="row">
									@foreach($config['table'] as $list)
									@if($list['search'] == 'true')
									<th class="search">{{ $list['label'] }}</th>
									@else
									<th></th>
									@endif
									@endforeach
								</tr>
							</tfoot>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('js')
	<script src="{{ asset('asset/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('asset/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('asset/js/datatables_call.js') }}"></script>

	<script type="text/javascript">
		var confDtTable = {};
		confDtTable['reBuild'] = false;
		confDtTable['ajaxUrl'] = "{{ $config['table_ajaxUrl'] }}";
		confDtTable['fieldSort'] = "{{ $config['table_fieldSort'] }}";
		confDtTable['ConfigColumns'] = [
			@foreach($config['table'] as $list)
			{name:"{!! $list['name'] !!}", data: "{!! $list['name'] !!}", searchable: {!! $list['search'] !!}, orderable: {!! $list['orderable'] !!} },
			@endforeach
		];
		confDtTable['dataPost'] = {};
		callDataTabless(confDtTable);
	</script>
@endsection      