@extends('site.layouts.default')

@section('content')
  <main class="main">
    <section class="application-form-holder">
      <div class="decor-img" style="background-image: url('/images/banners/img_9.jpg')"></div>

      <div class="container">
        <h1 class="text-center">@lang('main.selection_request')</h1>

        <form action="#" class="application-form validate-form">
          <div class="input-group">
            <label for="name">@lang('main.my_name_is')</label>

            <div class="input-holder">
              <input type="text" id="name" name="first_name" placeholder="@lang('main.first_name') *" />
            </div>

            <div class="input-holder">
              <input type="text" name="second_name" placeholder="@lang('main.second_name') *" />
            </div>

            <br />
            <label for="build-type">@lang('main.i_m_interested_in')</label>

            <div class="input-holder">
              <select id="build-type" name="interested">
                <option value="1" selected>@lang('main.buying_a_family_home')</option>
                <option value="2">@lang('main.investing_in_a_new_build')</option>
                <option value="3">@lang('main.investing_in_development_project')</option>
                <option value="4">@lang('main.renting_an_apartment')</option>
              </select>
            </div>

            <label for="location">@lang('main.my_ideal_property_will_be_located_in')</label>

            <div class="input-holder">
              <input type="text" id="location" name="location" placeholder="@lang('main.location') *" />
            </div>

            <br />
            <label for="bedrooms">@lang('main.preferred_number_of_bedrooms_is')</label>

            <div class="input-holder">
              <input class="sm" type="text" id="bedrooms" name="bedrooms" placeholder="@lang('main.bedrooms') *" />
            </div>

            <label for="price-from">"@lang('main.i_ll_consider_options_between') £</label>

            <div class="input-holder">
              <input class="sm" type="text" id="price-from" name="price_from" placeholder="@lang('main.price') *" />
            </div>

            <label for="price-to">@lang('main._and') £</label>

            <div class="input-holder">
              <input class="sm" type="text" id="price-to" name="price_to" placeholder="@lang('main.price') *" />
            </div>

            <br />

            <label for="phone">@lang('main.please_call_me_on_my_mobile_phone')</label>

            <div class="input-holder">
              <input type="tel" id="phone" name="phone_number" placeholder="@lang('main.phone_number') *" />
            </div>

            <label for="time">@lang('main.the_best_time_to_call_me_is')</label>

            <div class="input-holder">
              <select id="time" name="time_to_call">
                <option value="morning">@lang('main.morning')</option>
                <option value="midday">@lang('main.midday')</option>
                <option value="evening">@lang('main.evening')</option>
              </select>
            </div>

            <br />

            <label for="city">@lang('main.i_currently_live_in')</label>

            <div class="input-holder">
              <input type="text" id="city" name="city" placeholder="@lang('main.city')" />
            </div>

            <label for="email">@lang('main.my_email_is')</label>

            <div class="input-holder">
              <input type="email" id="email" name="email" placeholder="@lang('main.email') *" />
            </div>
          </div>

          <label class="checkbox-label">
            <input type="checkbox" name="terms_conditions" checked />

            <span>
              @lang('main.i_have_read_and_agree_to_the')
              <a href="/terms-conditions" target="_blank">@lang('main._terms_&_Conditions_')</a>
              @lang('main._and_')
              <a href="/privacy-cookies" target="_blank">@lang('main._privacy_policy_')</a>.
            </span>
          </label>

          <label class="checkbox-label">
            <input type="checkbox" checked name="news_updates" />
            <span>@lang('main.text_mail_sending')</span>
          </label>

          <div class="text-center">
            <input type="hidden" name="current_url" value="{{ \URL::full() }}" />
            <input type="hidden" name="type" value="request_form" />
            <input class="button" type="submit" value="@lang('main.send_to_uk_property_advisors')" />
          </div>

          <div class="success-message">
            <div class="flex-container">
              <div class="align-box">
                <h4 class="text-center">{!! $langSt($params['request_form_title']['key']) !!}</h4>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
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
