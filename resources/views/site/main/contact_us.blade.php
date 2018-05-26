@extends('site.layouts.default')

@section('content')
	<div class="map-container">
		<div class="contact-form">
			<div class="contacts">
				<h3 class="title">@lang('main.contacts')</h3>

				<ul>
					<li>
						<i class="ico-tel"><svg><use xlink:href="/images/svg/sprite.svg#ico_contact-tel"></use></svg></i>

						<a href="tel:{{ $langSt($params['phone_footer']['key']) }}">
							{{ $langSt($params['phone_footer']['key']) }}
						</a>
					</li>

					<li>
						<i class="ico-fly"><svg><use xlink:href="/images/svg/sprite.svg#ico_contact-fly"></use></svg></i>
						<a href="mailto:{{ $langSt($params['email']['key']) }}">{{ $langSt($params['email']['key']) }}</a>
					</li>

					<li>
						<i class="ico-adr"><svg><use xlink:href="/images/svg/sprite.svg#ico_contact-address"></use></svg></i>
						<span>{{ $langSt($params['footer_address']['key']) }}</span>
					</li>

					<li>
						<i class="ico-mes"><svg><use xlink:href="/images/svg/sprite.svg#ico_contact-messenger"></use></svg></i>
						<span>{!! $langSt($params['official_accounts']['key']) !!}</span>
					</li>
				</ul>
			</div>

			<div class="contact-form-box">
				<form action="#" id="contact-us-form">
					<div class="fields">
						<div class="fieldset">
							<div class="field">
								<div class="input">
									<input id="name" name="name" type="text" placeholder="@lang('main.your_name')" />
								</div>
							</div>

							<div class="field">
								<div class="input">
									<input type="text" name="mail" id="mail" placeholder="*@lang('main.e_mail')" />
								</div>
							</div>

							<div class="field">
								<div class="input">
									<input type="text" id="telephone" name="telephone" placeholder="@lang('main.phone')" />
								</div>
							</div>
						</div>

						<div class="fieldset">
							<div class="field">
								<div class="input">
									<textarea
										id="message_form"
										name="message_form"
										rows="3"
										placeholder="@lang('main.message')"></textarea>
								</div>
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
					</div>

					<div class="btn-box">
						<button type="submit">
							<i><svg><use xlink:href="/images/svg/sprite.svg#ico_submit"></use></svg></i>
						</button>
					</div>
				</form>

				<div class="form-success" style="width: 100%;">
					<span class="close"><svg> <use xlink:href="/images/svg/sprite.svg#ico_close"></use> </svg></span>
					<div class="form-success--main">
						<div class="text">
							<h5 class="success-title">@lang('main.request_was_successfully_sent')</h5>

							<div class="btn_center">
								<a href="/blog" class="more">@lang('main.read_our_blog')</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="map" class="map-box"></div>
	</div>

	@push('footer')
	<script type="text/javascript">
		var map;
		function initMap() {

			var icon = './images/map-mark.png';

			var mapOptions = {
				zoom: 13,
				styles: [{ "featureType": "water", "elementType": "geometry", "stylers": [{ "color": "#e9e9e9"}, { "lightness": 17}]}, { "featureType": "landscape", "elementType": "geometry", "stylers": [{ "color": "#f5f5f5"}, { "lightness": 20}]}, { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{ "color": "#ffffff"}, { "lightness": 17}]}, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{ "color": "#ffffff"}, { "lightness": 29}, { "weight": 0.2}]}, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [{ "color": "#ffffff"}, { "lightness": 18}]}, { "featureType": "road.local", "elementType": "geometry", "stylers": [{ "color": "#ffffff"}, { "lightness": 16}]}, { "featureType": "poi", "elementType": "geometry", "stylers": [{ "color": "#f5f5f5"}, { "lightness": 21}]}, { "featureType": "poi.park", "elementType": "geometry", "stylers": [{ "color": "#dedede"}, { "lightness": 21}]}, { "elementType": "labels.text.stroke", "stylers": [{ "visibility": "on"}, { "color": "#ffffff"}, { "lightness": 16}]}, { "elementType": "labels.text.fill", "stylers": [{ "saturation": 36}, { "color": "#333333"}, { "lightness": 40}]}, { "elementType": "labels.icon", "stylers": [{ "visibility": "off"}]}, { "featureType": "transit", "elementType": "geometry", "stylers": [{ "color": "#f2f2f2"}, { "lightness": 19}]}, { "featureType": "administrative", "elementType": "geometry.fill", "stylers": [{ "color": "#fefefe"}, { "lightness": 20}]}, { "featureType": "administrative", "elementType": "geometry.stroke", "stylers": [{ "color": "#fefefe"}, { "lightness": 17}, { "weight": 1.2}]}],
				scrollwheel: false,
				center: new google.maps.LatLng(35.318354, 25.196429)
			};
			map = new google.maps.Map(document.getElementById('map'), mapOptions );

			var marker = new google.maps.Marker({
				position: {lat: 35.318354, lng: 25.196429},
				map: map,
				icon: icon
			});
		}
	</script>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6PFq1z3G7_YGiZl1KUuVVH_kxI2YAdaA&callback=initMap"></script>

	<!--validate-->
	<script>
		formsFull.initContactUs();
	</script>
	@endpush
@endsection
