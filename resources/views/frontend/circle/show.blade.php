@extends('frontend._layout.main')

@section('title')
	<title>{{ $data->title }} - Circles Of Sustainability</title>
@endsection

@section('meta')
	<meta name="title" content="{{ $data->title }} - Circles Of Sustainability">
	<meta name="description" content="{{ $data->title }} - {{ Str::words(strip_tags($data->content), 20, ' ...') }}">
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
	<div id="banner-head" style="background-image: url('{{ asset('asset/picture/circle/'.$data->id.'/'.$data->picture) }}');"></div>

	<div class="boxs">
		<div class="wrapper">
			<h1>{{ $data->title }}</h1>
			<h3>{{ $data->subject }}</h3>
			<div class="text-left">
				{!! $data->content !!}
			</div>
		</div>
	</div>
	
	@if($data->getGaleri('circle')->count() > 0)
	<div id="galeri" class="boxs">
		<div class="wrapper">
			@foreach($data->getGaleri('circle') as $list)
			<a href="{{ asset('asset/picture/circle/'.$data->id.'/galeri/'.$list->picture) }}">
				<div class="img" style="background-image: url('{{ asset('asset/picture/circle/'.$data->id.'/galeri/'.$list->picture) }}');"></div>
			</a>
			@endforeach
		</div>
	</div>
	@endif

	<div id="comments" class="boxs">
		<div class="wrapper">
			<h2>Comments</h2>
			<form method="post" action="{{ route('main.comments') }}">
				@csrf
				<input type="hidden" name="index" value="circle">
				<input type="hidden" name="id_foreign" value="{{ $data->id }}">
				<div class="float right">
					<label>Name</label>@if($errors->has('name'))<span> *{{ $errors->first('name')}}</span>@endif<br>
					<input type="text" name="name" value="{{ old('name') }}" {{ Session::has('autofocus') ? 'autofocus' : ''}}>
				</div>
				<div class="float left">
					<label>Email</label>@if($errors->has('email'))<span> *{{ $errors->first('email')}}</span>@endif<br>
					<input type="email" name="email" value="{{ old('email') }}">
				</div>
				<div class="clearfix"></div>
				<div>
					<label>Comments</label>@if($errors->has('comments'))<span> *{{ $errors->first('comments')}}</span>@endif<br>
					<textarea name="comments" rows="5">{{ old('comments') }}</textarea>
				</div>
				<div>
					<button class="btn-dft btn-block" type="submit">Comments</button>
				</div>
			</form>
		</div>
		<div class="wrapper">
			<div class="comment">
				@foreach($comments as $list)
				<div class="list">
					<div class="persone">
						<h4 class="right">{{ $list->name }}</h4>
						<h4 class="left">{{ $list->email }}</h4>
						<div class="clearfix"></div>
					</div>
					<div class="comments">
						<p>{{ $list->comments }}</p>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection

@section('include_js')
	<script src="{{ asset('asset/vendors/baguetteBox/baguetteBox.min.js') }}"></script>
	<script type="text/javascript">
		baguetteBox.run('#galeri .wrapper');
	</script>
@endsection
