@push('header')
	<!-- FullCalendar -->
	<link href="{{ asset('modules/css/calendar/fullcalendar.min.css') }}" rel="stylesheet">
	<link href="{{ asset('modules/css/calendar/fullcalendar.print.css') }}" rel="stylesheet" media="print">
	<!-- FullCalendar -->
	<script src="{{ asset('modules/js/moment/moment.min.js') }}"></script>
	<script src="{{ asset('modules/js/calendar/fullcalendar.min.js') }}"></script>
	<script src="{{ asset('modules/js/calendar/locale-all.js') }}"></script>
@endpush

<button
	type="button"
	class="btn btn-primary adding_a_new_date"
	onclick="
		$('#CalenderModalNew').modal('show');
		$('[name=\'calendar_id\']').val('');
		$('[name=\'calendar_description\']').val('');
		$('[name=\'calendar_title\']').val('');
		$('[name=\'daterange\']').val('');
"
>
	@lang('admin::main.add')
</button>

@if($id)
	<div id='calendar0'></div>
	{!! $field !!}
	<div id='calendar1'></div>
	<br class="clear" />
@else
	<div class="alert alert-info">@lang('admin::main.text_no_id_calendar')</div>
@endif

<style>
	.fc-content span {
		color: #fff !important;
	}

	#booking_calendar, #calendar1, #calendar0 {
		width: 30%;
		margin-left: 15px;
		display: inline-block;
		margin-bottom: 15px;
	}

	.fc-scroller {
		overflow-x: initial !important;
		overflow-y: initial !important;
		height: initial !important;
	}

	#booking_calendar .fc-left {
		position: absolute !important;
		left: 15px !important;
	}

	#booking_calendar .fc-center {
		margin-top: 30px;
		margin-bottom: -7px;
	}

	#booking_calendar .fc-right {
		position: absolute !important;
		right: 15px !important;
	}

	.fc-event.fc-draggable, .fc-event[href] {
		cursor: pointer;
		margin-top: -25px;
		/*height: 43px;*/
		height: 30px;

		/*border-radius: 20px 20px/20px 0px;*/
	}

	.fc-event.fc-draggable, .fc-event[href]::after {
		border-left: 15px solid hsl(127.2, 42.2%, 57.3%);
		border-right: 15px solid #aa0000;
	}

	.fc-ltr .fc-basic-view .fc-day-number {
		text-align: right;
		z-index: 1;
		position: relative;
	}

	.daterangepicker.dropdown-menu {
		z-index: 999999;
	}

	.adding_a_new_date {
		position: absolute;
		left: 95px;
		height: 27px;
		line-height: 13px;
	}

	@media (max-width: 767px) {
		#booking_calendar, #calendar1, #calendar0 {
			width: auto;
			margin-left: 15px;
			display: block;
			margin-bottom: 15px;
		}
	}
</style>

