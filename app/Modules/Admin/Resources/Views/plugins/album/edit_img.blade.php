<div class="modal-body" style="padding: 0">
	<div class="panel-body" style="padding: 0">
		<form name="edit_img_album">
			<div class="thumbnail">
				@if($file['crop'])
					<img src="/images/files/small/{{ $file['crop'] }}" style="width: 100%; display: block;"/>
				@else
					<img src="/images/files/small/{{ $file['file'] }}" style="width: 100%; display: block;"/>
				@endif
			</div>

			<div class="" role="tabpanel" data-example-id="togglable-tabs">
				<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
					@foreach($lang_array as $key => $val)
						<li role="presentation" class="{!! !$key ? 'active' : '' !!}">
							<a
								href="#album-url-{{ $name . $key }}-tab"
								id="{{ $name . $key }}-tab"
								role="tab"
								data-toggle="tab"
								aria-expanded="{!! !$key ? 'true' : 'false' !!}"
							>
								{{ $val['name'] }}
							</a>
						</li>
					@endforeach
				</ul>

				<div id="myTabContent{{ $name }}" class="tab-content">
					@foreach($lang_array as $key => $v)
						@php($str_lang = count($lang_array) ? '[' . $v['name'] . ']' : '')
						<div
							role="tabpanel"
							class="tab-pane fade {!! !$key ? 'active in' : '' !!}"
							id="album-url-{{ $name . $key }}-tab"
							aria-labelledby="{{ $name . $key }}-tab"
						>
							<div class="wrapper wrapper-content animated fadeIn">
								<div class="form-group">
									<label for="name_img_edit{{ $name }}" class="col-md-3 control-label">
										@lang('admin::main.title')
									</label>

									<div class="col-md-9">
										<input
											type="text"
											id="name_img_edit{{ $name }}"
											class="form-control"
											name="name_img_edit{{ $name . $str_lang }}"
											value="{{ $langSt($file['name'], $v['name']) }}"
											maxlength="80"
										/>
									</div>

									<div class="clear"></div>
								</div>

								<div class="form-group">
									<label for="text_img_edit{{ $name }}" class="col-md-3 control-label">
										@lang('admin::main.description')
									</label>

									<div class="col-md-9">
									<textarea
										class="form-control"
										id="text_img_edit{{ $name }}"
										name="text_img_edit{{ $name . $str_lang }}"
										maxlength="200"
									>{{ $langSt($file['text'], $v['name']) }}</textarea>
									</div>

									<div class="clear"></div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>

			<div class="form-group alert" style="background: #f0f0f0">
				<label for="order_img_edit{{ $name }}" class="col-md-3 control-label">
					@lang('admin::main.sortingOrder')
				</label>

				<div class="col-md-9">
					<input
						type="number"
						id="order_img_edit{{ $name }}"
						class="form-control"
						name="order_img_edit{{ $name }}"
						value="{{ $file['order'] }}"
						style="border: none"
					/>
				</div>

				<div class="clear"></div>
			</div>

			<input type="hidden" name="_token" value="{{ csrf_token()  }}">
		</form>
	</div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-primary" onclick="sendEditImg{{ $name }}({{ $file['id'] }})">
		@lang('admin::main.save')
	</button>
</div>
