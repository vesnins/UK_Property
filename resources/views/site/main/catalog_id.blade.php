@extends('site.layouts.default')

@section('content')
  @php($path_small = '/images/files/small/')
  @php($path_big = '/images/files/big/')
  @php($is_favorite = array_search($page['id'], $favorites_id ?? []) !== false ? true : false)

  <main class="main">
    <div
      class="container-fluid product-section {{ $page['in_portfolio'] ? 'sold-product' : '' }}"
      data-sticky-container
    >
      <header class="heading">
        <h1 class="product-title">{{ $langSt($page['name']) }}</h1>

        <address>
          <span class="address-info">
            <svg>
              <use xlink:href="/images/svg/sprite.svg#pin-full"></use>
            </svg>

            {{ $langSt($page['full_address']) }}
          </span>
        </address>
      </header>

      <ul class="view-switcher tab-navigation-list">
        @if(!empty($photos))
          <li data-class="tab_1" data-type="gallery" class="active"><a href="#">@lang('main.photos')</a></li>
        @endif

        @if(count(explode(',', $page['coordinates'])) === 2)
          <li data-class="tab_2" data-type="map" class="{{empty($photos) ? 'active' : '' }}">
            <a href="#">@lang('main.map')</a>
          </li>
        @endif

        @if(!empty($plan))
          <li data-class="tab_3" data-type="plan"><a href="#">@lang('main.plan')</a></li>
        @endif
      </ul>

      <div class="product-info tab-holder">
        <div class="tab-content">
          @if(!empty($photos))
            <div class="tab-item tab-item-tab_1 active">
              <div class="product-gallery">
                <a
                  href="javascript:void(0)"
                  class="add-to-wishList like-button {!! $is_favorite ? 'active' : '' !!} like-button-{{ $page['id'] }}"

                  onclick="catAll.addCart(
                    '{{ $page['id'] }}',
                    '{!! $is_favorite ? 'remove' : 'add' !!}',
                    '{{ $name_url ?? $url[$page['name_table']] }}'
                    )"
                >
                  <svg>
                    <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
                  </svg>
                </a>

                <div class="image-slider">
                  @foreach($photos as $photo)
                    @php($img = $photo['file']
                      ? $photo['crop'] ? $path_big . $photo['crop'] : $path_big . $photo['file']
                      : '/images/files/no-image.jpg'
                    )

                    <div>
                      <div class="inner-box" style="background-image: url('{{ $img }}')"></div>
                    </div>
                  @endforeach
                </div>

                <div class="preview-slider simple-slider">
                  @foreach($photos as $photo_small)
                    @php($img_small = $photo['file']
                      ? $photo_small['crop'] ? $path_small . $photo_small['crop'] : $path_small . $photo_small['file']
                      : '/images/files/no-image.jpg'
                    )

                    <div>
                      <div class="inner-box" style="background-image: url('{{ $img_small }}')"></div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          @endif

          @if(count(explode(',', $page['coordinates'])) === 2)
            <div class="tab-item tab-item-tab_2 {{empty($photos) ? 'active' : '' }}">
              <div id="map" style="height: 720px; width: 100%"></div>

              <script type="text/javascript">
                var map;

                function initMap() {
                  var mapOptions = {
                    zoom  : 17,

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
                    ],
                    scrollwheel: false,
                    center     : new google.maps.LatLng({{ explode(',', $page['coordinates'])[0] ?? 0 }}, {{ explode(',', $page['coordinates'])[1] ?? 0 }})
                  };
                  map            = new google.maps.Map(document.getElementById('map'), mapOptions);

                  var marker = new google.maps.Marker({
                    position: {lat: {{ explode(',', $page['coordinates'])[0] ?? 0 }}, lng: {{ explode(',', $page['coordinates'])[1] ?? 0 }}},
                    map     : map,

                    icon    : {
                      url:  window.location.origin + '/images/pin.png',
                      scaledSize: new google.maps.Size(60, 66), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0) // anchor
                    },
                  });
                }
              </script>

              <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6PFq1z3G7_YGiZl1KUuVVH_kxI2YAdaA&callback=initMap&language={{ $lang }}"></script>
            </div>
          @endif

          @if(!empty($plan))
            <div class="tab-item tab-item-tab_3">
              <div class="product-gallery plan-image-slider">
                <div class="image-slider">
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.1.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.2.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.1.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.2.jpg')"></div>
                  </div>
                </div>
                <div class="preview-slider simple-slider">
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.1.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.2.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.1.jpg')"></div>
                  </div>
                  <div>
                    <div class="inner-box" style="background-image: url('/images/content/img_24.2.jpg')"></div>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>

        <div class="product-description">
          <table class="characteristics">
            <tr>
              <td>
                <span class="caption">@lang('main.asking_price')</span>

                <span class="value {{ $page['in_portfolio'] ? 'price-value' : '' }}">
                  @if($page['price_money_from'] ?? false)
                    £{{ number_format($page['price_money_from'], 0, ',', ',') }}
                    -
                    £{{ number_format($page['price_money_to'], 0, ',', ',') }}
                  @else
                    £{{ number_format($page['price_money'], 0, ',', ',') }}
                  @endif
                </span>
              </td>

              <td>
                <span class="caption">@lang('main.number_of_bedrooms')</span>

                <span class="value">
                  @if($page['bedrooms_from'] ?? false)
                    {{ $page['bedrooms_from'] }} - {{ $page['bedrooms_to'] }}
                  @else
                    {{ $page['bedrooms'] }}
                  @endif
                </span>
              </td>

              <td>
                <span class="caption">
                  @lang('main.area_in_ft')
                  <sup>2</sup>
                </span>

                <span class="value">
                  @if($page['area_from'] ?? false)
                    {{ round($page['area_from'] * 3.28, 0) }} - {{ round($page['area_to'] * 3.28, 0) }}
                  @else
                    {{ round($page['area'] * 3.28, 0) }}
                  @endif
                </span>
              </td>

              <td>
                <span class="caption">
                  @lang('main.area_in_m')
                  <sup>2</sup>
                </span>

                <span class="value">
                  @if($page['area_from'] ?? false)
                    {{ $page['area_from'] }} - {{ $page['area_to'] }}
                  @else
                    {{ $page['area'] }}
                  @endif
                </span>
              </td>
            </tr>
          </table>

          <div class="row" data-sticky-container>
            <div class="col-lg-8">{!! $langSt($page['text']) !!}</div>

            <div class="col-lg-4">
              <table
                class="data-table"
                data-sticky
                data-sticky-class="sticky"
                data-sticky-for="1200"
                data-margin-top="100"
              >
                @if(!empty($params_cat_location))
                  <tr>
                    <td>@lang('main.district_of_the_city')</td>
                    <td>{{ $langSt($params_cat_location['name']) }}</td>
                  </tr>
                @endif

                @if(!empty($params_type_object))
                  <tr>
                    <td>@lang('main.object_type')</td>

                    <td>
                      @php($st = [])

                      @foreach($params_type_object as $type_object)
                        @php($st[] = $langSt($type_object['name']))
                      @endforeach

                      {{ join($st, ', ') }}
                    </td>
                  </tr>
                @endif

                @if(!empty($development_facilities))
                  <tr>
                    <td>@lang('main.development_facilities')</td>

                    <td>
                      @php($st = [])

                      @foreach($development_facilities as $facilities)
                        @php($st[] = $langSt($facilities['name']))
                      @endforeach

                      {{ join($st, ', ') }}
                    </td>
                  </tr>
                  @endif

                  @if(!empty($estimated_completion))
                    <tr>
                      <td>@lang('main.expected_completion')</td>

                      <td>
                        @php($st = [])

                        @foreach($estimated_completion as $completion)
                          @php($st[] = $langSt($completion['name']))
                        @endforeach

                        {{ join($st, ', ') }}
                      </td>
                    </tr>
                  @endif
              </table>
            </div>
          </div>

          <div>
            <a href="/catalog/{{ $name }}" class="back-btn">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#long-arrow-left"></use>
              </svg>

              @lang('main.back_to_catalog')
            </a>
          </div>
        </div>
      </div>

      @include('site.block.contacts-form')
    </div>

    @if(!empty($similar_objects))
      <section class="indent-block">
        <div class="container-fluid related-products-section">
          <h2 class="text-center">@lang('main.similar_objects')</h2>
          @include('site.block.catalog_list', ['catalog' => $similar_objects, 'name_url' => $name])
        </div>
      </section>
    @endif
  </main>
@endsection