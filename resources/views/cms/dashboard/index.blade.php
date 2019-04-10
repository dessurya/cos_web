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
			<div class="col-lg-6 col-xs-6">
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
			<div class="col-lg-6 col-xs-6">
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
						<div class="chart">
							<div id="canvasBrowser"></div>
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
						<div class="chart">
							<div id="canvasCountry"></div>
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
						<div class="chart">
							<div id="canvasCity"></div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</section>
@endsection

@section('js')
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<!-- <script type="text/javascript" src="{{ asset('asset/vendors/Chart.js/dist/Chart.js') }}"></script> -->
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

		// var dataBrowserChart;

		function dashboardReb(data) {
			// console.log(data);
			browserChart(data.browser);
		}

		// function browserChart(config) {
		// 	console.log(config);

		// 	$('#canvasBrowser').replaceWith('<canvas id="canvasBrowser"></canvas>');
		// 	var canBro = document.getElementById("canvasBrowser");
		// 	// var canvasBrowser = new Chart(canBro, config);
		// 	// var canvasBrowser = new Chart(canBro, {
		// 	// 	type: "horizontalBar",
		// 	// 	data: {
		// 	// 		labels: ["Chrome", "Edge", "Firefox"],
		// 	// 		datasets: {
		// 	// 			data: eval([8, 1, 2])
		// 	// 		}
		// 	// 	}
		// 	// });
		// 	var canvasBrowser = new Chart(canBro, {
	 //            type: 'horizontalBar',
	 //            data: {
	 //              labels: ['Chrome', 'Edge', 'Firefox'],
	 //              datasets: [
	 //                  {
	 //                    label: "Chrome",
	 //                    data: eval([8, 0, 0]),
	 //                    backgroundColor : "rgba(255,0,0,.5)"
	 //                  },
	 //                  {
	 //                    label: "Edge",
	 //                    data: eval([0, 1, 0]),
	 //                    backgroundColor : "rgba(255,50,0,.5)"
	 //                  },
	 //                  {
	 //                    label: "Firefox",
	 //                    data: eval([0, 0, 2]),
	 //                    backgroundColor : "rgba(255,0,55,.5)"
	 //                  }
	 //                ]
	 //            }
	 //        });
	 //    }
	 	google.load('visualization', '1.0', {
		  'packages': ['corechart']
		});

		// creates and populates a data table,
		// instantiates the pie chart, passes in the data and
		// draws it.
		function browserChart(fetching_data) {
		  console.log(fetching_data);
		  // Create the data table.
		  var data = new google.visualization.DataTable();
		  data.addColumn('string', 'Browser');
		  data.addColumn('number', 'Session');
		  data.addRows([
		    JSON.stringify(fetching_data)
		  ]);

		  // Set chart options
		  var options = {
		    'width': 400,
		    'height': 300
		  };

		  // Instantiate and draw our chart, passing in some options.
		  var chart = new google.visualization.PieChart(document.getElementById('canvasBrowser'));
		  chart.draw(data, options);
		  
		  var chart2 = new google.visualization.BarChart(document.getElementById('canvasCountry'));
		  chart2.draw(data, options);
		}
	</script>
@endsection      