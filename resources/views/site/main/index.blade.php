@extends('site.layouts.default')

@section('content')
  @php($path_small = '/images/files/small/')
  @php($path_big = '/images/files/big/')

  @php($img_big = $main_page['file']
    ? $main_page['crop']
      ? $path_big . $main_page['crop']
      : $path_big . $main_page['file']
    : ''
   )

  <main class="main">
    <div class="billboard" style="background-image: url('{{ $img_big }}')">
      <a href="#section_1" class="go-down-btn"><i class="line"></i></a>
      <video class="video-poster" poster="{{ $img_big }}" autoplay muted loop>
        @foreach($main_page_video as $video)
          <source
            src="/images/files/files/{{ $video['file'] }}"
            type="video/{{ explode('.', $video['file'])[count(explode('.', $video['file'])) - 1] }}"
          />
        @endforeach
      </video>
      <div class="align-box">
        <div class="container large">
          <div class="row">
            <div class="col-lg-6 col-md-7 col-sm-9">
              <h1>{!! $langSt($main_page['offer']) !!}</h1>

              <div class="billboard-slider">
                @foreach(explode("\r", (string) $langSt($main_page['little_description'])) ?? [] as $description)
                  <div><p>{!! $description !!}</p></div>
                @endforeach
              </div>

              <a href="javascript:void(0)" class="button" data-toggle="modal" data-target=".request-modal">
                @lang('main.find_real_estate')
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="indent-block" id="section_1">
      <div class="container-fluid mb-lg">
        <h2 class="text-center">@lang('main.our_services')</h2>

        <div class="service-info-area">
          <div class="text-section">
            <div class="limit-box">
              <h3>{{ $langSt($services['invest-in-a-new-building']['name']) }}</h3>
              <p>{{ $langSt($services['invest-in-a-new-building']['little_description']) }}</p>

              <a href="/catalog/{{ $langSt($services['invest-in-a-new-building']['translation']) }}" class="more-link">
                @lang('main.more')
              </a>
            </div>
          </div>

          <div class="image-section">
            @php($collections_crop = $services['invest-in-a-new-building']
              ? $services['invest-in-a-new-building']['collections_crop']
                ? $path_big . $services['invest-in-a-new-building']['collections_crop']
                : $path_big . $services['invest-in-a-new-building']['collections_files']
              : env('PATH_TO_IMG_DEFAULT')
             )

            @if($collections_crop)
              <div class="image-box" style="background-image: url('{{ $collections_crop }}')"></div>
            @endif

            @php($collections_crop_2 = $services['invest-in-a-new-building']
             ? $services['invest-in-a-new-building']['collections_crop_2']
               ? $path_big . $services['invest-in-a-new-building']['collections_crop_2']
               : $path_big . $services['invest-in-a-new-building']['collections_files_2']
             : env('PATH_TO_IMG_DEFAULT')
            )

            @if($collections_crop_2)
              <img class="small-img" src="{{ $collections_crop_2 }}" data-parallax='{"y": -80, "smoothness": 10}' />
            @endif

            <img class="decor-top" src="/images/decor/img_1.png" data-parallax='{"y": -40, "smoothness": 20}' />
            <img class="decor-bottom" src="/images/decor/img_2.png" data-parallax='{"y": -120, "smoothness": 30}' />
          </div>
        </div>

        @include('site.block.catalog_list', ['catalog' => $services['invest-in-a-new-building']['data'],
         'name_url' => 'invest-in-a-new-building', 'no_empty_message' => true])

        @if(!empty($services['invest-in-a-new-building']['data']))
          <div class="text-center">
            <a
              href="/catalog/{{ $services['invest-in-a-new-building']['translation'] }}"
              class="button"
            >
              @lang('main.other_options')
            </a>
          </div>
        @endif
      </div>

      <div class="container-fluid mb-lg">
        <div class="service-info-area reverse">
          <div class="text-section">
            <div class="limit-box">
              <h3>{{ $langSt($services['invest-in-development-projects']['name']) }}</h3>
              <p>{{ $langSt($services['invest-in-development-projects']['little_description']) }}</p>

              <a href="/catalog/{{ $langSt($services['invest-in-development-projects']['translation']) }}" class="more-link">
                @lang('main.more')
              </a>
            </div>
          </div>

          <div class="image-section">
            @php($collections_crop = $services['invest-in-development-projects']
              ? $services['invest-in-development-projects']['collections_crop']
                ? $path_big . $services['invest-in-development-projects']['collections_crop']
                : $path_big . $services['invest-in-development-projects']['collections_files']
              : env('PATH_TO_IMG_DEFAULT')
             )

            @if($collections_crop)
              <div class="image-box" style="background-image: url('{{ $collections_crop }}')"></div>
            @endif

            @php($collections_crop_2 = $services['invest-in-development-projects']
             ? $services['invest-in-development-projects']['collections_crop_2']
               ? $path_big . $services['invest-in-development-projects']['collections_crop_2']
               : $path_big . $services['invest-in-development-projects']['collections_files_2']
             : env('PATH_TO_IMG_DEFAULT')
            )

            @if($collections_crop_2)
              <img class="small-img" src="{{ $collections_crop_2 }}" data-parallax='{"y": -80, "smoothness": 10}' />
            @endif

            <img class="decor-top" src="/images/decor/img_3.png" data-parallax='{"y": -40, "smoothness": 20}' />
            <img class="decor-bottom" src="/images/decor/img_4.png" data-parallax='{"y": -120, "smoothness": 30}' />
          </div>
        </div>

        @include('site.block.catalog_list', ['catalog' => $services['invest-in-development-projects']['data'],
         'name_url' => 'invest-in-development-projects', 'no_empty_message' => true])

        @if(!empty($services['invest-in-development-projects']['data']))
          <div class="text-center">
            <a
              href="/catalog/{{ $services['invest-in-development-projects']['translation'] }}"
              class="button"
            >
              @lang('main.other_options')
            </a>
          </div>
        @endif
      </div>

      <div class="container-fluid mb-lg">
        <div class="service-info-area">
          <div class="text-section">
            <div class="limit-box">
              <h3>{{ $langSt($services['buy']['name']) }}</h3>
              <p>{{ $langSt($services['buy']['little_description']) }}</p>

              <a href="/catalog/{{ $langSt($services['buy']['translation']) }}" class="more-link">
                @lang('main.more')
              </a>
            </div>
          </div>

          <div class="image-section">
            @php($collections_crop = $services['buy']
              ? $services['buy']['collections_crop']
                ? $path_big . $services['buy']['collections_crop']
                : $path_big . $services['buy']['collections_files']
              : env('PATH_TO_IMG_DEFAULT')
             )

            @if($collections_crop)
              <div class="image-box" style="background-image: url('{{ $collections_crop }}')"></div>
            @endif

            @php($collections_crop_2 = $services['buy']
             ? $services['buy']['collections_crop_2']
               ? $path_big . $services['buy']['collections_crop_2']
               : $path_big . $services['buy']['collections_files_2']
             : env('PATH_TO_IMG_DEFAULT')
            )

            @if($collections_crop_2)
              <img class="small-img" src="{{ $collections_crop_2 }}" data-parallax='{"y": -80, "smoothness": 10}' />
            @endif

            <img class="decor-top" src="/images/decor/img_2.png" data-parallax='{"y": -40, "smoothness": 20}' />
            <img class="decor-bottom" src="/images/decor/img_1.png" data-parallax='{"y": -120, "smoothness": 30}' />
          </div>
        </div>

        @include('site.block.catalog_list',
         ['catalog' => $services['buy']['data'], 'name_url' => 'buy' , 'no_empty_message' => true])

        @if(!empty($services['buy']['data']))
          <div class="text-center">
            <a
              href="/catalog/{{ $services['buy']['translation'] }}"
              class="button"
            >
              @lang('main.other_options')
            </a>
          </div>
        @endif
      </div>

      <div class="container-fluid mb-lg">
        <div class="service-info-area reverse">
          <div class="text-section">
            <div class="limit-box">
              <h3>{{ $langSt($services['rent']['name']) }}</h3>
              <p>{{ $langSt($services['rent']['little_description']) }}</p>

              <a href="/catalog/{{ $langSt($services['rent']['translation']) }}" class="more-link">
                @lang('main.more')
              </a>
            </div>
          </div>

          <div class="image-section">
            @php($collections_crop = $services['rent']
              ? $services['rent']['collections_crop']
                ? $path_big . $services['rent']['collections_crop']
                : $path_big . $services['rent']['collections_files']
              : env('PATH_TO_IMG_DEFAULT')
             )

            @if($collections_crop)
              <div class="image-box" style="background-image: url('{{ $collections_crop }}')"></div>
            @endif

            @php($collections_crop_2 = $services['rent']
             ? $services['rent']['collections_crop_2']
               ? $path_big . $services['rent']['collections_crop_2']
               : $path_big . $services['rent']['collections_files_2']
             : env('PATH_TO_IMG_DEFAULT')
            )

            @if($collections_crop_2)
              <img class="small-img" src="{{ $collections_crop_2 }}" data-parallax='{"y": -80, "smoothness": 10}' />
            @endif

            <img class="decor-top" src="/images/decor/img_1.png" data-parallax='{"y": -40, "smoothness": 20}' />
            <img class="decor-bottom" src="/images/decor/img_2.png" data-parallax='{"y": -120, "smoothness": 30}' />
          </div>
        </div>

        @include('site.block.catalog_list',
         ['catalog' => $services['rent']['data'], 'name_url' => 'rent', 'no_empty_message' => true])

        @if(!empty($services['rent']['data']))
          <div class="text-center">
            <a
              href="/catalog/{{ $services['rent']['translation'] }}"
              class="button"
            >
              @lang('main.other_options')
            </a>
          </div>
        @endif
      </div>

      <div class="container">
        <ul class="service-links">
          <li>
            <a href="/{{ ($services['sell']['controller'] ? $services['sell']['controller'] . '/' : '') . $langSt($services['sell']['translation']) }}" class="item-link">
              <div class="icon-box">
                <svg><use xlink:href="/images/svg/sprite.svg#rent"></use></svg>
              </div>

              <div class="text-box">
                <h3>{{ $langSt($services['sell']['name']) }}</h3>
                <p>{{ $langSt($services['sell']['little_description']) }}</p>
                <span class="more-link">@lang('main.more')</span>
              </div>
            </a>
          </li>

          <li>
            <a href="/{{ ($services['property-management']['controller'] ? $services['property-management']['controller'] . '/' : '') . $langSt($services['property-management']['translation']) }}" class="item-link">
              <div class="icon-box">
                <svg><use xlink:href="/images/svg/sprite.svg#manage"></use></svg>
              </div>

              <div class="text-box">
                <h3>{{ $langSt($services['property-management']['name']) }}</h3>
                <p>{{ $langSt($services['property-management']['little_description']) }}</p>
                <span class="more-link">@lang('main.more')</span>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </section>

    <section class="subscribe-section" style="background-image: url('/images/banners/img_2.jpg')">
      <div class="container">
        <h3 class="text-center">{!! $langSt($params['subscribe_to_our_newsletter']['key']) !!}</h3>

        <form action="#" class="subscribe-form validate-form">
          @include('site.block.subscribe_form', ['send' =>__('main.send')])

          <label class="checkbox-label">
            <input type="checkbox" name="checkbox" checked />

            <span>
              @lang('main.i_have_read_and_agree_to_the')
              <a href="/terms-conditions" target="_blank">@lang('main._terms_&_Conditions_')</a>
              @lang('main._and_')
              <a href="/privacy-cookies" target="_blank">@lang('main._privacy_policy_')</a>.
            </span>
          </label>

          <label class="checkbox-label">
            <input type="checkbox" name="news_updates" checked />
            <span>@lang('main.text_mail_sending')</span>
          </label>

          <div class="success-message">
            <div class="flex-container">
              <div class="align-box">
                <h4 class="text-center">{!! $langSt($params['subscribe_form_title']['key']) !!}</h4>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>

    <section class="indent-block">
      <h2 class="text-center">@lang('main.what_service_you_can_expert_from_us')</h2>

      @if(!empty($about['link_how_working']))
        <div class="video-box mb-md" style="background-image: url({{ $imG($img_to_main) }})">
          <a
            href="{{ $about['link_how_working'] }}"
            class="play-btn venobox-btn"
            data-autoplay="true"
            data-vbtype="video"
          >
            <svg>
              <use xlink:href="/images/svg/sprite.svg#triangle-icon"></use>
            </svg>
          </a>
        </div>
      @endif

      <div class="container">
        @if(!empty($langSt($about['how_working'])) && $langSt($about['how_working']) !== 'null')
          <div class="service-slider simple-slider">
            @include('site.block.how_working', ['how_working' => $about['how_working']])
          </div>
        @endif

        <div class="preview-post flex-row">
          <div class="text-box">
            <blockquote><p>{!! $langSt($about['quote_main_block_1_1']) !!}</p></blockquote>
            <p>{!! $langSt($about['quote_main_block_1_2']) !!}</p>
            <a href="/about-company" class="more-link">@lang('main.company_details')</a>
          </div>

          <div class="img-box">
            <div class="position-box">
              <img src="{{ $imG($photo_to_main) }}" />

              <a href="{!! $langSt($params['link_on_linkedin']['key']) !!}" target="_blank" class="social-link">
                <svg><use xlink:href="/images/svg/sprite.svg#linkedin-square"></use></svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    @if(!empty($blog))
      <div class="blog-section indent-block">
        <div class="container">
          <div class="posts-list">
            @include('site.block.blog_main_list')
          </div>

          <div class="text-center">
            <a href="/blog" class="button">@lang('main.all_articles')</a>
          </div>

          <img class="decor-left" src="/images/decor/img_5.png" data-parallax='{"y": -60, "smoothness": 30}' />
          <img class="decor-right" src="/images/decor/img_6.png" data-parallax='{"y": -100, "smoothness": 15}' />
          <img class="decor-bottom" src="/images/decor/img_7.png" data-parallax='{"y": -140, "smoothness": 45}' />
        </div>
      </div>
    @endif

    <div class="consultation-request" style="background-image: url('/images/banners/img_4.jpg')">
      <div class="container">
        <div class="limit-box">
          <h4>{!! $langSt($params['text_consultation_main']['key']) !!}</h4>

          <a href="#" class="more-button" data-toggle="modal" data-target=".request-modal">
            @lang('main.to_get_a_consultation')
          </a>

          <ul class="social">
            @include('site.block.sharing')
          </ul>
        </div>
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
