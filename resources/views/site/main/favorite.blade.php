@extends('site.layouts.default')

@section('content')
  <main class="main">
    <section class="indent-block">
      <div class="container-fluid">
        <h1 class="text-center">@lang('main.favorites')</h1>

        <header class="sort-form-holder">
          <a href="#" class="send-btn" data-toggle="modal" data-target=".selection-modal">
            Отправить подборку

            <svg>
              <use xlink:href="/images/svg/sprite.svg#airplain"></use>
            </svg>
          </a>
        </header>

        <div class="product-section alt" data-sticky-container>
          <div class="product-listing">
            <div class="sys-sel-catalog"></div>
          </div>

          @include('site.block.contacts-form')
        </div>
      </div>
    </section>
  </main>

  @push('footer')
    <div class="modal fade selection-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <svg>
                <use xlink:href="images/svg/sprite.svg#close-icon"></use>
              </svg>
            </button>
            <div class="decor-box" style="background-image: url('images/banners/img_6.jpg')"></div>
            <h3 class="text-center">@lang('main.selection_request')</h3>

            <form action="#" class="validate-form">
              <div class="custom-fields-group">
                <div class="input-holder">
                  <input type="email" name="email" placeholder="Your friend Email *">
                  <a href="#" class="del-field-btn">
                    <svg>
                      <use xlink:href="images/svg/sprite.svg#close-icon"></use>
                    </svg>
                  </a>
                  <a href="#" class="add-field-btn">
                    <svg>
                      <use xlink:href="images/svg/sprite.svg#plus"></use>
                    </svg>
                  </a>
                </div>
              </div>
              <div class="input-holder">
                <input type="email" name="email" placeholder="Your Email *">
              </div>
              <div class="input-holder">
                <label class="checkbox-label switcher-checkbox"><input type="checkbox"><span>Отправить агенту для
                    запроса</span></label>
              </div>
              <div class="collapse-input-group">
                <div class="input-holder">
                  <input type="text" name="name" placeholder="Your Name *">
                </div>
                <div class="input-holder">
                  <input type="text" name="surname" placeholder="Your Surname *">
                </div>
                <div class="input-holder">
                  <input type="tel" name="phone" placeholder="Your Phone *">
                </div>
              </div>
              <div class="input-holder">
                <textarea placeholder="Comment"></textarea>
              </div>
              <div class="input-holder">
                <label class="checkbox-label"><input type="checkbox" name="checkbox" checked><span>I have read and agree
                    to the <a href="#" target="_blank">Terms&Conditions</a> and <a href="#" target="_blank">Privacy
                      policy</a>.</span></label>
                <label class="checkbox-label"><input type="checkbox" checked><span>I agree to receive property updates
                    and latest news via email.</span></label>
              </div>
              <div class="text-center">
                <input class="button" type="submit" value="send">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function() {
        catAll.initialize({
          container : '.sys-sel-catalog',
          num       : '.selReN > .i',
          pagination: true,
          isLoad    : false,
          url_req   : '/',
        });
      });

      $('#header').addClass('static');
    </script>
  @endpush
@endsection