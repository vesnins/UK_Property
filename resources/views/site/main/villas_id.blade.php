@extends('site.layouts.default')

@section('content')
	@php($path_small = '/images/files/small/')
	@php($img_small = $villa['file'] ? $villa['crop'] ? $path_small . $villa['crop'] : $path_small . $villa['file'] : '')
	@php($path_big = '/images/files/big/')
	@php($img_big = $villa['file'] ? $villa['crop'] ? $path_big . $villa['crop'] : $path_big . $villa['file'] : '')
	@php($is_favorite = array_search($villa['id'], $favorites_id ?? []) !== false ? true : false)

	<section class="simple-page--bg" data-villa-part="photo">
		<div class="intro-figure slider">
			<figure style="background-image: url('{{ $img_big }}')">
				@if(!empty($album))
					<span class="show-gallery"></span>
				@endif
			</figure>

			<a
				style="pointer-events: all"
				href="javascript:void(0)"
				class="villa-like like-button {!! $is_favorite ? 'active' : '' !!}"
				onclick="filVil.addCart('{{ $villa['id'] }}', '{!! $is_favorite ? 'remove' : 'add' !!}')"
			>
				<svg><use xlink:href="/images/svg/sprite.svg#ico_action-like-full"></use></svg>
			</a>
		</div>
	</section>

	<div class="villa-page--wrap">
		<div class="villa-nav">
			<div id="villaNav" class="short-info">
				<div class="content content_md">
					<div class="short-info-data">
						<div class="short-info-attributes">
							<div class="item" data-nav-part="about">
								<h2 class="name">{{ $langSt($villa['name']) }}</h2>
								<div class="place">
									<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_mark"></use> </svg></i>
									<span>{{ $langSt($villa['location_name']) }}</span>
								</div>
							</div>

							<div class="includes">
								@if($villa['bedroom'])
									<span class="bed">
									<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_villa-bed"></use> </svg></i>
									<span>{{ $villa['bedroom'] }}</span>
								</span>
								@endif

								@if($villa['bathroom'])
									<span class="bath">
									<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_villa-bath"></use> </svg></i>
									<span>{{ $villa['bathroom'] }}</span>
								</span>
								@endif

								<span class="sea">
									<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_villa-sea"></use> </svg></i>

									<span>
										@if($villa['sea'] === 1)
											@lang('main.with_access_to_the_beach')
										@elseif($villa['sea'] === 2)
											500 @lang('main.m')
										@elseif($villa['sea'] === 3)
											1 @lang('main.km')
										@elseif($villa['sea'] === 4)
											@lang('main.more_than') 1 @lang('main.km')
										@endif
									</span>
								</span>
							</div>
						</div>

						<div class="short-info-navigate">
							<span class="nav-icon" data-nav-part="photo">
								<i class="ico-photo"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 63 63" fill="currentColor" enable-background="new 0 0 63 63"><path d="m56.728 56.51h-51.27c-3.299 0-5.456-2.467-5.456-5.615v-28.373c0-3.266 2.268-6.03 5.456-6.03h15.16l1.145-5.444c.675-2.707 3.063-4.559 5.82-4.559h7.577c2.757 0 5.146 1.852 5.808 4.505l1.156 5.498h14.611c3.168 0 6.272 2.759 6.272 6.02v28.373c0 3.201-2.939 5.615-6.272 5.615m-51.27-37.01c-1.536 0-2.456 1.413-2.456 3.02v28.373c0 1.515.785 2.614 2.456 2.614h51.27c1.649 0 3.272-1.099 3.272-2.614v-28.373c0-1.611-1.756-3.02-3.272-3.02h-15.829c-.71 0-1.322-.497-1.467-1.191l-1.394-6.636c-.315-1.258-1.507-2.176-2.885-2.176h-7.577c-1.378 0-2.569.918-2.897 2.23l-1.382 6.582c-.146.694-.758 1.191-1.468 1.191h-16.373"/><path d="m30.762 45.981c-5.511 0-9.994-4.485-9.994-9.996 0-5.513 4.483-9.997 9.994-9.997 5.509 0 9.993 4.484 9.993 9.997 0 5.511-4.484 9.996-9.993 9.996m0-16.992c-3.857 0-6.994 3.138-6.994 6.996 0 3.857 3.137 6.995 6.994 6.995 3.856 0 6.993-3.138 6.993-6.995 0-3.858-3.137-6.996-6.993-6.996"/><path d="m30.762 51.34c-8.465 0-15.352-6.889-15.352-15.355 0-8.468 6.887-15.356 15.352-15.356 8.464 0 15.35 6.888 15.35 15.356 0 8.466-6.886 15.355-15.35 15.355m0-27.711c-6.811 0-12.352 5.543-12.352 12.356 0 6.812 5.541 12.354 12.352 12.354 6.81 0 12.35-5.542 12.35-12.354 0-6.813-5.54-12.356-12.35-12.356"/><path d="m17.573 13.494h-8c-.828 0-1.5-.672-1.5-1.5s.672-1.5 1.5-1.5h8c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5"/><path d="m49.43 11.494h.622c2.379 0 3.945 1.881 3.945 4.261v1.741h-8v-1.741c0-2.38 1.054-4.261 3.433-4.261"/></svg></i>
								<span class="tooltip">@lang('main.photo')</span>
							</span>

							<span class="nav-icon" data-nav-part="layout">
								<i class="ico-plan"><svg xmlns="http://www.w3.org/2000/svg" width="190" height="178" viewBox="0 0 3788 3554" shape-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"><path fill="currentColor" d="m3788 935h-1590v-93h-187v280h1590v2245h-1403v-1684h-187v1684h-1824v-2245h1076v-327h-187v140h-889v-748h1824v94h187v-281h-2198v3554h3788z"/></svg></i>
								<span class="tooltip">@lang('main.layout')</span>
							</span>

							<span class="nav-icon" data-nav-part="service">
								<i class="ico-service"><svg enable-background="new 0 0 800 800" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path d="m745.16 695.9h-690.32c-8.875 0-16.08 7.196-16.08 16.08s7.206 16.08 16.08 16.08h690.32c8.885 0 16.08-7.196 16.08-16.08s-7.195-16.08-16.08-16.08"/><path d="m443.41 170.7c9.637-10.499 15.568-24.443 15.568-39.788 0-32.52-26.461-58.973-58.981-58.973-32.52 0-58.973 26.454-58.973 58.973 0 15.344 5.931 29.29 15.56 39.788-183.77 21.572-326.86 178.16-326.86 367.64 0 4.972.18 9.907.377 14.807.341 8.633 7.43 15.452 16.06 15.452h337.76v47.24c0 1.651.323 3.213.79 4.721h-329.86c-8.875 0-16.08 7.196-16.08 16.08 0 8.883 7.206 16.08 16.08 16.08h690.32c8.885 0 16.08-7.197 16.08-16.08 0-8.884-7.195-16.08-16.08-16.08h-329.88c.467-1.508.791-3.069.791-4.721v-47.24h337.76c8.633 0 15.723-6.819 16.06-15.452.197-4.899.387-9.835.387-14.807-.0001-189.48-143.09-346.07-326.87-367.64m-43.41-66.6c14.788 0 26.821 12.02 26.821 26.813s-12.03 26.812-26.821 26.812c-14.788 0-26.813-12.02-26.813-26.812s12.03-26.813 26.813-26.813m-338.12 432.33c1.032-185.57 152.31-336.21 338.12-336.21 185.8 0 337.09 150.65 338.12 336.21h-676.23"/><path d="m361 263.83c-196.7 43.07-223.28 214.1-223.53 215.83-1.256 8.795 4.864 16.941 13.648 18.18.772.127 1.535.162 2.289.162 7.878 0 14.752-5.779 15.9-13.801.216-1.508 23.438-150.59 198.58-188.94 8.668-1.902 14.16-10.481 12.258-19.15-1.886-8.669-10.393-14.179-19.15-12.276"/></g></svg></i>
								<span class="tooltip">@lang('main.facilities_services')</span>
							</span>

							<span class="nav-icon" data-nav-part="map">
								<i class="ico-map">
									<svg enable-background="new 0 0 32 32" viewBox="0 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="m16 27c-.23 0-.461-.079-.648-.238-.242-.206-5.942-5.1-8.32-10.438-.225-.504.002-1.096.507-1.32.503-.224 1.095.002 1.32.507 1.739 3.905 5.577 7.699 7.124 9.13 2.73-2.65 8.02-8.572 8.02-12.411 0-4.538-3.589-8.23-8-8.23s-8 3.692-8 8.23c0 .552-.448 1-1 1s-1-.448-1-1c0-5.641 4.486-10.23 10-10.23 5.514 0 10 4.589 10 10.23 0 5.912-8.944 14.159-9.325 14.508-.191.174-.433.262-.675.262"/><path d="m16 16c-2.206 0-4-1.794-4-4s1.794-4 4-4c2.206 0 4 1.794 4 4s-1.794 4-4 4m0-6c-1.103 0-2 .897-2 2s.897 2 2 2c1.103 0 2-.897 2-2s-.897-2-2-2"/><path d="m29 30h-26c-.356 0-.686-.189-.865-.498-.179-.309-.18-.688-.003-.998l4-7c.274-.479.885-.647 1.364-.372.479.274.646.885.372 1.364l-3.145 5.504h22.553l-3.145-5.504c-.274-.479-.107-1.09.372-1.364.479-.276 1.09-.107 1.364.372l4 7c.177.31.176.689-.003.998-.178.309-.508.498-.864.498"/></svg></i>
								<span class="tooltip">@lang('main.on_the_map')</span>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="content content_md">
			<div class="villa-layout">
				<div class="villa-layout--main">
					<div class="villa-part" data-villa-part="about">
						<div class="text-box">{!! $langSt($villa['text']) !!}</div>

						<div class="cite">
							<i class="key"><svg> <use xlink:href="/images/svg/sprite.svg#ico_cite-key"></use> </svg></i>
							{{ $langSt($villa['key_feature']) }}
							<i class="infinity"><svg> <use xlink:href="/images/svg/sprite.svg#ico_cite-infinity"></use> </svg></i>
						</div>
					</div>

					<section class="villa-part" data-villa-part="layout">
						<header class="sm">
							<h3 class="headline_main">@lang('main.layout')</h3>
						</header>

						<div class="text-box"><p>{{ $langSt($villa['layout']) }}</p></div>
					</section>
					<section class="villa-part" data-villa-part="comforts">
						<header class="sm">
							<h3 class="headline_main">@lang('main.facilities')</h3>
						</header>

						<div class="text-box">
							<ul class="column">
								@php($convenience = explode("\r", $langSt($villa['convenience'])))

								@foreach($convenience as $v)
									@if(!empty($v))<li>{{ $v }}</li>@endif
								@endforeach
							</ul>
						</div>
					</section>

					<section class="villa-part" data-villa-part="service">
						<header class="sm">
							<h3 class="headline_main">@lang('main.services')</h3>
						</header>

						<div class="text-box">
							<ul class="column">
								@php($services = explode("\r", $langSt($villa['services'])))

								@foreach($services as $v)
									@if(!empty($v))<li>{{ $v }}</li>@endif
								@endforeach
							</ul>
						</div>
					</section>
				</div>

				<div class="villa-layout--side">
					<div class="villa-request">
						<div class="price">
							@lang('main.from_')
							{!! number_format($villa['price_money'], 0, ',', ' ') !!}
							&nbsp;
							<strong>&euro;</strong>
						</div>

						<div class="villa-request-form">
							<input type="radio" id="showVillaForm" />

							<form action="#" id="villa-request-form">
								<div class="fields-part">
									<div class="fieldset pickerfields">
										<div class="field">
											<label for="arrivalDate_v">@lang('main.check_in')</label>
											<div class="input">
												<input id="arrivalDate_v" name="arrivalDate" type="text" data-picker-full />
											</div>
										</div>

										<div class="field">
											<label for="departureDate_v">@lang('main.check_out')</label>
											<div class="input">
												<input type="text" id="departureDate_v" name="departureDate" data-picker-full />
											</div>
										</div>

										<div id="picker">
											<div class="calendar">
												<div class="annotation">
													<span class="closed">@lang('main.busy')</span>
													<span class="opened">@lang('main.free')</span>
												</div>
											</div>
										</div>
									</div>

									<div class="fieldset">
										<div class="field field-select">
											<label for="guests">@lang('main.guests')</label>

											<div class="select">
												<select name="guests" id="guests">
													<option value=""></option>
													<option value="-1">@lang('main.no')</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
												</select>
											</div>
										</div>

										<div class="field field-select">
											<label for="children">@lang('main.children')</label>

											<div class="select">
												<select name="children" id="children">
													<option value=""></option>
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
											<label for="mail">@lang('main.your_e_mail')</label>
											<div class="input"><input type="text" id="mail" name="mail" /></div>
										</div>
									</div>

									<div class="fieldset">
										<div class="field">
											<label for="wishes">@lang('main.your_wishes')</label>
											<div class="input"><input id="wishes" name="message" type="text" /></div>
										</div>
									</div>

									<div class="fieldset">
										<div class="check check_field">
											<label>
												<input type="checkbox" checked id="securityPolicy" name="securityPolicy" />

												<span>
													<a href="/privacy-policy" target="_blank" class="link">*@lang('main.security_policy_text')</a>
												</span>
											</label>
										</div>
									</div>
								</div>

								<div class="submit-part">
									<div class="submit-btn">
										<label for="showVillaForm"></label>
										<button class="btn btn_subm" type="submit">@lang('main.reservation')</button>
									</div>

									<div class="submit-actions">
										<a
											href="javascript:void(0)"
											class="like like-button {!! $is_favorite ? 'active' : '' !!}"
											onclick="filVil.addCart('{{ $villa['id'] }}', '{!! $is_favorite ? 'remove' : 'add' !!}')"
										>
											<svg><use xlink:href="/images/svg/sprite.svg#ico_action-like"></use></svg>
										</a>

										<a href="javascript:void(0);" class="send show-modal" data-modal="friend-form">
											<svg>
												<use xlink:href="/images/svg/sprite.svg#ico_action-write"></use>
											</svg>
										</a>
									</div>
								</div>
							</form>
						</div>

						<div class="form-success" style="width: 100%;">
							<div class="form-success--main">
								<div class="text">
									<h5 class="success-title">@lang('main.request_was_successfully_sent')</h5>
									<p>@lang('main.villa_request_success')</p>

									<div class="btn_center">
										<a href="/blog" class="more">@lang('main.read_our_blog')</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@include('site.block.favorite_modal')

		@if(!empty($villa['specialist']) && !empty($villa['specialist_comment']))
			@php($path_original = '/images/files/original/')

			@php($img_original_user = $villa['specialist']['file']
			? $villa['specialist']['crop']
				? $path_original . $villa['specialist']['crop']
				: $path_original . $villa['specialist']['file']
			: '')

			<div class="experts">
				<div class="content">
					<div class="experts-box">
						<div class="content content_md">
							<div class="worker">
								<div class="worker-img">
									<figure>
										<img src="{!! $img_original_user !!}" alt="{{ $langSt($villa['specialist']['name']) }}" />
									</figure>

									<h4 class="name">@lang('main.expert_opinion')</h4>
								</div>

								<div class="worker-descr">
									<div class="quote">
										<p>{{ $langSt($villa['specialist_comment']) }}</p>
									</div>

									<h6 class="position">
										{{ $langSt($villa['specialist']['name']) }}
										{{ ', ' .$langSt($villa['specialist']['text']) }}
									</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif

		<section class="showplaces" data-villa-part="map">
			<div class="content content_md">
				<header class="sm">
					<h3 class="headline_main">@lang('main.distances_and_location')</h3>
					<h4 class="headline_submain">{{ $langSt($params['distances_and_location_villa_h3']['key']) }}</h4>
				</header>

				<div class="showplaces-list">
					@php($distances = $langSt($villa['distances']))

					@foreach($distances['distances'] ?? [] as $key => $v)
						@if(!empty($v))
							<dl>
								<dt><span>{{ $v }}</span></dt>
								<dd>{{ $distances['location'][$key] }}</dd>
							</dl>
						@endif
					@endforeach
				</div>
			</div>
		</section>

		<div class="villa-map">
			<div class="content">
				<div class="villa-map--wrap">
					<div id="place" class="map-box"></div>

					<div class="place-description">
						<figure style="background-image: url('{{ $img_small }}')"></figure>

						@if($langSt($villa['location_name']))
							<div class="text">
								<h4 class="title">{{ $langSt($villa['location_name']) }}</h4>
								<p>{{ $langSt($villa['location_description']) }}</p>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="simple-page--main">
		<section class="section nearests">
			<div class="">
				<header>
					<h3 class="headline_main">@lang('main.what_is_nearby')</h3>
					<h4 class="headline_submain">{{ $langSt($params['what_is_nearby_villa_h3']['key']) }}</h4>
				</header>

				<div class="places bg-grey">
					<ul class="places-list owl-carousel">
						@foreach($album_what_is_next as $v)
							@php($path_small = '/images/files/small/')
							@php($img_small = $v['file'] ? $v['crop'] ? $path_small . $v['crop'] : $path_small . $v['file'] : '')

							<li>
								<a href="javascript:void(0)">
									<figure style="background-image: url('{{ $img_small }}')"></figure>

									<div class="text">
										<h3 class="title">{{ $langSt($v['name']) }}</h3>
										<p>{{ $langSt($v['text']) }}</p>
									</div>
								</a>
							</li>
						@endforeach
					</ul>
				</div>

				<div class="content">
					<div class="btns_center">
						<a href="/villas{{ $full_url }}" class="more">
							<i class="ico-back"><svg><use xlink:href="/images/svg/sprite.svg#ico_arrow-left-long"></use></svg></i>
							<span>@lang('main.back_to_the_list_of_villas')</span>
						</a>

						<a
							href="javascript:void(0)"
							class="more {!! $is_favorite ? 'active' : '' !!}"
							onclick="filVil.addCart('{{ $villa['id'] }}', '{!! $is_favorite ? 'remove' : 'add' !!}')"
						>
							<i class="ico-like"><svg> <use xlink:href="/images/svg/sprite.svg#ico_action-like-full"></use> </svg></i>
							<span>@lang('main.add_to_favorites')</span>
						</a>

						@if($villa['document'])
							@php($path_document = "/images/files/original/")
							@php($path_img = "/images/files/original/")

							@if(file_exists($path_document . $villa['file']))
								@php($document = $path_document . $villa['file'])
							@else
								@php($document = $path_img . $villa['file'])
							@endif

							<a href="{{ $document }}" title="{{ $langSt($v['name']) }}" class="more" target="_blank">
								@lang('main.download_villa_presentation')
							</a>
						@endif
					</div>
				</div>
		</div>
	</section>

	@if(count($recommended_villas))
		<section class="section best-offers">
			<div class="content">
				<header>
					<h3 class="headline_main">@lang('main.you_may_also_like')</h3>
					<h4 class="headline_submain">{{ $langSt($params['you_may_also_like_villa_h3']['key']) }}</h4>
				</header>

				<div class="grid">
					<ul class="grid-list">
						@include('site.block.villas_main_list_grid', ['villas' => $recommended_villas])
					</ul>
				</div>
			</div>
		</section>
	@endif