@push('footer')
	<script>
		var
			calendar_0 = $("#calendar0"),
			calendar_1 = $("#booking_calendar"),
			calendar_2 = $('#calendar1');

		function removeEvent() {
			var id = $('input[name="calendar_id"]').val();

			$.ajax({
				type    : "post",
				url     : "/admin/plugins/removeCalendarRow",
				data    : {id: id},
				cache   : false,
				dataType: "json",

				success: function() {
					var
						data_0 = calendar_0.fullCalendar('clientEvents') || [],
						data_1 = calendar_1.fullCalendar('clientEvents') || [],
						data_2 = calendar_2.fullCalendar('clientEvents') || [];

					for(var i = 0; data_0.length > i; i++)
						if(data_0[i].id == id)
							calendar_0.fullCalendar('removeEvents', data_0[i]._id);

					for(var i = 0; data_1.length > i; i++)
						if(data_1[i].id == id)
							calendar_1.fullCalendar('removeEvents', data_1[i]._id);

					for(var i = 0; data_2.length > i; i++)
						if(data_2[i].id == id)
							calendar_2.fullCalendar('removeEvents', data_2[i]._id);

					$('input[name="calendar_title"]').val('');
					$('input[name="daterange"]').val('');
					$('[name="calendar_description"]').val('');
					$('[name="calendar_id"]').val('');

					$('#CalenderModalNew').modal('hide');
				}
			});

			calendar_0.fullCalendar('unselect');
			calendar_1.fullCalendar('unselect');
			calendar_2.fullCalendar('unselect');
		}

		function eventResize(a) {
			setCalendarRow({
				description: a.description || '',
				end        : a.end.format("YYYY-MM-DD HH:mm:ss"),
				id         : a.id,
				start      : a.start.format("YYYY-MM-DD HH:mm:ss"),
				title      : a.title,
			});
		}

		function editEvent(a) {
			$('#CalenderModalNew').modal('show');
			$('input[name="calendar_id"]').val(a.id);
			$('input[name="calendar_title"]').val(a.title);
			$('[name="calendar_description"]').val(a.description);

			if(a.start) {
				$('input[name="daterange"]').data('daterangepicker').remove();

				$('input[name="daterange"]').daterangepicker({
					opens    : 'left',
					startDate: a.start.format("MM/DD/YYYY"),
					endDate  : a.end.add('day', -1).format("MM/DD/YYYY")
				});

				//				$('input[name="daterange"]').data('daterangepicker').startDate = a.start.format("MM/DD/YYYY");
				//				$('input[name="daterange"]').data('daterangepicker').endDate = a.end.format("MM/DD/YYYY");
				$('input[name="daterange"]').val(a.start.format("MM/DD/YYYY") + ' - ' + a.end.add('day', -1).format("MM/DD/YYYY"));
				//				$('input[name="daterange"]').data('daterangepicker').updateView()
			}
		}

		function setCalendarRow(data) {
			$.ajax({
				type    : "post",
				url     : "/admin/plugins/setCalendarRow",
				data    : data,
				cache   : false,
				dataType: "json"
			});
		}

		window.bookingCalendarInit = function() {
			$.ajax({
				type    : "post",
				url     : "/admin/plugins/getCalendarList",
				data    : {villas_id: '{{ $id }}'},
				cache   : false,
				dataType: "json",

				success: function(data) {
					// так как выезд в 12:00 а не например в 00:01 нового дня
					for(var i = 0; data.items.length > i; i++)
						data.items[i].end = moment(data.items[i].end, "YYYY-MM-DD").add('day', 1).format("YYYY-MM-DD");

					return CalendarInit(data);
				}
			});
		};

		function CalendarInit(data) {
			if(typeof $.fn.fullCalendar != "undefined") {
				var e;

				calendar_1.fullCalendar({
					locale: '{{ $lang }}',

					header: {
						left  : "prev,next",
						center: "title",
						// right : "month,agendaWeek,agendaDay,listMonth"
					},

					showNonCurrentDates: false,
					selectable         : true,
					selectHelper       : false,
					editable           : true,
					events             : data.items,
					eventClick         : editEvent,
					eventResize        : eventResize,

					viewRender: function(view, element) {
						var cur = view.intervalStart;
						var d   = moment(cur).add('months', 1);
						var d0  = moment(cur).add('months', -1);

						calendar_0.fullCalendar('gotoDate', d0);
						calendar_2.fullCalendar('gotoDate', d);
					},
				});
			}

			calendar_0.fullCalendar({
				locale: '{{ $lang }}',

				header: {
					left  : 'title',
					center: '',
					right : ''
				},

				showNonCurrentDates: false,
				defaultDate        : moment().add('months', -1),
				selectable         : true,
				selectHelper       : false,
				editable           : true,
				events             : data.items,
				eventClick         : editEvent,
				eventResize        : eventResize,
			});

			calendar_2.fullCalendar({
				locale: '{{ $lang }}',

				header: {
					left  : 'title',
					center: '',
					right : ''
				},

				showNonCurrentDates: false,
				defaultDate        : moment().add('months', 1),
				selectable         : true,
				selectHelper       : false,
				editable           : true,
				events             : data.items,
				eventClick         : editEvent,
				eventResize        : eventResize,
			});
		}

		function addingSelectRowModal() {
			var
				a  = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD'),
				b  = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD'),
				c,
				id = $('input[name="calendar_id"]').val();

			$.ajax({
				type: "post",
				url : "/admin/plugins/setCalendarRow",

				data: {
					end        : b,
					id         : id,
					start      : a,
					title      : $('input[name="calendar_title"]').val(),
					description: $('[name="calendar_description"]').val(),
					villas_id  : '{{ $id }}',
				},

				cache   : false,
				dataType: "json",

				success: function(data) {
					var
						data_0 = calendar_0.fullCalendar('clientEvents') || [],
						data_1 = calendar_1.fullCalendar('clientEvents') || [],
						data_2 = calendar_2.fullCalendar('clientEvents') || [];

					// так как выезд в 12:00 а не например в 00:01 нового дня
					b = moment(b, "YYYY-MM-DD").add('day', 1).format("YYYY-MM-DD");

					$('input[name="calendar_title"]').val('');
					$('input[name="daterange"]').val('');
					$('[name="calendar_description"]').val('');
					$('input[name="calendar_id"]').val('');

					var data_tmp = {
						allDay     : c,
						end        : b,
						id         : data.items.id,
						start      : a,
						title      : data.items.title,
						description: data.items.description,
					};

					if(parseInt(id) > 0) {
						for(var i = 0; data_0.length > i; i++) {
							var isAdding = true;

							if(data_0[i].id == id) {
								isAdding = false;
								data_tmp = _.merge(data_0[i], _.merge(data_tmp, {_id: data_0[i]._id}));
							}
						}

						if(isAdding)
							calendar_0.fullCalendar("renderEvent", data_tmp);
						else
							calendar_0.fullCalendar("updateEvent", data_tmp);

						for(var i = 0; data_1.length > i; i++) {
							var isAdding = true;

							if(data_1[i].id == id) {
								isAdding = false;
								data_tmp = _.merge(data_1[i], _.merge(data_tmp, {_id: data_1[i]._id}));
							}
						}

						if(isAdding)
							r = calendar_1.fullCalendar("renderEvent", data_tmp);
						else
							r = calendar_1.fullCalendar("updateEvent", data_tmp);

						for(var i = 0; data_2.length > i; i++) {
							var isAdding = true;

							if(data_2[i].id == id) {
								isAdding = false;
								data_tmp = _.merge(data_2[i], _.merge(data_tmp, {_id: data_2[i]._id}));
							}
						}

						if(isAdding)
							calendar_2.fullCalendar("renderEvent", data_tmp);
						else
							calendar_2.fullCalendar("updateEvent", data_tmp);
					} else {
						calendar_0.fullCalendar("renderEvent", data_tmp);
						calendar_1.fullCalendar("renderEvent", data_tmp);
						calendar_2.fullCalendar("renderEvent", data_tmp);
					}

					calendar_0.fullCalendar("unselect");
					calendar_1.fullCalendar("unselect");
					calendar_2.fullCalendar("unselect");

					$('#CalenderModalNew').modal('hide');
				}
			});
		}

		$(function() {
			$('input[name="daterange"]').daterangepicker({
				//daterangepicker: 'dateRange3',
			//	opens: 'right',
				forceUpdate: true,
			});
		});
	</script>

	<!-- calendar modal -->
	<div
		id="CalenderModalNew"
		class="modal fade"
		tabindex="-1"
		role="dialog"
		aria-labelledby="myModalLabel"
		aria-hidden="true"
	>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">@lang('admin::main.add_update')</h4>
				</div>

				<div class="modal-body">
					<div id="testmodal" style="padding: 5px 20px;">
						<form id="antoform" class="form-horizontal calender" role="form">
							<div class="form-group">
								<label class="col-sm-3 control-label">@lang('admin::plugins.title')</label>

								<div class="col-sm-9">
									<input
										type="text"
										class="form-control"
										id="title"
										name="calendar_title"
										placeholder="@lang('admin::plugins.title')"
									/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">@lang('admin::plugins.date')</label>

								<div class="col-sm-9">
									<input type="text" name="daterange" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">@lang('admin::plugins.description')</label>

								<div class="col-sm-9">
									<textarea
										name="calendar_description"
										placeholder="@lang('admin::plugins.description')"
										class="form-control"
									></textarea>
								</div>
							</div>

							<input type="hidden" name="calendar_id" autocomplete="off" />
						</form>
					</div>
				</div>

				<div class="modal-footer">
					<button id="calendarRowRemove" onclick="removeEvent()" type="button" class="btn btn-danger"
						data-dismiss="modal">
						@lang('admin::main.remove')
					</button>

					<button type="button" class="btn btn-default antoclose" data-dismiss="modal">
						@lang('admin::main.close')
					</button>

					<button type="button" onclick="addingSelectRowModal()" class="btn btn-primary antosubmit">
						@lang('admin::main.save')
					</button>
				</div>
			</div>
		</div>
	</div>

	<div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
	<!-- /calendar modal -->
@endpush
