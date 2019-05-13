@extends('frontend._layout.main')

@section('title')
	<title>About Us - Circles Of Sustainability</title>
@endsection

@section('meta')
	<meta name="title" content="About Us - Circles Of Sustainability">
	<meta name="description" content="{{ Str::words(strip_tags($about->content), 20, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" href="{{ asset('asset/css/main_list-float.css') }}">
@endsection

@section('body')
	<div id="banner-head" style="background-image: url('{{ asset('asset/picture/page/'.$about->id.'/'.$about->picture) }}');"></div>

	<div id="about" class="boxs">
		<div class="wrapper">
			<h1>About Us</h1>
			<div class="text-left">
				{!! $about->content !!}
			</div>
		</div>
	</div>
	
	<div id="list-float" class="boxs">
		<div class="item">
			<div class="flot img">
				<div id="pict" style="background-image: url('{{ asset('asset/picture/page/'.$visi->id.'/'.$visi->picture) }}');">
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
								<h1>Our Vision</h1>
								{!! $visi->content !!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="item">
			<div class="flot img">
				<div id="pict" style="background-image: url('{{ asset('asset/picture/page/'.$misi->id.'/'.$misi->picture) }}');">
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
								<h1>Our Mision</h1>
								{!! $misi->content !!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

@endsection

@section('include_js')

@endsection
