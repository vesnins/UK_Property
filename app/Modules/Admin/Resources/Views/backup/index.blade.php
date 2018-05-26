@extends('admin::layouts.default')
@section('title',"Управление бекапами")
@section("header")
	<script src='/modules/js/ajaxupload.3.5.js'></script>
	<script src='/js/json2.js'></script>
	<script src='/modules/js/pxm.js'></script>
	<!-- lodash -->
	<script src='/js/lodash.min.js'></script>
@endsection
@section('content')

	@include('admin::layouts.left-menu')
	@include('admin::layouts.top-menu')
	<style>
		.btn-ex {
			display: none;
			height: 16px;
			font-size: 10px;
			padding: 0px 10px;
		}

		.p-ex {
			cursor: pointer;
			height: 20px;
		}

		.p-ex:hover .btn-ex {
			display: inline-block;
		}
	</style>
	<div class="right_col" role="main"><br/>
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>@lang('admin::main.export_import_backups')</h2>

						<div class="nav navbar-right panel_toolbox">
							@if($right['x'])
								<a type="application/file" href="/admin/index/backup/sqlBackup" class="btn btn-app">
									<i class="fa fa-life-saver"></i>
									@lang('admin::main.backupOfTheEntireDatabase') (sql)
								</a>

								<a type="application/file" href="/admin/index/backup/tarBackup" class="btn btn-app">
									<i class="fa fa-life-saver"></i>
									@lang('admin::main.archiveOfTheWholeSite') (tar)
								</a>
								<a type="application/file" href="/admin/index/backup/delBackup" class="btn btn-app"
									 title="Удалить бекапы">
									<i class="fa fa-trash"></i>
									@lang('admin::main.clear')
								</a>
							@endif
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="x_panel">
					<div class="x_title">
						<h2>
							@lang('admin::main.import')
							<small>@lang('admin::main.selectTheXml_xlsbFile')</small>
						</h2>

						<div class="nav navbar-right panel_toolbox">
							@if($right['x'])
								<div id="mainbody">
									<div id="upload">
										<input class="btn btn-primary" type="submit" value="@lang('admin::main.add_update')"/>
									</div>
								</div>
							@endif
						</div>

						<div class="clearfix"></div>

						<div>
							<div class="panel panel-primary" style="padding: 5px">
								<div class="col-md-3">
									@lang('admin::main.importForTable'):
								</div>

								<div class="col-md-9">
									<select class="form-control table-name select2" name="table">
										@foreach($name_table as $key => $val)
											<option value="{{ $val }}">
												<?=
												$modules[$val]['name_module'] ?? false
													? (trans('admin::main.' . $modules[$val]['translate_key']) ?? $modules[$val]['name_module']) . ' (' . $val . ')'
													: $val
												?>
											</option>
										@endforeach
									</select>
								</div>

								<div class="bg-primary clear"></div>
							</div>

							<span id="status"></span>
							<div class="res-parse"></div>

							<script>
								$(document).ready(function() {
									$.pxml.initialize({
										csrf_token: '{{ csrf_token() }}'
									});
								});
							</script>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="x_panel">
					<div class="x_title">
						<h2>
							@lang('admin::main.export')
							<small>@lang('admin::main.markTablesUnloaded')</small>
						</h2>

						<div class="nav navbar-right panel_toolbox">
							@if($right['x'])
								<a href="" class="btn btn-primary">@lang('admin::main.unload')</a>
							@endif
						</div>

						<div class="clearfix"></div>

						<div class="" role="tabpanel" data-example-id="togglable-tabs">
							<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
								<li role="presentation" class="active">
									<a href="#tab_content0" id="home-tab0" role="tab" data-toggle="tab" aria-expanded="true">
										@lang('admin::main.tables')
									</a>
								</li>
							</ul>

							<p>
								<select class="select2" name="type_export" autocomplete="off">
									<option name="">@lang('admin::main.selectTypeDocumentExport')</option>
									<option name="xml">Xml</option>
									<option name="sql">Sql</option>
									<option name="table">Table</option>
								</select>
							</p>

							<div id="myTabContent" class="tab-content">
								@foreach($modules ?? [] as $val)
									<ul class="nav nav-pills">
										<li style="margin-bottom: 5px">
											<input type="checkbox" name="tables" class="flat" autocomplete="off"/>
											<span>{{ trans('admin::main.' . $val['translate_key']) ?? $val['name_module'] }}</span>
										</li>
									</ul>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
