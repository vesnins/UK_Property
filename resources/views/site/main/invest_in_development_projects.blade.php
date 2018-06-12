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
              <form action="#" class="product-filter-form hidden-box">
                @foreach($filters['filters'] as $filter)
                  <div class="filter-item {{ $filter['class'] ?? '' }}">
                    <a href="#" class="item-title">{{ current($filter['fields'])['title'] ?? '' }}</a>

                    <div class="item-info">
                      @if($filter['type'] === 'multi_checkbox')
                        <label class="checkbox-label">
                          <input type="checkbox" name="group-1" />
                          <span>Лондонский Сити</span>
                        </label>
                      @endif

                      @if($filter['type'] === 'slider_select')
                        <div class="range-slider">
                          <input
                            class="slider"
                            type="text"
                            data-slider-min="0"
                            data-slider-max="1000"
                            data-slider-step="5"
                            data-slider-value="[0,1000]"
                            placeholder=""
                          />

                          <div class="input-group">
                            <label>
                              @lang('main.from_')
                              <input type="text" class="range-value min" placeholder="" />
                            </label>

                            <label>
                              @lang('main.to_')
                              <input type="text" class="range-value max" placeholder="" />
                            </label>
                          </div>
                        </div>
                      @endif

                      @if($filter['type'] === 'slider_select_area')
                        <div class="mb-xs">
                          <div class="switch-btn">
                            <input type="checkbox" checked="" />
                            <label><i>м<sup>2</sup></i> <i>ft</i></label>
                          </div>
                        </div>

                        <div class="range-slider">
                          <input
                            class="slider"
                            type="text"
                            data-slider-min="40"
                            data-slider-max="300"
                            data-slider-step="5"
                            data-slider-value="[50,150]"
                            placeholder=""
                          />

                          <div class="input-group">
                            <label>
                              @lang('main.from_')
                              <input type="text" class="range-value min" placeholder="" />
                            </label>

                            <label>
                              @lang('main.to_')
                              <input type="text" class="range-value max" placeholder="" />
                            </label>
                          </div>
                        </div>
                      @endif
                    </div>
                  </div>
                @endforeach

                <div class="text-center">
                  <a href="#" class="reset-btn">Очистить фильтр</a>
                </div>
              </form>
            </div>

            <a href="#" class="sidebar-switcher">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#arrow-left"></use>
              </svg>
            </a>
          </div>

          <div class="grid-holder tab-holder">
            <header class="sort-form-holder">
              <form action="#" class="sort-form">
                <label for="sort-select">Сортировать по</label>

                <select title="" id="sort-select">
                  <option value="1">цене</option>
                  <option value="1">популярности</option>
                  <option value="1">расстоянию</option>
                  <option value="1">площади</option>
                </select>

                <a href="#" class="reverse-btn reverse">
                  <svg>
                    <use xlink:href="/images/svg/sprite.svg#reverse"></use>
                  </svg>
                </a>

              </form>

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
              <div class="tab-item tab-item-tab_1 active">
                @include('site.block.catalog_list', ['catalog' => [], 'paginate' => false])
              </div>

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
  </main>
@endsection