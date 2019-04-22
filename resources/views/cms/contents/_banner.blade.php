<form id="storeData" method="post" action="{{ route('cms.content.tools', ['index' => 'banner']) }}">
	<div class="box box-solid">
		<div class="box-header with-border">
			<h3 class="box-title">{{ $titl }}@if($find != null) {{ Str::title(str_replace('-', ' ', $find->title)) }} @endif</h3>
			<div class="box-tools pull-right">
				<input type="hidden" name="action" value="store">
                @if($find != null)
                <input type="hidden" name="id" value="{{ $find->id }}">
				<button
					id="action"
					type="reset"
					class="tools btn btn-info" 
					data-action="form" 
					data-sel="false" 
					data-mulsel="false" 
					data-conf="false" 
					data-val="{{ $find->id }}">Refresh</button>
				@endif
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Title</label>
						<input 
							name="title" 
							type="text" 
							class="form-control input-sm" 
							placeholder="Title" 
							value="{{ $find != null ? $find->title : '' }}"
							required="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Url</label>
						<input 
							name="url" 
							type="text" 
							class="form-control input-sm" 
							placeholder="Url" 
							value="{{ $find != null ? $find->url : '' }}">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Content</label>
						<input 
							name="content" 
							type="text" 
							class="form-control input-sm" 
							placeholder="Content" 
							value="{{ $find != null ? $find->content : '' }}">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Picture</label>
						@if($find != null and $find->picture)
						<code><a href="{{ asset('asset/picture/banner/'.$find->id.'/'.$find->picture) }}">{{ $find->picture }}</a></code>
						@endif
						<input 
							name="picture" 
							type="file" 
							class="form-control input-sm"
							accept=".png, .jpg, .jpeg"
							{{ $find != null ? '' : 'required' }}>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>