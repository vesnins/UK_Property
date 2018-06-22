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
                <p>{!! $langSt($service['little_description_catalog']) !!}</p>
              </div>
            </div>

            @if(!empty($langSt($service['how_working'])))
              <div class="service-slider simple-slider">
                @include('site.block.how_working', ['how_working' => $service['how_working']])
              </div>
            @endif
          </div>

          <div class="product-grid-section" data-sticky-container>
            <div class="sidebar" data-sticky data-sticky-class="sticky" data-sticky-for="768" data-margin-top="82">
              <div class="scroll-box collapse-menu-holder">
                <span class="collapse-btn"><span class="dt">Show</span><span class="t">Hide</span> filters
                  <svg>
                    <use xlink:href="/images/svg/sprite.svg#arrow-down"></use>
                  </svg>
                </span>

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
                            class="slider"
                            type="text"
                            data-slider-min="{{ $f[0]['data'] }}"
                            data-slider-max="{{ $f[1]['data'] }}"
                            data-slider-step="{{ $filter['step'] ?? 5 }}"
                            data-slider-value="[{{ $f[0]['data'] }},{{ $f[1]['data'] }}]"
                          />

                          <div class="input-group">
                            <label>
                              @lang('main.from_')
                              <input
                                type="text"
                                name="{{ $f[0]['name'] }}"
                                class="range-value min"
                                placeholder="{{ $f[1]['title'] }}"
                              />
                            </label>

                            <label>
                              @lang('main.to_')
                              <input
                                type="text"
                                name="{{ $f[1]['name'] }}"
                                class="range-value max"
                                placeholder="{{ $f[1]['title'] }}"
                              />
                            </label>
                          </div>
                        </div>
                      @endif

                      @if($filter['type'] === 'slider_select_area')
                        <div class="mb-xs">
                          <div class="switch-btn">
                            <input type="checkbox" value="ft" checked="" autocomplete="off" name="type_ft_m2"/>
                            <label><i>м<sup>2</sup></i> <i>ft<sup>2</sup></i></label>
                          </div>
                        </div>

                        <div class="range-slider slider-area">
                          <input
                            class="slider"
                            type="text"
                            data-slider-min="{{ $filter['fields']['area_from']['data'] }}"
                            data-slider-max="{{ $filter['fields']['area_to']['data'] }}"
                            data-slider-step="5"
                            name="slider_area"

                            data-slider-value="[
                              {{ $filter['fields']['area_from']['data'] }},
                              {{ $filter['fields']['area_to']['data'] }}
                              ]"
                          />

                          <div class="input-group">
                            <label>
                              @lang('main.from_')

                              <input
                                type="text"
                                name="{{ $filter['fields']['area_from']['name'] }}"
                                class="range-value min"
                              />
                            </label>

                            <label>
                              @lang('main.to_')
                              <input
                                type="text"
                                class="range-value max"
                                name="{{ $filter['fields']['area_to']['name'] }}"
                              />
                            </label>
                          </div>
                        </div>
                      @endif
                    </div>
                  </div>
                @endforeach

                <div class="text-center">
                  <a href="javascript:void(0)" class="reset-btn" onclick="$('[name=\'catalog_form\']')[0].reset();">
                    @lang('main.clear_filter')
                  </a>
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
                    <option value="3">@lang('main.distance_')</option>
                    <option value="1">@lang('main.price_')</option>
{{--                    <option value="4">@lang('main.area_')</option>--}}
                    <option value="5">@lang('main.latest_')</option>
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
                  <li data-class="tab_2" data-type="map">
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
                  <div id="map">
                    <img src="/images/content/img_23.jpg" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="consultation-request" style="background-image: url('/images/banners/img_4.jpg')">
          <div class="container">
            <div class="limit-box">
              <h4>
                Проконсультируйтесь по вопросам инвестиций, приобретению и аренде недвижимости или по другим вопросам
                касаемых недвижимости
              </h4>
              <a href="#" class="more-button">Получить консультацию</a>
              <ul class="social">
                <li>
                  <a href="#">
                    <svg>
                      <use xlink:href="/images/svg/sprite.svg#facebook"></use>
                    </svg>

                    123
                  </a>
                </li>

                <li>
                  <a href="#">
                    <svg>
                      <use xlink:href="/images/svg/sprite.svg#linkedin"></use>
                    </svg>

                    95
                  </a>
                </li>
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
          container : '.sys-sel-catalog',
          isLoad    : true,
          num       : '.selReN > .i',
          pagination: true,
          url_req   : '/',
        })
      });
    </script>
  @endpush
@endsection
