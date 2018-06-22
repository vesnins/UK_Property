<div class="contact-section" data-sticky data-sticky-class="sticky" data-sticky-for="991" data-margin-top="82">
  <h4>@lang('main.call_local_expert')</h4>

  <address>
    <span class="address-info">
      <svg>
        <use xlink:href="/images/svg/sprite.svg#phone"></use>
      </svg>

      <a href="tel:{!! $langSt($params['phone_favorite']['key']) !!}">
        {!! $langSt($params['phone_favorite']['key']) !!}
      </a>
    </span>
  </address>

  <p>@lang('main.our_consultant_will_help_you')</p>

  <form action="#" class="validate-form">
    <div class="input-holder">
      <input type="text" name="fullName" placeholder="@lang('main.full_name')" />
    </div>

    <div class="input-holder">
      <input type="email" name="email" placeholder="Email" />
    </div>

    <div class="input-holder">
      <input type="tel" name="phone" placeholder="@lang('main.phone_number')" />
    </div>

    <div class="input-holder">
      <textarea placeholder="@lang('main.write_here')" name="message"></textarea>
    </div>

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

    <div class="text-center">
      <input type="submit" class="button" value="@lang('main.send')" />
    </div>
  </form>
</div>