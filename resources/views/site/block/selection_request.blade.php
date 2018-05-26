<div class="form-request">
	<div class="form">
		<form action="#" id="selection-request-form">
			<div class="form-box">
				<div class="fieldset pickerfields">
					<div class="field">
						<label for="arrivalDate">*@lang('main.check_in')</label>

						<div class="input">
							<input id="arrivalDate" name="arrivalDate" type="text" data-picker-full />
						</div>
					</div>

					<div class="field">
						<label for="departureDate">*@lang('main.check_out')</label>

						<div class="input">
							<input type="text" id="departureDate" name="departureDate" data-picker-full />
						</div>
					</div>

					<div id="picker">
						<div class="calendar">
							<div class="annotation">
								<span class="closed">@lang('main.busy')</span>
								<span class="opened">@lang('main.Свободно')</span>
							</div>
						</div>
					</div>
				</div>

				<div class="fieldset">
					<div class="field">
						<label for="adults">*@lang('main.adults')</label>

						<div class="select">
							<select name="adults" id="adults" style="display:none;" autocomplete="off">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
					</div>

					<div class="field">
						<label for="childUntil12">*@lang('main.children_under_12_years')</label>

						<div class="select">
							<select name="childUntil12" id="childUntil12" style="display:none;" autocomplete="off">
								<option value="-1">@lang('main.no')</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
						</div>
					</div>

					<div class="field">
						<label for="babies">*@lang('main.children_from_0_to_2_years')</label>

						<div class="select">
							<select name="babies" id="babies" style="display:none;" autocomplete="off">
								<option value="-1">@lang('main.no')</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
						</div>
					</div>
				</div>

				<div class="fieldset">
					<div class="field">
						<label for="way">*@lang('main.direction')</label>

						<div class="select">
							<select name="way" id="way" style="display:none;" autocomplete="off">
								<option value="-1">@lang('main.all_destinations')</option>

								@foreach($locations as $val)
									<option value="{{ $val['id'] }}">{{ $langSt($val['name']) }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="fieldset">
					<div class="field">
						<label for="budget">*@lang('main.budget_per_week_euro')</label>
						<div class="input"><input id="budget" name="budget" type="text" /></div>
					</div>
				</div>

				<div class="fieldset">
					<div class="field">
						<label for="name">*@lang('main.your_name')</label>
						<div class="input"><input id="name" name="name" type="text" /></div>
					</div>

					<div class="field">
						<label for="telephone">*@lang('main.phone')</label>
						<div class="input"><input type="text" name="telephone" id="telephone" /></div>
					</div>

					<div class="field">
						<label for="mail">*E-mail</label>
						<div class="input"><input type="text" name="mail" id="mail" /></div>
					</div>
				</div>

				<div class="fieldset">
					<div class="field">
						<label for="wishes">@lang('main.write_your_wishes')</label>
						<div class="input"><input id="wishes" name="wishes" type="text" /></div>
					</div>
				</div>

				<div class="fieldset">
					<div class="field">
						<label for="source">@lang('main.where_did_you_find_out_about_us')</label>
						<div class="input"><input id="source" name="message_t" type="text" /></div>
					</div>
				</div>

				<div class="fieldset">
					<div class="check check_field">
						<label>
							<input type="checkbox" checked id="securityPolicy" name="securityPolicy" />

							<span>
								<a href="/privacy-policy" target="_blank" class="link-black">*@lang('main.security_policy_text')</a>
							</span>
						</label>
					</div>
				</div>

				<p class="asterisk">*@lang('main.required_fields')</p>
				<button class="btn btn_subm" type="submit">@lang('main.send_request')</button>
			</div>
		</form>

		<div class="form-success">
			<span class="close"><svg> <use xlink:href="/images/svg/sprite.svg#ico_close"></use> </svg></span>
			<div class="form-success--main">
				<div class="text">
					<h5 class="success-title">@lang('main.request_was_successfully_sent')</h5>
					<p>{!! $langSt($params['send_request_text']['key']) !!}</p>

					<div class="btn_center">
						<a href="/blog" class="more">@lang('main.read_our_blog')</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@push('footer')
<!--validate-->
<script>
	formsFull.initSelectionRequest();
</script>
@endpush
