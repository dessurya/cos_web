@extends('frontend._layout.main')

@section('title')
	<title>Contact - Circles Of Sustainability</title>
@endsection

@section('meta')
	<meta name="title" content="Contact - Circles Of Sustainability">
	<meta name="description" content="{{ Str::words(strip_tags($page->content), 20, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<style type="text/css">
		#contact iframe,
		#contact .tab,
		#contact .tab .row,
		#contact .tab .row .col{
			height: 450px;
			vertical-align: middle;
		}
		#contact .float{
			position: relative;
			width: 50%;
			float: left;
		}
		#contact .float:nth-child(2) .row .col{
			padding: 0 50px;
		}
		#contact .float h1{
			margin-bottom: 10px;
		}
		@media screen and (max-width: 1024px){ /* tab and mobile / landscape and potrait */
			#contact .float{
				float: unset;
				width: 100%;
			}
			#contact .float:nth-child(1){
				margin-bottom: 20px;
			}
			#contact .float:nth-child(2) .row .col{
				padding: unset;
			}
			#contact .tab,
			#contact .tab .row,
			#contact .tab .row .col{
				display: block;
				height: auto;
			}
		}
	</style>
@endsection

@section('body')
	<div id="banner-head" style="background-image: url('{{ asset('asset/picture/page/'.$page->id.'/'.$page->picture) }}');"></div>

	<div id="contact" class="boxs">
		<div class="wrapper">
			<h1>Contact</h1>
			<div class="text-left">
				<div class="float">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58761.37063525609!2d106.83008776718762!3d-6.182635046306914!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf705f05a2e465e1!2sPlanetarium+Jakarta!5e0!3m2!1sid!2sid!4v1556865646097!5m2!1sid!2sid" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<div class="float">
					<div class="tab">
						<div class="row">
							<div class="col">
								{!! $page->content !!}
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	
@endsection

@section('include_js')
	
@endsection
