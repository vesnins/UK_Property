<footer class="site-footer">
  <div class="container-fluid">
    <div class="row flex-row">
      <div class="foo-col contact-info">
        <h4>@lang('main.contacts')</h4>

        <address>
          <span class="address-info">
            <svg><use xlink:href="/images/svg/sprite.svg#pin"></use></svg>
            {!! $langSt($params['address_by_footer']['key']) !!}
          </span>

          <span class="address-info">
            <svg><use xlink:href="/images/svg/sprite.svg#envelope"></use></svg>

            <a href="mailto:{!! $langSt($params['email_by_footer']['key']) !!}">
              {!! $langSt($params['email_by_footer']['key']) !!}
            </a>
          </span>

          <span class="address-info">
            <svg><use xlink:href="/images/svg/sprite.svg#phone"></use></svg>

            WhatsApp/Viber/Telegram:
            <br />

            <a href="tel:{!! $langSt($params['soc_phone_by_footer_1']['key']) !!}">
              {!! $langSt($params['soc_phone_by_footer_1']['key']) !!}
            </a>

            <br />

            <a href="tel:{!! $langSt($params['soc_phone_by_footer_2']['key']) !!}">
              {!! $langSt($params['soc_phone_by_footer_2']['key']) !!}
            </a>
          </span>
        </address>
      </div>

      <div class="foo-col foo-menu mb-hidden">
        <h4>@lang('main.useful')</h4>

        <ul class="link-list">
          @foreach($blog_useful as $useful)
            @php($translation = ($useful['translation'] !== '0' && $useful['translation'] !== '')
             ? $useful['translation']
             : false
            )
            <li><a href="/blog/{{ $translation or $useful['id'] }}">{{ $langSt($useful['name']) }}</a></li>
          @endforeach
        </ul>
      </div>

      <div class="foo-col foo-menu mb-hidden">
        <h4>@lang('main.about_us')</h4>
        <ul class="menu">
          <li><a href="/about-company">@lang('main.about_company')</a></li>
          <li><a href="/portfolio">@lang('main.portfolio')</a></li>
          <li><a href="/blog">@lang('main.blog')</a></li>
          <li><a href="/contact-us">@lang('main.contacts')</a></li>
        </ul>
      </div>

      <div class="foo-col foo-menu mb-hidden">
        <h4>@lang('main.services')</h4>
        <ul class="menu">
          @foreach($services as $service)
            <li><a href="/services/{{ $service['translation'] }}">{{ $langSt($service['name']) }}</a></li>
          @endforeach
        </ul>
      </div>

      <div class="foo-col foo-request">
        <h4>@lang('main.get_the_latest_news')</h4>

        <form action="#" class="subscribe-form validate-form">
          @include('site.block.subscribe_form', ['send' => 'Ok'])

          <label class="checkbox-label"><input type="checkbox" name="checkbox" checked />
            <span>
              @lang('main.i_have_read_and_agree_to_the')
              <a href="/terms-conditions" target="_blank">@lang('main._terms_&_Conditions_')</a>
              @lang('main._and_')
              <a href="/privacy-policy" target="_blank">@lang('main._privacy_policy_')</a>.
            </span>
          </label>

          <label class="checkbox-label">
            <input type="checkbox" checked />
            <span>@lang('main.text_mail_sending')</span>
          </label>
        </form>

        <ul class="additional-links">
          <li><a href="/terms-conditions">@lang('main.terms_&_Conditions')</a></li>
          <li><a href="/privacy-cookies">@lang('main.privacy&cookies')</a></li>
          <li><a href="/tds-explained">@lang('main.tds_explained')</a></li>
        </ul>

        <ul class="social-list">
          <li>
            <a href="/{!! $langSt($params['link_on_facebook']['key']) !!}" target="_blank">
              <svg><use xlink:href="/images/svg/sprite.svg#facebook"></use></svg>
            </a>
          </li>

          <li>
            <a href="/{!! $langSt($params['link_on_linkedin']['key']) !!}" target="_blank">
              <svg><use xlink:href="/images/svg/sprite.svg#linkedin"></use></svg>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="secondary-footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-10">
          <p>
            © 2018 - {{ date('Y') != '2018' ? date('Y') : '' }}
            UK Property @lang('main.all_rights_reserved')
            <a href="/privacy-policy">@lang('main.agreement_on_processing_personal_data')</a>
          </p>
        </div>

        <div class="col-sm-2 text-right">
          <a href="https://reconcept.ru/" target="_blank">ReConcept</a>
        </div>
      </div>
    </div>
  </div>

  <div class="go-top" style="display: block;">
    <svg>
      <use xlink:href="/images/svg/sprite.svg#arrow-up"></use>
    </svg>
  </div>
