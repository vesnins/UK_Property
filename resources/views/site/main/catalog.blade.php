@extends('site.layouts.default')

@section('content')
  @php($path_big = '/images/files/big/')
  @php($path_small = '/images/files/small/')
  @php($img = $service['file'] ? $service['crop'] ? $path_big . $service['crop'] : $path_big . $service['file'] : '')

  <main class="main">
    <div class="subheader fixed-subheader" style="background-image: url('{{ $img }}')">
      <div class="container">
        <h1>{{ $langSt($service['name']) }}</h1>
      </div>
    </div>

    <form action="#" name="catalog_form" class="product-filter-form hidden-box">
      <div class="scroll-content">
        <div class="indent-block">
          <div class="container">
            <div class="row text-center">
              <div class="col-md-10 col-md-offset-1">
                <div class="entry-holder">
                  <div class="entry-content">{!! $langSt($service['text']) !!}</div>
                </div>
              </div>
            </div>

            @if(!empty($langSt($service['how_working'])) && $langSt($service['how_working']) !== 'null')
              <div class="service-slider simple-slider">
                @include('site.block.how_working', ['how_working' => $service['how_working']])
              </div>
            @endif
          </div>

          @if($catalog_count)
            <div class="product-grid-section" data-sticky-container id="catalog">
              <div class="sidebar" data-sticky data-sticky-class="sticky" data-sticky-for="768" data-margin-top="82">
                <div class="scroll-box collapse-menu-holder">
                  <span class="collapse-btn"><span class="dt">Show</span><span class="t">Hide</span> filters
                    <svg>
                      <use xlink:href="/images/svg/sprite.svg#arrow-down"></use>
                    </svg>
                  </span>

                  <div class="product-filter-form">
                    <input type="hidden" name="name_url" value="{{ $name }}" />
                    <input name="pagination" value="1" type="hidden" autocomplete="off" />

                    @foreach($filters['filters'] as $filter)
                      <div class="filter-item {{ $filter['class'] ?? '' }}">
                        <a href="#" class="item-title">{{ current($filter['fields'])['title'] ?? '' }}</a>

                        <div class="item-info">
                          @if($filter['type'] === 'multi_checkbox')
                            @foreach($filter['data'] ?? [] as $d)
                              <label class="checkbox-label">
                                <input
                                  type="checkbox"
                                  name="{{ current($filter['fields'])['name'] ?? '' }}[]"
                                  value="{{ $d['id'] }}"
                                />

                                <span>{{ $langSt($d['name']) }}</span>
                              </label>
                            @endforeach
                          @endif

                          @if($filter['type'] === 'slider_select')
                            @php($f = [])
                            @php($i = 0)

                            @foreach($filter['fields'] as $field)
                              @php($f[$i]['data'] = $field['data'])
                              @php($f[$i]['name'] = $field['name'])
                              @php($i++)
                            @endforeach

                            <div class="range-slider">
                              <input
                                class="slider parent-input"
                                type="text"
                                data-slider-min="{{ $f[0]['data'] }}"
                                data-slider-max="{{ $f[1]['data'] }}"
                                data-slider-step="{{ $filter['step'] ?? 5 }}"
                                data-slider-value="[{{ $f[0]['data'] }},{{ $f[1]['data'] }}]"
                                autocomplete="off"
                              />

                              <div class="input-group">
                                <label>
                                  @lang('main.from_')
                                  <input
                                    type="text"
                                    name="{{ $f[0]['name'] }}"
                                    class="range-value min s-map-reset"
                                    placeholder="{{ $f[1]['title'] }}"
                                    autocomplete="off"
                                  />
                                </label>

                                <label>
                                  @lang('main.to_')
                                  <input
                                    type="text"
                                    name="{{ $f[1]['name'] }}"
                                    class="range-value max s-map-reset"
                                    placeholder="{{ $f[1]['title'] }}"
                                    autocomplete="off"
                                  />
                                </label>
                              </div>
                            </div>
                          @endif

                          @if($filter['type'] === 'slider_select_area')
                            <div class="mb-xs">
                              <div class="switch-btn">
                                <input type="checkbox" value="ft" checked="" autocomplete="off" name="type_ft_m2" />
                                <label><i>м<sup>2</sup></i> <i>ft<sup>2</sup></i></label>
                              </div>
                            </div>

                            <div class="range-slider slider-area">
                              <input
                                class="slider parent-input"
                                type="text"
                                data-slider-min="{{ $filter['fields']['area_from']['data'] }}"
                                data-slider-max="{{ $filter['fields']['area_to']['data'] }}"
                                data-slider-step="5"
                                name="slider_area"
                                autocomplete="off"

                                data-slider-value="[
                                  {{ $filter['fields']['area_from']['data'] }},
                                  {{ $filter['fields']['area_to']['data'] }}
                                ]"
                              />

                              <input
                                type="hidden"
                                name="data-slider-min"
                                class="s-map-reset"
                                value="{{ $filter['fields']['area_from']['data'] }}"
                                autocomplete="off"
                              />

                              <input
                                type="hidden"
                                name="data-slider-max"
                                class="s-map-reset"
                                value="{{ $filter['fields']['area_to']['data'] }}"
                                autocomplete="off"
                              />

                              <div class="input-group">
                                <label>
                                  @lang('main.from_')

                                  <input
                                    type="text"
                                    name="{{ $filter['fields']['area_from']['name'] }}"
                                    class="range-value min s-map-reset"
                                    autocomplete="off"
                                  />
                                </label>

                                <label>
                                  @lang('main.to_')
                                  <input
                                    type="text"
                                    class="range-value max s-map-reset"
                                    name="{{ $filter['fields']['area_to']['name'] }}"
                                    autocomplete="off"
                                  />
                                </label>
                              </div>
                            </div>
                          @endif
                        </div>
                      </div>
                    @endforeach

                    <div class="text-center">
                      <a href="javascript:void(0)" class="reset-btn" onclick="catAll.catalogReset()">
                        @lang('main.clear_filter')
                      </a>
                    </div>
                  </div>
                </div>

                <a href="#" class="sidebar-switcher">
                  <svg>
                    <use xlink:href="/images/svg/sprite.svg#arrow-left"></use>
                  </svg>
                </a>
              </div>

              <div class="grid-holder tab-holder">
                <header class="sort-form-holder">
                  <div class="sort-form">
                    <label for="sort-select">@lang('main.sort_by')</label>
                    <select title="" id="sort-select" name="group">
                      {{--<option value="2">@lang('main.popularity_')</option>--}}



                      @if(array_search(3, $filters['top_filter']) !== false)
                        <option value="3">@lang('main.distance_')</option>
                      @endif

                      @if(array_search(1, $filters['top_filter']) !== false)
                        <option value="1">@lang('main.price_')</option>
                      @endif

                      @if(array_search(4, $filters['top_filter']) !== false)
                        <option value="4">@lang('main.area_')</option>
                      @endif

                      @if(array_search(5, $filters['top_filter']) !== false)
                        <option value="5">@lang('main.latest_')</option>
                      @endif

                      @if(array_search(6, $filters['top_filter']) !== false)
                        <option value="6">@lang('main.availability_date_')</option>
                      @endif
                    </select>

                    <a
                      href="javascript:void(0)"
                      class="reverse-btn"

                      onclick="
                      if($(this).hasClass('reverse'))
                        $(this).removeClass('reverse');
                      else
                        $(this).addClass('reverse');

                      if($(this).hasClass('reverse'))
                        $('[name=\'sort_by\']').val('DESC');
                      else
                        $('[name=\'sort_by\']').val('ASC');
                    "
                    >
                      <svg>
                        <use xlink:href="/images/svg/sprite.svg#reverse"></use>
                      </svg>
                    </a>

                    <input type="hidden" name="sort_by" value="ASC" autocomplete="off" />
                  </div>

                  <ul class="view-switcher tab-navigation-list">
                    <li data-class="tab_1" data-type="listing" class="active">
                      <a href="#">
                        <svg>
                          <use xlink:href="/images/svg/sprite.svg#grid-layout"></use>
                        </svg>
                      </a>
                    </li>
                    <li data-class="tab_2" onclick="catAll.addMarker(true)" data-type="map">
                      <a href="#">
                        <svg>
                          <use xlink:href="/images/svg/sprite.svg#pin-full"></use>
                        </svg>
                      </a>
                    </li>
                  </ul>
                </header>

                <div class="tab-content">
                  <div class="tab-item tab-item-tab_1 active sys-sel-catalog"></div>

                  <div class="tab-item tab-item-tab_2">
                    <div id="map" style="height: 100%; width: 100%">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>

        <div class="consultation-request" style="background-image: url('/images/banners/img_4.jpg')">
          <div class="container">
            <div class="limit-box">
              <h4>{!! $langSt($params['text_consultation_catalog']['key']) !!}</h4>

              <a href="#" data-target=".request-modal" data-toggle="modal" class="more-button">
                @lang('main.to_get_a_consultation')
              </a>

              <ul class="social">
                @include('site.block.sharing')
              </ul>
            </div>
          </div>
        </div>
      </div>
    </form>
  </main>

  @push('footer')
    <script>
      $(document).ready(function() {
        catAll.initialize({
          container  : '.sys-sel-catalog',
          isLoad     : true,
          num        : '.selReN > .i',
          pagination : true,
          isPortfolio: false,
          url_req    : '/',
        })
      });
    </script>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6PFq1z3G7_YGiZl1KUuVVH_kxI2YAdaA&callback=catAll.initMap&language={{ $lang }}"></script>
  @endpush
@endsection
