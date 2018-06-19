@extends('site.layouts.default')

@section('content')
  @php($path_small = '/images/files/small/')
  @php($path_big = '/images/files/big/')

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

        <li data-class="tab_2" data-type="map" class="{{empty($photos) ? 'active' : '' }}">
          <a href="#">@lang('main.map')</a>
        </li>

        @if(!empty($plan))
          <li data-class="tab_3" data-type="plan"><a href="#">@lang('main.plan')</a></li>
        @endif
      </ul>

      <div class="product-info tab-holder">
        <div class="tab-content">
          @if(!empty($photos))
            <div class="tab-item tab-item-tab_1 active">
              <div class="product-gallery">
                <a href="#" class="add-to-wishList">
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
                    </div>     <div>
                      <div class="inner-box" style="background-image: url('{{ $img }}')"></div>
                    </div>
                  @endforeach
                </div>

                <div class="preview-slider simple-slider">
                  @foreach($photos as $photo)
                    @php($img = $photo['file']
                      ? $photo['crop'] ? $path_small . $photo['crop'] : $path_small . $photo['file']
                      : '/images/files/no-image.jpg'
                    )

                    <div>
                      <div class="inner-box" style="background-image: url('{{ $img }}')"></div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          @endif

          <div class="tab-item tab-item-tab_2 {{empty($photos) ? 'active' : '' }}">
            <div id="map">
              <img src="/images/content/img_23-1.jpg" alt="">
            </div>
          </div>

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
                    ${{ number_format($page['price_money_from'] * 1000000, 0, ',', ' ') }}
                    -
                    ${{ number_format($page['price_money_to'] * 1000000, 0, ',', ' ') }}
                  @else
                    ${{ number_format($page['price_money'] * 1000000, 0, ',', ' ') }}
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
                    {{ round($page['area_from'] * 3.28, 2) }} - {{ round($page['area_to'] * 3.28, 2) }}
                  @else
                    {{ round($page['area'] * 3.28, 2) }}
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
                    <td>{{ $langSt($params_type_object['name']) }}</td>
                  </tr>
                @endif

                @if(!empty($development_facilities))
                  <tr>
                    <td>@lang('main.infrastructure')</td>

                    <td>
                      @php($st = [])

                      @foreach($development_facilities as $facilities)
                        @php($st[] = $langSt($facilities['name']))
                      @endforeach

                      {{ join($st, ', ') }}
                    </td>
                  </tr>
                @endif

                @if(!empty($params_estimated_completion))
                  <tr>
                    <td>@lang('main.expected_duration')</td>
                    <td>{{ $langSt($params_estimated_completion['name']) }}</td>
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

    <section class="indent-block">
      <div class="container-fluid related-products-section">
        <h2 class="text-center">@lang('main.similar_objects')</h2>
        @include('site.block.catalog_list', ['catalog' => $similar_objects, 'name_url' => $name])
      </div>
    </section>
  </main>
@endsection