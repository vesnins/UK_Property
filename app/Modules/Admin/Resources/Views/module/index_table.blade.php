<link href="{{ asset('/modules/js/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/modules/js/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/modules/js/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/modules/js/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/modules/js/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/modules/js/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/modules/js/datatables/rowReorder.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<style>
	.img_none img {
		display: none;
	}
</style>

@if(!empty($filters) || $sort != '')

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top: 15px">
		<div class="panel panel-default">
			<div class="panel-heading" id="headingOne" role="button" data-toggle="collapse" data-parent="#accordion"
				href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				<h4 class="panel-title">@lang('admin::main.filters')</h4>
			</div>

			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
					<form method="get">
						@if($sort)
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('admin::main.category')</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control sort" name="cat">
										{!! $sort !!}
									</select>
								</div>
								<br class="clear" />
							</div>

							<script>
								$('.sort').val({{ $cat }});
							</script>
						@endif

						@foreach($filters as $val)
							{!! str_replace('--options--', '', $val['html']) !!}
						@endforeach

						<script>
							@foreach($where_get as $key => $v)
							$('[name="pl[{{ $key }}]"]').val('{{ $v }}');
							@endforeach
						</script>

						<div class="text-right">
							<a href="/admin/index/{{ $table }}" class="btn btn-danger">@lang('admin::main.clear')</a>
							<button type="submit" class="btn btn-primary">@lang('admin::main.show')</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endif

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
<script src="{{ asset('/modules/js/datatables/dataTables.rowReorder.js') }}"></script>

<style>
	#table_id_wrapper .row{
		min-height: .01%;
		overflow-x: auto;
		width: 100%;
	}

	#table_id_wrapper .row table {
		width: 100%!important;
	}

	#table_id_wrapper .row .dataTables_filter {
		width: 100%;
	}
</style>

<div class="">
	<table id="table_id" class="table table-striped table-bordered">
		<thead>
		<tr>
			<th></th>
			@foreach($column as $v)
				<th>
					{!! ($v['translateKey'] ?? false) ? trans('admin::plugins.' . $v['translateKey']) : $v['nameText'] !!}
				</th>
			@endforeach
			<th>@lang('admin::main.dateOfUpdate')</th>
		</tr>
		</thead>
	</table>
</div>

@push('footer')
	<script>
		var
			table = $('#table_id').DataTable({
//				rowReorder: {
//					dataSrc: 'order',
//					selector: 'tr',
//					update: true,
//				},

				"bServerSide"   : true,
				"aaSorting"     : [[0,'desc']],
				"sAjaxSource"   : "/admin/getData/{{ $table }}?{!! $url !!}",
				"sServerMethod" : "POST",
				"iDisplayLength": '{{ $modules['count_module'] or 10 }}',
				"sAjaxDataProp" : "data",
				select: true,
				columns: [
					{data: 'id'},
						@foreach($column as $v)
					{
						data: '{{ $v['name'] }}'
					},
						@endforeach
					{
						data: 'created_at'
					}
				],
			});

		{{--table.on('mousedown', 'tbody tr', function() {--}}
				{{--@php($i = 1)--}}
			{{--var order = parseInt(' @foreach($column as $v) @if($v['name'] == 'order'){{ $i }}@endif @php($i++) @endforeach');--}}

			{{--$('body').mouseup(function() {--}}
			{{--setTimeout(function() {--}}
				{{--var--}}
					{{--row = [],--}}
					{{--tr = $('#table_id > tbody > tr');--}}

				{{--console.log(tr)--}}

				{{--for(var i = 0; tr.length > i; i++) {--}}
					{{--tmp = tr[i];--}}
					{{--row.push({--}}
						{{--id   : $($(tr[i]).find('td')[0]).find('input').attr('id'),--}}
						{{--order: $($(tr[i]).find('td')[order]).html() === '—' ? 0 : $($(tr[i]).find('td')[order]).html()--}}
					{{--});--}}
				{{--}--}}
				{{--console.log(row)--}}
			{{--}, 300)--}}

			{{--})--}}
		{{--});--}}
	</script>
@endpush