</footer>

@if($music['file'])
  <audio
    class="audio-record"
    {{ env('AUDIO_AUTOPLAY') ? 'autoplay' : '' }}
    {{ env('AUDIO_LOOP') ? 'loop' : '' }}
    {{ env('AUDIO_HIDDEN') ? 'hidden' : '' }}
  >
    <source src="/images/files/{{ $music['file'] }}">
  </audio>
  @endif
</div>

<div class="modal fade request-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <svg>
            <use xlink:href="/images/svg/sprite.svg#close-icon"></use>
          </svg>
        </button>

        <div class="decor-box" style="background-image: url('/images/banners/img_6.jpg')"></div>
        <h3 class="text-center">@lang('main.consultation')</h3>

        <form action="#" class="validate-form">
          <div class="input-holder">
            <input type="text" name="fullName" placeholder="@lang('main.full_name') *" />
          </div>

          <div class="input-holder">
            <input type="email" placeholder="Email" />
          </div>

          <div class="input-holder">
            <input type="tel" name="phone" placeholder="@lang('main.phone_number') *" />
          </div>

          <div class="input-holder">
            <textarea placeholder="@lang('main.write_here')"></textarea>
          </div>

          <div class="input-holder">
            <label class="checkbox-label">
              <input type="checkbox" name="checkbox" checked />

              <span>
                @lang('main.i_have_read_and_agree_to_the')
                <a href="/terms-conditions" target="_blank">@lang('main._terms_&_Conditions_')</a>
                @lang('main._and_')
                <a href="/privacy-policy" target="_blank">@lang('main._privacy_policy_')</a>.
              </span>
            </label>

            <label class="checkbox-label">
              <input type="checkbox" checked />
              <span>@lang('main.text_mail_sending')</span>
            </label>
          </div>

          <div class="text-center">
            <input class="button" type="submit" value="send" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade success-message" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <svg>
            <use xlink:href="/images/svg/sprite.svg#close-icon"></use>
          </svg>
        </button>

        <div class="decor-box" style="background-image: url('/images/decor/img_14.jpg')"></div>
        <p>&nbsp;</p>
        <h3 class="text-center">Your request has been sent!</h3>
        <h4 class="text-center">Our specialists will contact you!</h4>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
</div>
<script src="/js/jquery-1.12.4.min.js"></script>
<script>
  if(!window.jQuery) document.write('<script src="/js/jquery-1.12.4.min.js"><\/script>');
</script>
<script src="/js/mirror/svg4everybody.min.js"></script>
<script src="/js/mirror/svg4everybody.legacy.min.js"></script>
<script src="/js/mirror/jquery.validate.min.js"></script>
<script src="/js/mirror/jquery.mask.min.js"></script>
<script src="/js/mirror/slick.min.js"></script>
<script src="/js/mirror/bootstrap-slider.min.js"></script>
<script src="/js/mirror/sticky.compile.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.mcustomscrollbar/3.0.6/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/js/bootstrap-components/bootstrap-modal.min.js"></script>
<script src="/js/parallax-js/jquery.parallax-scroll.js"></script>
<script src="/js/libs/venobox.min.js"></script>
<script src="/js/libs/sticky.min.js"></script>
<script src="/js/lodash.min.js"></script>
<script src="/js/main.js"></script>
<script src="/js/ctalog.js"></script>
@stack('footer')
</body>
</html>