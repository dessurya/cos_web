@extends('frontend._layout.main')

@section('title')
	<title>{{ $newsevent->title }} - Circles Of Sustainability</title>
@endsection

@section('meta')
	<meta name="title" content="{{ $newsevent->title }} - Circles Of Sustainability">
	<meta name="description" content="{{ $newsevent->title }} - {{ Str::words(strip_tags($newsevent->content), 20, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" type="text/css" href="{{ asset('asset/vendors/baguetteBox/baguetteBox.min.css') }}">
	<style type="text/css">
		#galeri a{
			text-decoration: unset;
			margin: 0;
			line-height: 0;
		}
		#galeri .img{
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
			width: 24%;
			height: 200px;
			display: inline-block;
			margin: 0 auto;
		}
	</style>
@endsection

@section('body')
	<div id="banner-head" style="background-image: url('{{ asset('asset/picture/news-event/'.$newsevent->id.'/'.$newsevent->picture) }}');"></div>

	<div class="boxs">
		<div class="wrapper">
			<h1>{{ $newsevent->title }}</h1>
			<div class="text-left">
				{!! $newsevent->content !!}
			</div>
		</div>
	</div>
	
	@if($newsevent->getGaleri('news-event')->count() > 0)
	<div id="galeri" class="boxs">
		<div class="wrapper">
			@foreach($newsevent->getGaleri('news-event') as $list)
			<a href="{{ asset('asset/picture/news-event/'.$newsevent->id.'/galeri/'.$list->picture) }}">
				<div class="img" style="background-image: url('{{ asset('asset/picture/news-event/'.$newsevent->id.'/galeri/'.$list->picture) }}');"></div>
			</a>
			@endforeach
		</div>
	</div>
	@endif
@endsection

@section('include_js')
	<script src="{{ asset('asset/vendors/baguetteBox/baguetteBox.min.js') }}"></script>
	<script type="text/javascript">
		baguetteBox.run('#galeri .wrapper');
	</script>
@endsection
