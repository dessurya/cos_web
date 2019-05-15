@extends('frontend._layout.main')

@section('title')
	<title>SDG And Politics - Circles Of Sustainability</title>
@endsection

@section('meta')
	<meta name="title" content="SDG And Politics - Circles Of Sustainability">
	<meta name="description" content="{{ Str::words(strip_tags($page->content), 20, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" href="{{ asset('asset/css/main_list-float.css?v=2019.1') }}">
@endsection

@section('body')
	<div id="banner-head" style="background-image: url('{{ asset('asset/picture/page/'.$page->id.'/'.$page->picture) }}');"></div>

	<div class="boxs">
		<div class="wrapper">
			<h1>SDG And Politics</h1>
			<div class="text-left">
				{!! $page->content !!}
			</div>
		</div>
	</div>
	
	<div id="list-float" class="boxs">
		@foreach($data as $list)
		<div class="item">
			<div class="flot img">
				<div id="pict" style="background-image: url('{{ asset('asset/picture/politics/'.$list->id.'/'.$list->picture) }}');">
					<div class="tab">
						<div class="row">
							<div class="col">
								<div id="absen"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="flot content">
				<div class="tab">
					<div class="row">
						<div class="col">
							<div>
								<h3>{{ $list->title }}</h3>
								<h4>{{ $list->subject }}</h4>
								<p>{{ Str::words(strip_tags($list->content), 65, ' ...') }}</p>
								<a class="links" href="{{ route('main.politic.show', ['slug' => $list->slug]) }}">View More</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		@endforeach
	</div>

	<div id="ajax" class="boxs">
		<div class="wrapper text-center">
			<div>
				<span style="display: none;"></span>
			</div>
			<a id="call-data" class="btn-dft" href="{{ route('main.politic.data') }}">Load More</a>
		</div>
	</div>

@endsection

@section('include_js')
	<script type="text/javascript">
		var page = 1;
		$(function(){
			$(document).on('click', '#ajax.boxs a#call-data', function(){
				if ($(this).hasClass('disable')) {
					return false;
				}
				page += 1;
				var url = $(this).attr('href')+'?page='+page;
				$.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });
	            $.ajax({
	                url: url,
	                type: 'post',
	                dataType: 'json',
	                beforeSend: function() {
	                    $('#ajax.boxs span').show().html("Please Wait Load Your Data...");
	                },
	                success: function(data) {
	                	if (data.html) {
	                		window.setTimeout(function() {
	                            $('#list-float').append(data.html);
	                        }, 350);
	                        window.setTimeout(function() {
	                            $('#ajax.boxs span').hide().html('');
	                        }, 1675);
	                	}
	                	else{
	                		window.setTimeout(function() {
		                		$('#ajax.boxs a#call-data').addClass('disable');
	                        }, 350);
	                        window.setTimeout(function() {
	                            $('#ajax.boxs span').show().html("Sorry Not Found New Data..");
	                        }, 475);
	                        window.setTimeout(function() {
	                            $('#ajax.boxs span').hide().html('');
	                        }, 1675);
	                	}
	                }
	            });
	            return false;
			});
		});
	</script>
@endsection
