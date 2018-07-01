@extends('site.layouts.default')

@section('content')
  <main class="main">
    <section class="application-form-holder">
      <div class="decor-img" style="background-image: url('/images/banners/img_9.jpg')"></div>

      <div class="container">
        <h1 class="text-center">@lang('main.selection_request')</h1>

        <form action="#" class="application-form validate-form">
          <div class="input-group">
            <label for="name">My name is</label>

            <div class="input-holder">
              <input type="text" id="name" name="name" placeholder="First Name *" />
            </div>

            <div class="input-holder">
              <input type="text" name="surname" placeholder="Second Name *" />
            </div>

            <br />
            <label for="build-type">I’m interested in</label>

            <div class="input-holder">
              <select id="build-type">
                <option value="1" selected>Buying a family home</option>
                <option value="2">Investing in a New Build</option>
                <option value="3">Investing in Development Project</option>
                <option value="3">Renting an apartment</option>
              </select>
            </div>

            <label for="location">My ideal property will be located in</label>

            <div class="input-holder">
              <input type="text" id="location" name="location" placeholder="Location *" />
            </div>

            <br />
            <label for="rooms">Preferred number of bedrooms is</label>

            <div class="input-holder">
              <input class="sm" type="text" id="rooms" name="rooms" placeholder="bedrooms *" />
            </div>

            <label for="price-from">I’ll consider options between £</label>

            <div class="input-holder">
              <input class="sm" type="text" id="price-from" name="priceFrom" placeholder="price *" />
            </div>

            <label for="price-to">and £</label>

            <div class="input-holder">
              <input class="sm" type="text" id="price-to" name="priceTo" placeholder="price *" />
            </div>

            <br />

            <label for="phone">Plaese, call me on my mobile phone</label>

            <div class="input-holder">
              <input type="tel" id="phone" name="phone" placeholder="Phone Number *" />
            </div>

            <label for="time">The best time to call me is</label>

            <div class="input-holder">
              <select id="time">
                <option value="morning">morning</option>
                <option value="midday">midday</option>
                <option value="evening">evening</option>
              </select>
            </div>

            <br />

            <label for="city">I currently live in</label>

            <div class="input-holder">
              <input type="text" id="city" placeholder="City" />
            </div>

            <label for="email">My email is</label>

            <div class="input-holder">
              <input type="email" id="email" placeholder="Email *" />
            </div>
          </div>

          <label class="checkbox-label">
            <input type="checkbox" name="checkbox" checked />

            <span>
              @lang('main.i_have_read_and_agree_to_the')
              <a href="/terms-conditions" target="_blank">@lang('main._terms_&_Conditions_')</a>
              @lang('main._and_')
              <a href="/terms-conditions" target="_blank">@lang('main._privacy_policy_')</a>.
            </span>
          </label>

          <label class="checkbox-label">
            <input type="checkbox" checked />
            <span>@lang('main.text_mail_sending')</span>
          </label>

          <div class="text-center">
            <input class="button" type="submit" value="send to uk property advisors" />
          </div>
        </form>
      </div>
    </section>
  </main>
@endsection
