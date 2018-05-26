<div class="content content_md">
	<div class="fast-request">
		<form action="/villas">
			<div class="fast-request--wrap">
				<div class="fieldgroup">
					<div id="fastpicker">
						<div class="calendar">
							<div class="annotation">
								<span class="closed">@lang('main.busy')</span>
								<span class="opened">@lang('main.free')</span>
							</div>
						</div>
					</div>

					<div class="field f-100 col-30">
						<label for="f_way">@lang('main.location')</label>

						<div class="select">
							<select name="f_way" id="f_way" style="display:none;">
								@if(isset($all_destinations) ? $all_destinations : true)
									<option value="">@lang('main.all_destinations')</option>
								@endif

								@foreach($locations as $val)
									<option value="{{ $val['cat'] }}" {{ ($_GET['f_way'] ?? '') == $val['cat'] ? 'selected' : '' }}>
										{{ $langSt($val['name']) }}
									</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="field f-50">
						<label for="check_in">@lang('main.check_in')</label>

						<div
							class="input">
							<input
								id="check_in"
								name="date_to"
								type="text"
								data-picker-fast
								value="{{ $_GET['date_to'] ?? '' }}"
								autocomplete="off"
							/></div>
					</div>

					<div class="field f-50">
						<label for="check_out">@lang('main.check_out')</label>

						<div class="input">
							<input
								type="text"
								name="date_from"
								id="check_out"
								data-picker-fast
								value="{{ $_GET['date_from'] ?? '' }}"
								autocomplete="off"
							/>
						</div>
					</div>

					<div class="field f-50 col-10">
						<label for="guests_person">@lang('main.guests_person')</label>

						<div class="select">
							<select name="guests_person" id="guests_person" style="display:none;">
								<option value="-1" {{ ($_GET['guests_person'] ?? '') === '-1' ? 'selected' : '' }}>-</option>
								<option value="1" {{ ($_GET['guests_person'] ?? '') === '1' ? 'selected' : '' }}>1</option>
								<option value="2" {{ ($_GET['guests_person'] ?? '') === '2' ? 'selected' : '' }}>2</option>
								<option value="3" {{ ($_GET['guests_person'] ?? '') === '3' ? 'selected' : '' }}>3</option>
								<option value="4" {{ ($_GET['guests_person'] ?? '') === '4' ? 'selected' : '' }}>4</option>
								<option value="5" {{ ($_GET['guests_person'] ?? '') === '5' ? 'selected' : '' }}>5</option>
								<option value="6" {{ ($_GET['guests_person'] ?? '') === '6' ? 'selected' : '' }}>6</option>
								<option value="7" {{ ($_GET['guests_person'] ?? '') === '7' ? 'selected' : '' }}>7</option>
								<option value="8" {{ ($_GET['guests_person'] ?? '') === '8' ? 'selected' : '' }}>8</option>
								<option value="9" {{ ($_GET['guests_person'] ?? '') === '9' ? 'selected' : '' }}>9</option>
								<option value="10" {{ ($_GET['guests_person'] ?? '') === '10' ? 'selected' : '' }}>10</option>
							</select>
						</div>
					</div>

					<div class="field f-50">
						<div class="check">
							<label>
								<input type="checkbox" name="hot" {{ str_replace('-1', 0, $_GET['hot'] ?? '') ? 'checked' : '' }} />
								<span>@lang('main.hot_offers')</span>
							</label>
						</div>
					</div>
				</div>

				<button class="btn btn_subm" name="search-filter" type="submit">@lang('main.search')</button>
			</div>
		</form>
	</div>
</div>

@push('footer')
	<script>
		$('.fast-request form').validate({
			onfocusout: false,
			ignore    : ".ignore",

			rules: {
				location     : {required: true},
				check_in     : {required: true},
				check_out    : {required: true},
				guests_person: {required: true}
			},

			messages: {
				location     : {required: ""},
				check_in     : {required: ""},
				check_out    : {required: ""},
				guests_person: {required: ""}
			},

			errorClass: 'invalid',

			highlight: function(element, errorClass) {
				$(element).closest('.field').addClass(errorClass)
			},

			unhighlight: function(element, errorClass) {
				$(element).closest('.field').removeClass(errorClass)
			},

			errorPlacement: $.noop,

			//		submitHandler: function(form) {
			////			if(form.valid())
			////				form.submit();
			//
			//			return false
			//		}
		});
	</script>
@endpush
