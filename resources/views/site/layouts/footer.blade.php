<footer class="site-footer">
  <div class="container-fluid">
    <div class="row flex-row">
      <div class="foo-col contact-info">
        <h4>Контакты</h4>
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
        <h4>Полезное</h4>
        <ul class="link-list">
          <li><a href="#">Сравнительный анализ инвестиций в недвижимость Лондона с другими странами</a></li>
          <li><a href="#">Расчет прибыльности инвестиций</a></li>
          <li><a href="#">На чем мы зарабатываем</a></li>
          <li><a href="#">Прозрачность (про отчет)</a></li>
        </ul>
      </div>
      <div class="foo-col foo-menu mb-hidden">
        <h4>O нас</h4>
        <ul class="menu">
          <li><a href="#">О компании</a></li>
          <li><a href="#">Портфолио</a></li>
          <li><a href="/blog">Блог</a></li>
          <li><a href="#">Контакты</a></li>
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
        <h4>Получай самые последние новости!</h4>
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
                <option value="2">Квартиры</option>
                <option value="3">Офисы</option>
              </select>
            </div>
            <input type="submit" class="button" value="Ок">
          </div>
          <label class="checkbox-label"><input type="checkbox" name="checkbox" checked><span>I have read and agree to
              the <a href="#" target="_blank">Terms&Conditions</a> and <a href="#" target="_blank">Privacy
                policy</a>.</span></label>
          <label class="checkbox-label"><input type="checkbox" checked><span>I agree to receive property updates and
              latest news via email.</span></label>
        </form>
        <ul class="additional-links">
          <li><a href="#">Terms&Conditions</a></li>
          <li><a href="#">Privacy&Cookies</a></li>
          <li><a href="#">TDS explained</a></li>
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
            UK Property Все права защищены
            <a>Соглашение об обработке персональных данных</a>
          </p>
        </div>

        <div class="col-sm-2 text-right">
          <a href="https://reconcept.ru/">ReConcept</a>
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

<audio
  class="audio-record"
  {{ env('AUDIO_AUTOPLAY') ? 'autoplay' : '' }}
  {{ env('AUDIO_LOOP') ? 'loop' : '' }}
  {{ env('AUDIO_HIDDEN') ? 'hidden' : '' }}
>
  <source src="/images/audio/audio-record.mp3">
</audio>
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

        <div class="decor-box" style="background-image: url('images/banners/img_6.jpg')"></div>
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
                <a href="#" target="_blank">@lang('main.terms_&_Conditions')</a>
                @lang('main._and')
                <a href="#" target="_blank">@lang('main.privacy_policy')</a>.
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

<div class="modal fade consultation-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <svg><use xlink:href="images/svg/sprite.svg#close-icon"></use></svg>
        </button>

        <div class="decor-box" style="background-image: url('images/banners/img_6.jpg')"></div>
        <h3 class="text-center">@lang('main.request_a_call')</h3>

        <form action="#" class="validate-form">
          <div class="input-holder">
            <input type="text" name="name" placeholder="@lang('main.first_name') *" />
          </div>
          <div class="input-holder">
            <input type="text" name="surname" placeholder="@lang('main.second_name') *" />
          </div>
          <div class="input-holder">
            <input type="tel" name="phone" placeholder="@lang('main.phone_number') *" />
          </div>
          <div class="input-holder">
            <input type="email" placeholder="Email">
          </div>
          <div class="input-holder">
            <select title="" name="enquirySelect">
              <option value="1" selected>Your Enquiry</option>
              <option value="2">Your Enquiry</option>
              <option value="3">Your Enquiry</option>
            </select>
          </div>

          <div class="input-holder">
            <textarea placeholder="@lang('main.message')"></textarea>
          </div>

          <div class="input-holder">
            <label class="checkbox-label">
              <input type="checkbox" name="checkbox" checked />

              <span>
                @lang('main.i_have_read_and_agree_to_the')
                <a href="#" target="_blank">@lang('main.terms_&_Conditions')</a>
                @lang('main._and')
                <a href="#" target="_blank">@lang('main.privacy_policy')</a>.
              </span>
            </label>

            <label class="checkbox-label">
              <input type="checkbox" checked />
              <span>@lang('main.text_mail_sending')</span>
            </label>
          </div>

          <div class="text-center"><input class="button" type="submit" value="@lang('main.send')" /></div>
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
<script src="/js/bootstrap-components/bootstrap-modal.min.js"></script>
<script src="/js/parallax-js/jquery.parallax-scroll.js"></script>
<script src="/js/libs/venobox.min.js"></script>
<script src="/js/libs/sticky.min.js"></script>
<script src="/js/main.js"></script>
<script src="/js/lodash.min.js"></script>
<script src="/js/ctalog.js"></script>
@stack('footer')
</body>
</html>