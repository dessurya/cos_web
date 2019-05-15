<div id="navigasi">
	<div id="absen"></div>
	<div id="wrapper">
		<div id="logo">
			<div class="tab">
				<div class="row">
					<div class="col">
						<img src="{{ asset('asset/picture-default/cos_logo_full.png') }}">
					</div>
					<div class="col title">
						<span id="one">Circles<br>Of<br>Sustainability</span>
						<span id="two">Circles Of Sustainability</span>
					</div>
					<div id="burger">
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>
			</div>
		</div>
		<div id="list">
			<div class="tab">
				<div class="row">
					<div class="col">
						<a class="{{ route::is('main.home') ? 'active' : '' }}" href="{{ route('main.home') }}">
							Home
						</a>
					</div>
					{!! (new App\Http\Controllers\FrontendController)->navbar_static() !!}
				</div>
			</div>
		</div>
	</div>
</div>