</div>

@push('footer')
<!--validate-->
<script>
	formsFull.initVillaRequestForm('{{ $villa['id'] }}');
</script>

@php($coordinates = explode(',', $villa['coordinates']))

@if(count($coordinates) > 1)
	<script type="text/javascript">
		var
			month_num = 2;

		if($('html').hasClass('tablet') && $(window).width() < 767)
			month_num = 1;

		function datePickerVilla() {
			var
				dateToday = new Date(),
				el01      = 'arrivalDate_v',
				el02      = 'departureDate_v',
				basePicker;

			var
				dates = $('#' + el01 + ',#' + el02).datepicker({
					changeMonth   : true,
					changeYear    : true,
					numberOfMonths: month_num,
					minDate       : dateToday,

					beforeShowDay: function(d) {
						var
							disabledDates = [
								@foreach($order_days as $day)
									"{{ $day }}",
								@endforeach
							],

							dmy;

						dmy = d.getFullYear() + "-";

						if(d.getMonth() < 9) dmy += "0";
						dmy += (d.getMonth() + 1) + "-";

						if(d.getDate() < 10) dmy += "0";
						dmy += d.getDate();

						if($.inArray(dmy, disabledDates) === -1)
							return [true, "", "Available"];
						else
							return [false, "", "unAvailable"];
					},

					beforeShow: function() {
						month_num > 1 ? basePicker = $('#picker') : basePicker = $('#mobile_picker')

						var
							picker       = basePicker,
							pickerOffset = picker.offset().top,
							scrollTop    = $(window).scrollTop(),
							needScroll   = pickerOffset - 350;

						if(scrollTop > needScroll) {
							picker.addClass('down');
						} else {
							picker.addClass('up');
						}

						picker.addClass('show');
						picker.find('.calendar').prepend($('#ui-datepicker-div'));

						if($('.villa-request').length > 0) {
							$('.villa-request .pickerfields .input').addClass('filled')
						}

						setTimeout(function(args) {
							$('#' + el01 + ',#' + el02).blur();
						}, 50)
					},

					onClose: function() {
						basePicker.removeClass('show up down');
						if($('.villa-request').length > 0) {
							if($("#arrivalDate").val() == '' && $("#departureDate").val() == '') {
								$('.villa-request .pickerfields .input').removeClass('filled')
							}
						}
					},

					onSelect: function(selectedDate) {
						var
							option   = this.id == el01 ? "minDate" : "maxDate",
							instance = $(this).data("datepicker"),
							date     = $.datepicker.parseDate(
								instance.settings.dateFormat || $.datepicker._defaults.dateFormat,
								selectedDate, instance.settings
							);

						dates.not(this).datepicker("option", option, date);

						if($('#' + el01).val() != '') {
							$('#' + el01).closest('.field').removeClass('invalid')
						}

						if($('#' + el02).val() != '') {
							$('#' + el02).closest('.field').removeClass('invalid')
						}
					}
				});

			var
				currentDate,
				nextDate;

			if($('#check_in').val() && $('#check_out').val()) {
				currentDate = $.datepicker.parseDate('dd.mm.yy', $('#check_in').val());
				nextDate    = $.datepicker.parseDate('dd.mm.yy', $('#check_out').val())
			}

			$('#' + el01).datepicker('setDate', currentDate || 'today');
			$('#' + el02).datepicker('setDate', nextDate || '+1w');
		}

		function initMap() {
			new google.maps.Marker({
				position: {lat: parseFloat('{{ $coordinates[0] }}'), lng: parseFloat('{{ $coordinates[1] }}')},

				map: new google.maps.Map(document.getElementById('place'), {
					zoom       : 12,
					scrollwheel: false,
					center     : new google.maps.LatLng(parseFloat('{{ $coordinates[0] }}'), parseFloat('{{ $coordinates[1] }}'))
				}),

				icon: '/images/villa-mark.png'
			});
		}

		$(document).ready(function() {
			datePickerVilla();
		})
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6PFq1z3G7_YGiZl1KUuVVH_kxI2YAdaA&callback=initMap"></script>
@endif

@if(!empty($album))
	<div class="villa-gallery">
		<div class="royalSlider">
			@foreach($album as $v)
				@php($img_big = $v['file'] ? $v['crop'] ? $path_big . $v['crop'] : $path_big . $v['file'] : '')

				<div class="rsContent">
					<div class="tableBox">
						<div>
							<div>
								<img src="{{ $img_big }}" class="rsImg rsMainSlideImage" width="1230" height="770" alt="img" />
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>

		<span class="close">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 7" enable-background="new 0 0 7 7"><g fill="none" stroke="#fff" stroke-width=".24" stroke-miterlimit="22.926"><path d="m.72 6.279l5.76-5.759"/><path d="M 6.479,6.279 0.72,0.52"/></g></svg>
		</span>
	</div>
@endif
@endpush
@endsection