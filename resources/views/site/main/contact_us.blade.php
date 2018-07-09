@extends('site.layouts.default')

@section('content')
  @php($path_big = '/images/files/big/')

  <main class="main">
    <div id="map-canvas"></div>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCO4_qS5tqKWQwDl2-ujJpAn95dHU90GzU&amp;libraries=places&amp;sensor=false&language={{ $lang }}"></script>
    <script>
      function initMap() {
        var myLatLng = {lat: 51.514981, lng: -0.123565};
        var map      = new google.maps.Map(document.getElementById('map-canvas'), {
          zoom  : 18,
          center: myLatLng,

          styles: [
            {"featureType": "road", "stylers": [{"hue": "#5e00ff"}, {"saturation": -79}]},

            {
              "featureType": "poi",

              "stylers": [
                {"saturation": -78},
                {"hue": "#6600ff"},
                {"lightness": -47},
                {"visibility": "off"}
              ]
            },

            {"featureType": "road.local", "stylers": [{"lightness": 22}]},
            {"featureType": "landscape", "stylers": [{"hue": "#6600ff"}, {"saturation": -11}]},
            {},
            {},
            {"featureType": "water", "stylers": [{"saturation": -65}, {"hue": "#1900ff"}, {"lightness": 8}]},
            {"featureType": "road.local", "stylers": [{"weight": 1.3}, {"lightness": 30}]},

            {
              "featureType": "transit",
              "stylers"    : [{"visibility": "simplified"}, {"hue": "#5e00ff"}, {"saturation": -16}]
            },

            {"featureType": "transit.line", "stylers": [{"saturation": -72}]},
            {}
          ]
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map     : map,
        //  icon    : window.location.origin + '/images/pin(old).png',

          icon    : {
            url:  window.location.origin + '/images/pin(old).png',
            scaledSize: new google.maps.Size(35, 49), // scaled size
            origin: new google.maps.Point(0, 0), // origin
            anchor: new google.maps.Point(17, 24) // anchor
          },
        });
      }

      initMap();
    </script>

    <div class="container contact-area">
      <h1>@lang('main.contacts_us')</h1>

      <div class="contact-info flex-row">
        <div class="info-box">
          <address>
            <span class="address-info">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#pin"></use>
              </svg>
              {!! $langSt($params['address_by_footer']['key']) !!}
            </span>

            <span class="address-info">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#envelope"></use>
              </svg>

              <a href="mailto:{!! $langSt($params['email_by_footer']['key']) !!}">
                {!! $langSt($params['email_by_footer']['key']) !!}
              </a>
            </span>

            <span class="address-info">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#phone"></use>
              </svg>

              WhatsApp/Viber:
              <br />

              <a href="tel:{!! $langSt($params['soc_phone_by_footer_1']['key']) !!}">
                {!! $langSt($params['soc_phone_by_footer_1']['key']) !!}
              </a>

              @if(empty($langSt($params['soc_phone_by_footer_2']['key'])))
                <br />
                <a href="tel:{!! $langSt($params['soc_phone_by_footer_2']['key']) !!}">
                  {!! $langSt($params['soc_phone_by_footer_2']['key']) !!}
                </a>
              @endif

              @lang('main.office'):
              <br />

              <a href="tel:{!! $langSt($params['soc_phone_by_footer_2']['key']) !!}">
                {!! $langSt($params['soc_phone_by_footer_3']['key']) !!}
              </a>
            </span>
          </address>

          <ul class="social-list">
            <li>
              <a href="{!! $langSt($params['link_on_facebook']['key']) !!}" target="_blank">
                <svg>
                  <use xlink:href="/images/svg/sprite.svg#facebook"></use>
                </svg>
              </a>
            </li>

            <li>
              <a href="{!! $langSt($params['link_on_linkedin']['key']) !!}" target="_blank">
                <svg>
                  <use xlink:href="/images/svg/sprite.svg#linkedin"></use>
                </svg>
              </a>
            </li>
          </ul>
        </div>

        <div class="form-box">
          <h4>@lang('main.contact_us_text_form')</h4>

          <form action="#" class="validate-form">
            <div class="row">
              <div class="col-sm-6">
                <div class="input-holder">
                  <input type="text" name="first_name" placeholder="@lang('main.first_name') *" />
                </div>
              </div>

              <div class="col-sm-6">
                <div class="input-holder">
                  <input type="text" name="second_name" placeholder="@lang('main.second_name') *" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="input-holder">
                  <input type="tel" name="phone_number" placeholder="@lang('main.phone_number') *" />
                </div>
              </div>

              <div class="col-sm-6">
                <div class="input-holder">
                  <input type="email" name="email" placeholder="Email" />
                </div>
              </div>
            </div>

            <div class="input-holder">
              <textarea name="message_text" placeholder="@lang('main.message')"></textarea>
            </div>

            <div class="input-holder">
              <label class="checkbox-label"><input type="checkbox" name="checkbox" checked />
                <span>
                  @lang('main.i_have_read_and_agree_to_the')
                  <a href="/terms-conditions" name="terms_conditions" target="_blank">
                    @lang('main._terms_&_Conditions_')
                  </a>
                  @lang('main._and_')
                  <a href="/privacy-cookies" target="_blank">@lang('main._privacy_policy_')</a>.
                </span>
              </label>

              <label class="checkbox-label">
                <input type="checkbox" name="news_updates" checked />
                <span>@lang('main.text_mail_sending')</span>
              </label>
            </div>

            <div class="text-center">
              <input type="hidden" name="current_url" value="{{ \URL::full() }}" />
              <input type="hidden" name="type" value="contact_form" />
              <input class="button" type="submit" value="@lang('main.send')" />
            </div>

            <div class="success-message">
              <div class="flex-container">
                <div class="align-box">
                  <h4 class="text-center">{!! $langSt($params['consultation_form_title']['key']) !!}</h4>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      @php($img = $page['file']
        ? $page['crop'] ? $path_big . $page['crop'] : $path_big . $page['file']
        : env('PATH_TO_IMG_DEFAULT')
      )

      <div class="row flex-row align-row text-justify">
        <div class="col-sm-7 col-xs-12">{!! $langSt($page['text']) !!}</div>
        <div class="col-sm-5 col-xs-12 text-right"><img src="{{ $img }}" /></div>
      </div>
    </div>
  </main>

  @push('footer')
    <script>
      $(document).ready(function() {
        catAll.initialize({
          container  : '.sys-sel-catalog',
          num        : '.selReN > .i',
          pagination : false,
          isLoad     : false,
          isPortfolio: false,
          url_req    : '/',
        });
      });

      $('#header').addClass('static');
    </script>
  @endpush
@endsection
