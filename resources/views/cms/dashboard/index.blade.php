@extends('cms.master')

@section('title')
  <title>CMS - Dashboard</title>
@endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('asset/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection

@section('content')
	<section class="content-header">
		<h1>Dashboard <small>your website trafic info</small></h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div style="float: right;">
					<div class="input-group text-right">
						<button type="button" class="btn btn-default pull-right" id="daterange-btn"> <span>Filter Date</span> <i class="fa fa-caret-down"></i>
						</button>
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
		<br>
		<div class="row">
			<div id="bounceRate" class="col-lg-6 col-xs-6">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3>- %</h3>
						<p>Bounce Rate</p>
					</div>
					<div class="icon">
						<i class="ion ion-arrow-graph-up-right"></i>
					</div>
				</div>
			</div>
			<div id="avgSessionDuration" class="col-lg-6 col-xs-6">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3>-</h3>
						<p>Avg. Session Duration</p>
					</div>
					<div class="icon">
						<i class="ion ion-ios-timer-outline"></i>
					</div>
				</div>
			</div>
			
			<div class="col-lg-4 col-xs-4">
				<div id="browser" class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Browser</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="chart canvasBrowser">
							<canvas id="canvasBrowser"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-xs-4">
				<div id="country" class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Country</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="chart canvasCountry">
							<canvas id="canvasCountry"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-xs-4">
				<div id="city" class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">City</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="chart canvasCity">
							<canvas id="canvasCity"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-12 col-xs-12">
				<div id="dailyVisitor" class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Daily Visitor</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="chart canvasDailyVisitor">
							<canvas id="canvasDailyVisitor"></canvas>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</section>
@endsection

@section('js')
	<script type="text/javascript" src="{{ asset('asset/vendors/Chart.js/dist/Chart.js') }}"></script>
	<script type="text/javascript" src="{{ asset('asset/adminlte/bower_components/moment/moment.js') }}"></script>
	<script type="text/javascript" src="{{ asset('asset/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
	<script type="text/javascript">
		$('#daterange-btn').daterangepicker({
				startDate: moment().subtract(29, 'days'),
				endDate  : moment(),
				minDate: '01/01/2019',
				showDropdowns: true,
				showWeekNumbers: true,
				timePicker: false,
				timePickerIncrement: 1,
				timePicker12Hour: true,
				ranges   : {
					'Today'       : [moment(), moment()],
					'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month'  : [moment().startOf('month'), moment().endOf('month')],
					'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				}
			},function (start, end) {
				$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
		    }
	    );

		$('#daterange-btn').on('apply.daterangepicker', function(ev, picker) {
			$('#daterange-btn, #daterange-btn span').css('background', '#26b99a').css('color', 'white');
			var sendD = {};
			sendD['pcndt'] = true;
			sendD['url'] = "{{ route('cms.dashboard.data') }}";
			sendD['input'] = {};
			sendD['input']['sDate'] = picker.startDate.format('Y/M/D');
			sendD['input']['eDate'] = picker.endDate.format('Y/M/D');
			excute(sendD);
		});

		$('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
			$('#daterange-btn, #daterange-btn span').css('background', '#fff').css('color', '#73880c');
			$('#daterange-btn span').html('Filter Date');
		});

		function dashboardReb(data) {
			$('#bounceRate h3').html('- %');
			if (data.bounceRate != null) { $('#bounceRate h3').html(Math.ceil(data.bounceRate)+' %'); }

			$('#avgSessionDuration h3').html('-');
			if (data.avgSessionDuration != null) { $('#avgSessionDuration h3').html(timeConvert(Math.ceil(data.avgSessionDuration))); }

			$('.chart.canvasBrowser').html('<canvas id="canvasBrowser"></canvas>');
			if (data.browser != null) { browserChart(data.browser); }

			$('.chart.canvasCountry').html('<canvas id="canvasCountry"></canvas>');
			if (data.country != null) { countryChart(data.country); }

			$('.chart.canvasCity').html('<canvas id="canvasCity"></canvas>');
			if (data.city != null) { cityChart(data.city); }

			$('.chart.canvasDailyVisitor').html('<canvas id="canvasDailyVisitor"></canvas>');
			if (data.dailyVisitor != null) { dailyVisitorChart(data.dailyVisitor); }
		}

		function browserChart(res) {
			var label = new Array();
			var value = new Array();

			res.forEach(function(data){
				label.push(data.label);
				value.push(data.value);
			});

			var ctx = document.getElementById("canvasBrowser").getContext('2d');
			var chartBrowser = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: label,
					datasets:[{
						label: 'Top Browser',
						data: value,
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		}

		function countryChart(res) {
			var label = new Array();
			var value = new Array();

			res.forEach(function(data){
				label.push(data.label);
				value.push(data.value);
			});

			var ctx = document.getElementById("canvasCountry").getContext('2d');
			var chartCountry = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: label,
					datasets:[{
						label: 'Country Visitors',
						data: value,
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		}

		function cityChart(res) {
			var label = new Array();
			var value = new Array();

			res.forEach(function(data){
				label.push(data.label);
				value.push(data.value);
			});

			var ctx = document.getElementById("canvasCity").getContext('2d');
			var chartCity = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: label,
					datasets:[{
						label: 'City Visitors',
						data: value,
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		}

		function dailyVisitorChart(res) {
			var label = new Array();
			var value = new Array();

			res.forEach(function(data){
				label.push(data.label);
				value.push(data.value);
			});

			var ctx = document.getElementById("canvasDailyVisitor").getContext('2d');
			var chartDailyVisitor = new Chart(ctx, {
				type: 'line',
				data: {
					labels: label,
					datasets:[{
						label: 'Daily Visitors',
						data: value,
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		}

		function timeConvert(time) {
			var sec_num = parseInt(time, 10); // don't forget the second param
			var hours   = Math.floor(sec_num / 3600);
			var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
			var seconds = sec_num - (hours * 3600) - (minutes * 60);

			if (hours   < 10) {hours   = "0"+hours;}
			if (minutes < 10) {minutes = "0"+minutes;}
			if (seconds < 10) {seconds = "0"+seconds;}
			return hours+':'+minutes+':'+seconds;
		}

	</script>
@endsection      