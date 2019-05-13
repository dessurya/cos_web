<form id="storeData" method="post" action="{{ route('cms.content.tools', ['index' => $index]) }}">
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
						<label>Picture</label>
						@if($find != null and $find->picture)
						<code><a href="{{ asset('asset/picture/'.$index.'/'.$find->id.'/'.$find->picture) }}">{{ $find->picture }}</a></code>
						@endif
						<input 
							name="picture" 
							type="file" 
							class="form-control input-sm"
							accept=".png, .jpg, .jpeg"
							{{ $find != null ? '' : 'required' }}>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label>Content</label>
						<textarea 
							name="content" 
							type="text" 
							id="content" 
							class="form-control input-sm"
						>{{ $find != null ? $find->content : '' }}</textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

@if($find != null)
<div class="box box-solid">
	<div class="box-header with-border">
		<h3 class="box-title">Galeri</h3>
		<div class="box-tools pull-right">
			<button
				id="action"
				type="reset"
				class="tools btn btn-info" 
				data-action="form" 
				data-sel="false" 
				data-mulsel="false" 
				data-conf="false" 
				data-val="{{ $find->id }}">Refresh</button>
			<button 
				id="add-galeri"
				type="button" 
				class="btn btn-primary" 
				data-toggle="modal" 
				data-target="#modal-addpict"
				data-id="{{ $find->id }}">Add Picture</button>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<ul id="galeri" class="mailbox-attachments clearfix">
					@foreach($find->getGaleri($index) as $list)
					<li class="this_{{ $list->id }}">
						<span class="mailbox-attachment-icon has-img">
							<div style="background-image: url('{{ asset('asset/picture/'.$index.'/'.$find->id.'/galeri/'.$list->picture) }}'); background-position: center; background-size: cover; background-repeat: no-repeat; height: 160px; width: 100%;"></div>
						</span>
						<div class="mailbox-attachment-info">
							<a href="{{ asset('asset/picture/'.$index.'/'.$find->id.'/galeri/'.$list->picture) }}" class="mailbox-attachment-name view" alt="{{ $find->picture }}" title="{{ $list->picture }}">{{ substr($list->picture, -12) }}</a>
							<a 
								href="#" 
								class="tools btn btn-default btn-xs pull-right" 
								alt="delete" 
								title="delete"
								data-action="delete-galeri" 
								data-sel="false" 
								data-mulsel="false" 
								data-conf="true" 
								data-val="{{ $list->id }}"><i class="fa fa-trash-o"></i></a>
						</div>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@endif