@extends('site.layouts.default')

@section('content')
  <main class="main">
    <section class="indent-block">
      <div class="container-fluid">
        <h1 class="text-center">@lang('main.favorites')</h1>

        <header class="sort-form-holder">
          <a href="#" class="send-btn" data-toggle="modal" data-target=".selection-modal">
            @lang('main.send_compilation')

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

          <form action="#" class="validate-form" name="form-favorite">
            <div class="custom-fields-group">
              <div class="input-holder">
                <input type="email" name="friend_email[]" placeholder="@lang('main.your_friend_email') *" />

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
              <input type="email" name="email" placeholder="@lang('main.your_email') *" />
            </div>
            <div class="input-holder">
              <label class="checkbox-label switcher-checkbox">
                <input type="checkbox" name="send_agent" autocomplete="off" />
                <span>@lang('main.send_agent_for_request')</span>
              </label>
            </div>

            <div class="collapse-input-group">
              <div class="input-holder">
                <input type="text" name="your_name" placeholder="@lang('main.your_name') *" />
              </div>
              <div class="input-holder">
                <input type="text" name="your_surname" placeholder="@lang('main.your_surname') *" />
              </div>

              <div class="input-holder">
                <input type="tel" name="phone" placeholder="@lang('main.your_phone') *" />
              </div>
            </div>

            <div class="input-holder">
              <textarea name="comment_text" placeholder="@lang('main.comment')"></textarea>
            </div>

            <div class="input-holder">
              <label class="checkbox-label">
                <input type="checkbox" name="terms_conditions" checked />

                <span>
                  @lang('main.i_have_read_and_agree_to_the')
                  <a href="/terms-conditions" target="_blank">@lang('main._terms_&_Conditions_')</a>
                  @lang('main._and_')
                  <a href="/privacy-cookies" target="_blank">@lang('main._privacy_policy_')</a>.
                </span>
              </label>

              <label class="checkbox-label switcher-checkbox">
                <input type="checkbox" name="news_updates" checked />
                <span>@lang('main.text_mail_sending')</span>
              </label>
            </div>

            <div class="text-center">
              <input type="hidden" name="current_url" value="{{ \URL::full() }}" />
              <input type="hidden" name="type" value="friend_form" />
              <input class="button" type="submit" value="@lang('main.send')" />
            </div>

            <div class="success-message">
              <div class="flex-container">
                <div class="align-box">
                  <h4 class="text-center">{!! $langSt($params['friends_form_title']['key']) !!}</h4>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @push('footer')
    <script>
      $(document).ready(function() {
        catAll.initialize({
          container  : '.sys-sel-catalog',
          num        : '.selReN > .i',
          pagination : true,
          isLoad     : false,
          isPortfolio: false,
          url_req    : '/',
        });
      });

      $('#header').addClass('static');
    </script>
  @endpush
@endsection