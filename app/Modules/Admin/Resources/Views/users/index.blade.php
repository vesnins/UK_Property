@extends('admin::layouts.default')
@section('title', trans('admin::main.users'))
@section('content')

	@include('admin::layouts.left-menu')
	@include('admin::layouts.top-menu')

	<link href="{{ asset('/modules/js/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/modules/js/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/modules/js/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/modules/js/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('/modules/js/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	{{----}}
	<!-- pace -->
	<script src="{{ asset('/modules/js/pace/pace.min.js') }}"></script>
	<!-- Datatables-->
	<script src="{{ asset('/modules/js/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/dataTables.bootstrap.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/buttons.bootstrap.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/jszip.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/pdfmake.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/vfs_fonts.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/buttons.print.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/dataTables.fixedHeader.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/dataTables.keyTable.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/responsive.bootstrap.min.js') }}"></script>
	<script src="{{ asset('/modules/js/datatables/dataTables.scroller.min.js') }}"></script>

	<div class="right_col" role="main">
		<br />

		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>@lang('admin::main.users')</h2>

						<div class="nav navbar-right panel_toolbox">
							@if($right['x'])
								<a href="/admin/update/users" class="btn btn-primary">@lang('admin::main.create')</a>
							@endif
						</div>

						<div class="clearfix"></div>

						<hr class="clear" />
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">@lang('admin::main.selectActions'): </span>

								<select
									onchange="$.adm.makeD(this.value)"
									id="select1"
									class="form-control select"
									autocomplete="off"
								>
									<option value="0" id="defo">@lang('admin::main.selectActions')</option>
									<option value="edit">@lang('admin::main.edit')</option>
									<option value="delete">@lang('admin::main.remove')</option>
									<option value="copy">@lang('admin::main.copy')</option>
								</select>
							</div>

							<div class="error"></div>
							<div class="sass"></div>
							<input type="hidden" name="id_mt" class="id_mt" />
						</div>

						<table id="datatable" class="table table-striped table-bordered">
							<thead>
							<tr>
								<th>
									{{--<input type="checkbox" id="check-all" class="flat">--}}
								</th>
								<th>@lang('admin::main.name')</th>
								<th>@lang('admin::main.description')</th>
								<th>@lang('admin::main.active')</th>
								<th>@lang('admin::main.image')</th>
								<th>@lang('admin::main.dateOfCreation')</th>
								<th>@lang('admin::main.dateOfUpdate')</th>
							</tr>
							</thead>

							<tbody>
							@foreach($users as $val)
								<tr>
									<td class="a-center ">
										<input
											value="{{ $val['id'] }}"
											id="{{ $val['id'] }}"
											type="radio"
											title="{{ $val['name'] }}"
											class="flat flt-{{ $val['id'] }}"
											name="table_records"
										/>
									</td>

									<td><a href="/admin/update/users/{{ $val['id'] }}">{{ $langSt($val['name']) }}</a></td>
									<td>{{ mb_substr($langSt($val['text']), 0, 100, 'UTF-8') }}</td>
									<td>@if($val['active']) @lang('admin::main.shown') @else @lang('admin::main.hidden') @endif</td>

									<th>
										@if(isset($val['file']))
											@if($val['crop'] != '')
												<img src="/images/files/small/{{ $val['crop'] }}" style="max-width: 200px" />
											@else
												<img src="/images/files/small/{{ $val['file'] }}" style="max-width: 200px" />
											@endif
										@else
											@if(isset($val['name_free']))
												<img src="{{ $val['name_free'] }}" style="max-width: 200px" />
											@else
												<img src="/images/files/no-image.jpg" style="max-width: 200px" />
											@endif
										@endif
									</th>

									<td>{{ $val['created_at'] }}</td>
									<td>{{ $val['updated_at'] }}</td>
								</tr>
							@endforeach
							</tbody>
						</table>

						<script>
							var handleDataTableButtons = function() {
										"use strict";
										0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
											dom: "Bfrtip",

											buttons: [
												{extend: "copy", className: "btn-sm"},
												{extend: "csv", className: "btn-sm"},
												{extend: "excel", className: "btn-sm"},
												{extend: "pdf", className: "btn-sm"},
												{extend: "print", className: "btn-sm"}
											],

											responsive      : !0,
										})
									},

									TableManageButtons     = function() {
										"use strict";
										return {
											init: function() {
												handleDataTableButtons()
											}
										}
									}();
						</script>
						<script type="text/javascript" src="{{ asset('/modules/js/adm.js') }}"></script>

						<script type="text/javascript">
							$(document).ready(function() {
								$('#datatable').dataTable({
									"iDisplayLength": '{{ $modules['count_module'] or 10 }}',
								});

								$('#datatable-keytable').DataTable({
									keys: true
								});

								$('#datatable-responsive').DataTable();

								$('#datatable-scroller').DataTable({
									ajax          : "js/datatables/json/scroller-demo.json",
									deferRender   : true,
									scrollY       : 380,
									scrollCollapse: true,
									scroller      : true
								});

								var table = $('#datatable-fixed-header').DataTable({
									fixedHeader: true
								});

								TableManageButtons.init();

								$.adm.initialize({
									pram: [
										['elementsLoad', true],
										['link_module', 'users']
									]
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop