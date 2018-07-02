<div class="flex-group">
  <div class="input-holder email-field">
    <input type="email" name="email" placeholder="Email" />
  </div>

  <div class="input-holder select">
    <select title="periodicity" name="periodicity">
      <option value="1" selected>@lang('main.once_a_week')</option>
      <option value="2">@lang('main.1_time_per_month')</option>
      <option value="3">@lang('main.everyday')</option>
    </select>
  </div>

  <div class="input-holder select">
    <select title="type_subscribe" name="type_subscribe">
      <option value="1" selected>@lang('main.objects')</option>
      <option value="2">@lang('main.blog_articles')</option>
      <option value="3">@lang('main.objects_and_blog_articles')</option>
    </select>
  </div>

  <input type="hidden" name="current_url" value="{{ \URL::full() }}" />
  <input type="hidden" name="type" value="subscription_form" />
  <input type="submit" class="button" value="{{ $send }}" />
</div>
