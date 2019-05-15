@extends('frontend._layout.main')

@section('title')
	<title>Circles Of Sustainability</title>
@endsection

@section('meta')
	<meta name="title" content="Circles Of Sustainability">
	<meta name="description" content="{{ Str::words(strip_tags($about->content), 20, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" type="text/css" href="{{ asset('asset/vendors/owl-carousel/owl.carousel.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('asset/vendors/owl-carousel/owl.theme.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('asset/vendors/owl-carousel/owl.transitions.css') }}">

	<link rel="stylesheet" href="{{ asset('asset/css/main_home.css?v=2019.1') }}">
@endsection

@section('body')
	@if(count($banner) >= 1)
	<div id="banner">
		@foreach($banner as $list)
		<div class="item">
			<div id="img" style="background-image: url('{{ asset('asset/picture/banner/'.$list->id.'/'.$list->picture) }}');">
				<div id="wrapper">
					<h1>{{ $list->title }}</h1>
					<p>{{ Str::words(strip_tags($list->content), 25, ' ...') }}</p>
					@if($list->url != null or $list->url != '')
					<div id="link">
						<a class="links" href="{{ $list->url }}">
							View Detail
						</a>
					</div>
					@endif
				</div>
			</div>
		</div>
		@endforeach
	</div>
	@endif
	
	@if($about->flag_active == 'Y')
	<div id="about" class="boxs">
		<div class="wrapper">
			<h1>About Us</h1>
			<div class="text-left">
				<p>{{ Str::words(strip_tags($about->content), 30, ' ...') }}</p>
			</div>
		</div>
	</div>
	@endif

	@if(count($politics) >= 1 and $politicp->flag_active == 'Y')
	<div id="politics" class="boxs">
		<div class="wrapper">
			<h1>SDG And Politics</h1>
			
			<div id="lists">
				@foreach($politics as $list)
				<div class="list text-left" style="background-image: url('{{ asset('asset/picture/politics/'.$list->id.'/'.$list->picture) }}');">
					<div class="content">
						<h2>{{ $list->title }}</h2>
						<h5>{{ $list->subject }}</h5>
						<p>{{ Str::words(strip_tags($list->content), 25, ' ...') }}</p>
						<a href="">Read More ></a>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	@endif

	@if(count($circle) >= 1 and $circlep->flag_active == 'Y')
	<div id="newsevent" class="boxs">
		<div id="bg" style="background-image: url('{{ asset('asset/picture/page/'.$circlep->id.'/'.$circlep->picture) }}');"></div>
		<div class="wrapper">
			<h1>Circle</h1>
			
			<div id="lists">
				@foreach($circle as $list)
				<div class="list text-center">
					<a href="">
						<div class="img" style="background-image: url('{{ asset('asset/picture/circle/'.$list->id.'/'.$list->picture) }}');"></div>
					</a>
					<div class="content">
						<a href="{{ route('main.circle.show', ['slug' => $list->slug]) }}">
							<h3>{{ $list->title }}</h3>
							<h5>{{ $list->subject }}</h5>
						</a>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	@endif

@endsection

@section('include_js')
	<script type="text/javascript" src="{{ asset('asset/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
	<script type="text/javascript">
		$("#banner").owlCarousel({
			transitionStyle : "fadeUp",
			navigation : false,
			items: 1,
			singleItem:true,
			pagination:true,
			autoPlay: 5000,
		    stopOnHover:false
		});
	</script>
@endsection
