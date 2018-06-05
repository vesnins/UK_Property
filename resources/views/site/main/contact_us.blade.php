@extends('site.layouts.default')

@section('content')
  <main class="main">
    <div id="map-canvas"></div>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCO4_qS5tqKWQwDl2-ujJpAn95dHU90GzU&amp;libraries=places&amp;sensor=false"></script>
    <script>
      function initMap() {
        var myLatLng = {lat: 51.5127637, lng: -0.1530711};
        var map      = new google.maps.Map(document.getElementById('map-canvas'), {
          zoom  : 12,
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
          icon    : window.location.origin + '/images/pin.png'
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
              UK Property Advisors Ltd. <br> 71-75 Shelton street <br> London, WC2H 9JQ
            </span>

            <span class="address-info">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#envelope"></use>
              </svg>

              <a href="mailto:info@ukpropadv.com">info@ukpropadv.com</a>
            </span>

            <span class="address-info">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#phone"></use>
              </svg>

              WhatsApp/Viber/Telegram:
              <br />
              <a href="tel:+440-755-310-9657">+44 (0) 755 310 9657</a>
              <br />
              <a href="tel:+440-2086-05-2068">+44 (0) 2086 05 2068</a>
            </span>
          </address>

          <ul class="social-list">
            <li><a href="#">
                <svg>
                  <use xlink:href="/images/svg/sprite.svg#facebook"></use>
                </svg>
              </a></li>
            <li><a href="#">
                <svg>
                  <use xlink:href="/images/svg/sprite.svg#linkedin"></use>
                </svg>
              </a></li>
          </ul>
        </div>
        <div class="form-box">
          <h4>Leave your info and we will contact you soon!</h4>
          <form action="#" class="validate-form">
            <div class="row">
              <div class="col-sm-6">
                <div class="input-holder">
                  <input type="text" name="name" placeholder="First Name *" />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="input-holder">
                  <input type="text" name="surname" placeholder="Second Name *" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="input-holder">
                  <input type="tel" name="phone" placeholder="Phone Number *" />
                </div>
              </div>

              <div class="col-sm-6">
                <div class="input-holder">
                  <input type="email" placeholder="Email" />
                </div>
              </div>
            </div>

            <div class="input-holder">
              <textarea placeholder="Message"></textarea>
            </div>

            <div class="input-holder">
              <label class="checkbox-label"><input type="checkbox" name="checkbox" checked />
                <span>I have read and agree to the
                  <a href="#" target="_blank">Terms&Conditions</a> and <a href="#" target="_blank">
                    Privacy policy
                  </a>.
                </span>
              </label>

              <label class="checkbox-label">
                <input type="checkbox" checked />
                <span>I agree to receive property updates and latest news via email.</span>
              </label>
            </div>

            <div class="text-center">
              <input class="button" type="submit" value="send">
            </div>
          </form>
        </div>
      </div>
      <div class="row flex-row align-row">
        <div class="col-sm-7 col-xs-12">
          <h2>Как нас найти</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing et accusamus et iusto odio dignissimos ducimus, qui
            blanditiis praesentium voluptatum deleniti corrupi? Sed ut perspiciatis, unde omnis iste natus error sit
            voluptatem
            <mark>accusantium doloremque</mark>
            laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae
            dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed
            quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est,.
          </p>
          <p><strong>At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum
              deleniti atque corrupti</strong>. Nemo enim ipsam voluptatem, quia voluptas sit, sed quia consequuntur
            magni dolores eos, qui ratione voluptatem sequi nesciunt, ut labore et dolore magnam aliquam quaerat
            voluptatem.</p>
        </div>
        <div class="col-sm-5 col-xs-12 text-right">
          <img src="/images/content/img_31.jpg" alt="">
        </div>
      </div>
    </div>
  </main>
@endsection
