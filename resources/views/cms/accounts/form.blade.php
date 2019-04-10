<form id="storeData" method="post" action="{{ route('cms.account.tools') }}">
	<div class="box box-solid">
		<div class="box-header with-border">
			<h3 class="box-title">Add New Account</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Email</label>
						<input name="email" type="email" class="form-control input-sm" placeholder="Email" value="" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Name</label>
						<input name="name" type="text" class="form-control input-sm" placeholder="Name" value="" required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="hidden" name="action" value="store">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>