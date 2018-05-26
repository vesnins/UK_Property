@extends('admin::layouts.default')
@section('title', trans('admin::main.namePanel') . ' ' . $version)
@section('content')

	@include('admin::layouts.left-menu')
	@include('admin::layouts.top-menu')
	<div class="right_col" role="main">
		<br/>

		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>
							@lang('admin::main.users')
							@if(empty($data))
								<small>@lang('admin::main.create')</small>
							@else
								<small>@lang('admin::main.edit')</small>
							@endif
						</h2>
						<hr class="clear"/>

						<form method="post" class="form-modules form-horizontal form-label-left">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">

								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active">
										<a
											href="#url-main-tab"
											id="main-tab"
											role="tab"
											data-toggle="tab"
											aria-expanded="true"
										>
											@lang('admin::main.basic')
										</a>
									</li>
									@foreach($lang_array as $key => $val)
										<li role="presentation" class="">
											<a
												href="#url-{{ $key }}-tab"
												id="{{ $key }}-tab"
												role="tab"
												data-toggle="tab"
												aria-expanded="false"
											>
												{{ $val['name'] }}
											</a>
										</li>
									@endforeach
								</ul>

								<div id="myTabContent" class="tab-content">
									<div
										role="tabpanel"
										class="tab-pane fade active in"
										id="url-main-tab"
										aria-labelledby="main-tab"
									>
										{!! $album !!}

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Статус</label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<select name="pl[active]" id="selectActive" class="form-control select2">
													<option value="1" {!! (isset($data->active) ? $data->active : '') == 1 ? 'selected' : '' !!}>
														@lang('admin::main.active')
													</option>
													<option value="0" {!! (isset($data->active) ? $data->active : '') == 0 ? 'selected' : '' !!}>
														@lang('admin::main.notActive')
													</option>
												</select>
											</div>

											<br class="clear"/>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">E-mail</label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<input
													type="text"
													name="pl[email]"
													value="{{ $data->email or '' }}"
													id="inputEmail"
													class="form-control"
													placeholder="E-mail"
												>
											</div>

											<br class="clear"/>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">
												@lang('admin::main.currentPassword')
											</label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<input
													type="text"
													value="{{ $data->save_password or '' }}"
													class="form-control"
													id="exampleInputEmail"
													placeholder="@lang('admin::main.currentPassword')"
													disabled
												/>
											</div>

											<br class="clear"/>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('admin::main.newPassword')</label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<input
													type="text"
													name="pl[password]"
													autocomplete="false"
													value=""
													class="form-control"
													id="exampleInputEmail"
													placeholder="@lang('admin::main.newPassword')"
												>
											</div>

											<br class="clear"/>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">
												@lang('admin::main.typeOfRights')
											</label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<select name="pl[usertype]" id="selectRight" class="form-control select2">
													<option
														value="user"
														{!! (isset($data->usertype) ? $data->usertype : '') == 'user' ? 'selected' : '' !!}
													>@lang('admin::main.mixedRights')</option>

													<option
														value="admin"
														{!! (isset($data->usertype) ? $data->usertype : '') == 'admin' ? 'selected' : '' !!}
													>@lang('admin::main.fullRights')</option>
												</select>

											</div>
											<br class="clear"/>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">
												@lang('admin::main.anotherUserType')
											</label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<select name="pl[user_another_type]" id="selectAnotherUserType" class="form-control select2">
													<option value="">-</option>

													<option
														value="author"
														{!! ($data->user_another_type ?? '') == 'author' ? 'selected' : '' !!}
													>@lang('admin::main.client')</option>

													<option
														value="specialist"
														{!! ($data->user_another_type ?? '') == 'specialist' ? 'selected' : '' !!}
													>@lang('admin::main.specialist')</option>
												</select>
											</div>

											<br class="clear"/>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">
												@lang('admin::main.is_about_us')
											</label>

											<div class="col-md-6 col-sm-6 col-xs-12">
												<select
													autocomplete="off"
													name="pl[is_about_us]"
													id="selectAnotherUserType"
													class="form-control select2"
												>
													<option
														value="0"
														{!! ($data->is_about_us ?? '') == 0 ? 'selected' : '' !!}
													>@lang('admin::main.no')</option>

													<option
														value="1"
														{!! ($data->is_about_us ?? '') == 1 ? 'selected' : '' !!}
													>@lang('admin::main.yes')</option>
												</select>
											</div>

											<br class="clear"/>
										</div>

										<div class="col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
											<a class="btn btn-default" onclick="$('.flat-power').iCheck('check')">
												@lang('admin::main.select_all')
											</a>

											<a class="btn btn-default" onclick="$('.flat-power').iCheck('uncheck')">
												@lang('admin::main.remove_all')
											</a>
										</div>

										<div class="clear"></div>

										<div class="module-right">
											@foreach($modules as $val)
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12" style="padding: 0">
														{{ $val['name_module'] }}
													</label>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<input type="hidden" value="{{ $val['id'] }}" name="id_menu[{{ $val['id'] }}]"/>

														<label>
															<input
																autocomplete="off"
																type="checkbox"
																class="flat flat-power"
																value="1"
																name="r[{{ $val['id'] }}]"
																{!! ($val['r'] ?? 0) === 1 ? 'checked' : '' !!}
															/>
															{{--{{ print_r($val) }}--}}
															@lang('admin::main.view')
														</label>

														<label>
															<input
																type="checkbox"
																class="flat flat-power"
																value="1"
																name="x[{{ $val['id'] }}]"
																{!! (isset($val['x']) ? $val['x'] : '') == 1 ? 'checked' : '' !!}
															/>
															@lang('admin::main.change')
														</label>

														<label>
															<input
																type="checkbox"
																class="flat flat-power"
																value="1"
																name="w[{{ $val['id'] }}]"
																{!! (isset($val['w']) ? $val['w'] : '') == 1 ? 'checked' : '' !!}
															/>
															@lang('admin::main.creation')
														</label>

														<label>
															<input
																type="checkbox"
																class="flat flat-power"
																value="1"
																name="d[{{ $val['id'] }}]"
																{!! (isset($val['d']) ? $val['d'] : '') == 1 ? 'checked' : '' !!}
															/>
															@lang('admin::main.removal')
														</label>

														<hr style="margin: 0"/>
													</div>
													<br class="clear"/>
												</div>
											@endforeach
										</div>
									</div>

									@foreach($lang_array as $key => $val)
										<div
											role="tabpanel"
											class="tab-pane fade"
											id="url-{{ $key }}-tab"
											aria-labelledby="{{ $key }}-tab"
										>
											<div class="wrapper wrapper-content animated fadeIn">
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12">
														@lang('admin::main.name')
													</label>

													<div class="col-md-6 col-sm-6 col-xs-12">
														<input
															type="text"
															name="pl[name][{{ $val['name'] }}]"
															value="{{ $langSt($data->name ?? '', $val['name']) }}"
															id="inputName"
															class="form-control"
															placeholder="@lang('admin::main.name')"
														>
													</div>

													<br class="clear"/>
												</div>

												<div class="form-group">
													<label style="padding-top: 0px;" class="control-label col-md-3 col-sm-3 col-xs-12">
														@lang('admin::main.description')
													</label>

													<div class="col-md-6 col-sm-6 col-xs-12">
														<textarea
															class="form-control"
															id="textareaText"
															name="pl[text][{{ $val['name'] }}]"
															placeholder="@lang('admin::main.description')"
															rows="3"
														>{!! $langSt($data->text ?? '', $val['name']) !!}</textarea>
													</div>

													<br class="clear"/>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>

							<div class="loader"></div>

							<div class="text-right">
								<button class="btn btn-success" type="submit">@lang('admin::main.save')</button>

								<button class="btn btn-primary" formaction="/admin/update/users/{{ $id }}/1" type="submit">
									@lang('admin::main.apply')
								</button>

								<button class="btn btn-default" formaction="/admin/index/users" type="submit">
									@lang('admin::main.close')
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ asset('/modules/js/modules.js') }}"></script>
	<script>
		$(document).ready(function() {
			modules.initialize({});

			$('#selectRight').on('change', function(e) {
				var display = this.value === 'admin' ? 'none' : 'block';

				$('.module-right').css({display: display})
			});

			if($('#selectRight').val() === 'admin') $('.module-right').css({display: 'none'})
		});
	</script>
	</div>
@stop