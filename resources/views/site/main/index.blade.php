@extends('site.layouts.default')

@section('content')
  @php($path_small = '/images/files/small/')
  @php($path_big = '/images/files/big/')

  <main class="main">
    <div class="billboard" style="background-image: url('/images/banners/img_1.jpg')">
      <a href="#section_1" class="go-down-btn"><i class="line"></i></a>
      <video class="video-poster" poster="/images/banners/img_1.jpg" autoplay muted loop>
        <source src="/images/video/video.mp4" type="video/mp4">
        <source src="/images/video/video.webm" type="video/webm">
      </video>
      <div class="align-box">
        <div class="container large">
          <div class="row">
            <div class="col-lg-6 col-md-7 col-sm-9">
              <h1>эксперты <br> недвижимости</h1>
              <div class="billboard-slider">
                <div>
                  <p>Подбор квартир на этапе строительства <br> и сопровождение всего цикла инвестирования</p>
                </div>
                <div>
                  <p>Подбор строительства квартир на этапе строительства <br> и сопровождение всего цикла инвестирования
                  </p>
                </div>
                <div>
                  <p>Подбор квартир на этапе строительства <br> и сопровождение всего цикла инвестирования сопровождение
                  </p>
                </div>
              </div>

              <a href="/selection-request" class="button">Подобрать Недвижимость</a>
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

              <a href="/{{ $langSt($services['invest-in-a-new-building']['translation']) }}" class="more-link">
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

        <div class="products">
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_3.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_4.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_5.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_6.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="text-center">
          <a
            href="/catalog/{{ explode('/', $services['invest-in-a-new-building']['translation'])[count(explode('/', $services['invest-in-a-new-building']['translation'])) - 1] }}"
            class="button"
          >
            @lang('main.other_options')
          </a>
        </div>
      </div>

      <div class="container-fluid mb-lg">
        <div class="service-info-area reverse">
          <div class="text-section">
            <div class="limit-box">
              <h3>{{ $langSt($services['invest-in-development-projects']['name']) }}</h3>
              <p>{{ $langSt($services['invest-in-development-projects']['little_description']) }}</p>

              <a href="/{{ $langSt($services['invest-in-development-projects']['translation']) }}" class="more-link">
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

        <div class="products">
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_9.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_10.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_11.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_12.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="text-center">
          <a
            href="/catalog/{{ explode('/', $services['invest-in-development-projects']['translation'])[count(explode('/', $services['invest-in-development-projects']['translation'])) - 1] }}"
            class="button"
          >
            @lang('main.other_options')
          </a>
        </div>
      </div>

      <div class="container-fluid mb-lg">
        <div class="service-info-area">
          <div class="text-section">
            <div class="limit-box">
              <h3>{{ $langSt($services['buy']['name']) }}</h3>
              <p>{{ $langSt($services['buy']['little_description']) }}</p>

              <a href="/{{ $langSt($services['buy']['translation']) }}" class="more-link">
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

        <div class="products">
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_15.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_9.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_16.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_17.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="text-center">
          <a
            href="/catalog/{{ explode('/', $services['buy']['translation'])[count(explode('/', $services['buy']['translation'])) - 1] }}"
            class="button"
          >
            @lang('main.other_options')
          </a>
        </div>
      </div>

      <div class="container-fluid mb-lg">
        <div class="service-info-area reverse">
          <div class="text-section">
            <div class="limit-box">
              <h3>{{ $langSt($services['rent']['name']) }}</h3>
              <p>{{ $langSt($services['rent']['little_description']) }}</p>
              <a href="/{{ $langSt($services['rent']['translation']) }}" class="more-link">@lang('main.more')</a>
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

        <div class="products">
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_3.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_4.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_5.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
          <div class="product-item">
            <a href="#" class="add-to-wishList">
              <svg>
                <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
              </svg>
            </a>
            <a href="#" class="product-link">
              <div class="image-box" style="background-image: url('/images/content/img_6.jpg')">
                <div class="product-details">
                  <div class="cell">S = 450 м²</div>
                  <div class="cell">4 спальни</div>
                </div>
              </div>
              <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
              <div class="row flex-row align-row">
                <div class="col-xs-6">
                  <span class="price">от 155 млн руб</span>
                </div>
                <div class="col-xs-6 text-right">
                  <span class="pseudo-btn">Выбрать</span>
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="text-center">
          <a
            href="/catalog/{{ explode('/', $services['rent']['translation'])[count(explode('/', $services['rent']['translation'])) - 1] }}"
            class="button"
          >
            @lang('main.other_options')
          </a>
        </div>
      </div>

      <div class="container">
        <ul class="service-links">
          <li>
            <a href="/{{ $langSt($services['sell']['translation']) }}" class="item-link">
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
            <a href="/{{ $langSt($services['property-management']['translation']) }}" class="item-link">
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
        <h3 class="text-center">Подпишитесь на рассылку!</h3>
        <form action="#" class="subscribe-form validate-form">
          <div class="flex-group">
            <div class="input-holder email-field">
              <input type="email" name="email" placeholder="Email">
            </div>
            <div class="input-holder select">
              <select title="">
                <option value="1" selected>1 раз в неделю</option>
                <option value="2">1 раз в месяц</option>
                <option value="3">каждый день</option>
              </select>
            </div>
            <div class="input-holder select">
              <select title="">
                <option value="1" selected>Объекты</option>
                <option value="2">Статьи блога</option>
                <option value="3">Объекты и статьи блога</option>
              </select>
            </div>
            <input type="submit" class="button" value="Отправить">
          </div>

          <label class="checkbox-label">
            <input type="checkbox" name="checkbox" checked />

            <span>
              @lang('main.i_have_read_and_agree_to_the')
              <a href="#" target="_blank">@lang('main.terms_&_Conditions')</a>
              @lang('main._and')
              <a href="#" target="_blank">@lang('main.privacy_policy')</a>.
            </span>
          </label>
        </form>
      </div>
    </section>
    <section class="indent-block">
      <h2 class="text-center">@lang('main.how_we_are_working')</h2>

      <div class="video-box mb-md" style="background-image: url('/images/banners/img_3.jpg')">
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
      <div class="container">
        <div class="service-slider simple-slider">
          @include('site.block.how_working', ['how_working' => $about['how_working']])
        </div>

        <div class="preview-post flex-row">
          <div class="text-box">
            <blockquote><p>{!! $langSt($about['quote_main_block_1_1']) !!}</p></blockquote>
            <p>{!! $langSt($about['quote_main_block_1_2']) !!}</p>
            <a href="/about-company" class="more-link">@lang('main.company_details')</a>
          </div>

          <div class="img-box">
            <div class="position-box">
              <img src="/images/content/img_18.jpg" />

              <a href="{!! $langSt($params['link_on_linkedin']['key']) !!}" class="social-link">
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
        </div>

        <img class="decor-left" src="/images/decor/img_5.png" data-parallax='{"y": -60, "smoothness": 30}' />
        <img class="decor-right" src="/images/decor/img_6.png" data-parallax='{"y": -100, "smoothness": 15}' />
        <img class="decor-bottom" src="/images/decor/img_7.png" data-parallax='{"y": -140, "smoothness": 45}' />
      </div>
    @endif

    <div class="consultation-request" style="background-image: url('/images/banners/img_4.jpg')">
      <div class="container">
        <div class="limit-box">
          <h4>{!! $langSt($params['text_consultation_main']['key']) !!}</h4>

          <a href="#" class="more-button" data-toggle="modal" data-target=".consultation-modal">
            @lang('main.to_get_a_consultation')
          </a>

          <ul class="social">
            @include('site.block.sharing')
          </ul>
        </div>
      </div>
    </div>
  </main>
@endsection
