@extends('cms.master')

@section('title')
  <title>CMS - Profile</title>
@endsection

@section('css')
@endsection

@section('content')
	<section class="content-header">
		<h1>Profile</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="box box-primary">
					<div class="box-body box-profile">
						<h2 class="text-center">Halo!</h2>
						<img class="profile-user-img img-responsive img-circle" src="{{ asset('asset/picture-default/img-adminlte/avatar5.png') }}" alt="User profile picture">
						<h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
							<h5>Sign In Count : <small>{{ Auth::user()->login_count }}</small></h5>
							<h5>Last Sign In On: <small>{{ Auth::user()->last_login }}</small></h5>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#Detail" data-toggle="tab">
							Detail
						</a></li>
						<li class=""><a href="#History" data-toggle="tab">
							History
						</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="Detail">
							<form id="profile" action="{{ route('cms.profile.store') }}" method="post">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Email</label>
											<input name="email" type="email" class="form-control input-sm" placeholder="Your Email" value="{{ Auth::user()->email }}" readonly="" required="">
										</div>
										<div class="form-group">
											<label>Name</label>
											<input name="name" type="text" class="form-control input-sm" placeholder="Your Name" value="{{ Auth::user()->name }}" required="">
										</div>
										<div class="form-group">
											<label>Old Password</label>
											<input name="old_pass" type="password" class="form-control input-sm" placeholder="Your Old Password" required="">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>New Password</label>
											<input name="new_pass" type="password" class="form-control input-sm" placeholder="Your New Password">
										</div>
										<div class="form-group">
											<label>Retype New Password</label>
											<input name="retype_pass" type="password" class="form-control input-sm" placeholder="Retype Password">
										</div>	
										<div class="form-group">
											<br>
											<button type="submit" class="btn btn-primary">Save</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('js')
	<script type="text/javascript">
		$(document).on('submit', 'form#profile', function (argument) {
			var data = {};
			data['url'] = $(this).attr('action');
			data['input']  = new FormData($(this)[0]);
			excute(data);
			return false;
		});
	</script>
@endsection