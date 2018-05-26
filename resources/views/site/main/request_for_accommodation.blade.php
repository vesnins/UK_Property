@extends('site.layouts.default')

@section('content')
	<section class="simple-page--head placing--request" style="background-image: url('/images/bg/account-bg.jpeg')">
		<div class="content">
			<header class="light-style">
				<h1 class="headline_main">@lang('main.request_for_accommodation')</h1>
			</header>
		</div>
	</section>

	<div class="vacancy">
		<div class="content">
			<div class="vacancy-box">
				<div class="content content_md">
					<div class="form-request placing-form">
						<div class="form">
							<form action="#" id="request-for-accommodation-form" class="request-for-accommodation-form">
								<div class="form-box">
									<div class="fieldset">
										<div class="field">
											<label for="name">*@lang('main.name')</label>
											<div class="input"><input id="name" name="name" type="text"></div>
										</div>

										<div class="field">
											<label for="position">@lang('main.position')</label>
											<div class="input"><input type="text" name="position" id="position" /></div>
										</div>
									</div>

									<div class="fieldset">
										<div class="field">
											<label for="telephone">*@lang('main.phone')</label>
											<div class="input"><input type="text" name="telephone" id="telephone" /></div>
										</div>

										<div class="field">
											<label for="mail">*@lang('main.e_mail')</label>
											<div class="input"><input type="text" name="mail" id="mail"></div>
										</div>
									</div>

									<div class="fieldset">
										<div class="field">
											<label for="villaAddress">*@lang('main.address_of_the_villa')</label>
											<div class="input"><input id="villaAddress" name="villaAddress" type="text" /></div>
										</div>
									</div>

									<div class="fieldset">
										<div class="field">
											<label for="siteLink">@lang('main.site_or_link_to_photos')</label>
											<div class="input"><input id="siteLink" name="siteLink" type="text"></div>
										</div>
									</div>

									<div class="fieldset">
										<div class="field">
											<label for="source">@lang('main.where_did_you_find_out_about_us')</label>
											<div class="input"><input id="source" name="source" type="text" /></div>
										</div>
									</div>

									<div class="fieldset">
										<div class="check">
											<label>
												<input type="checkbox" checked id="securityPolicy" name="securityPolicy" />

												<span>
													<a href="/privacy-policy" target="_blank" class="link-black">*@lang('main.security_policy_text')</a>
												</span>
											</label>
										</div>
									</div>

									<p class="asterisk">*@lang('main.required_fields')</p>
									<button class="btn btn_subm" type="submit">@lang('main.send_request')</button>
								</div>
							</form>

							<div class="form-success">
								<span class="close"><svg> <use xlink:href="/images/svg/sprite.svg#ico_close"></use> </svg></span>
								<div class="form-success--main">
									<div class="text">
										<h5 class="success-title">{!! $langSt($params['send_advantages_text']['key']) !!}</h5>
									</div>
								</div>
							</div>
						</div>
					</div>

					<header>
						<h2 class="headline_main">@lang('main.advantages')</h2>
						<h4 class="headline_submain">{{ $langSt($params['advantages_accommodation_h3']['key']) }}</h4>
					</header>

					<div class="vacancy-advances">
						<ul>
							@foreach($benefits_accommodation as $v)
								@php($path_small = '/images/files/small/')
								@php($img_small = $v['file'] ? $v['crop'] ? $path_small . $v['crop'] : $path_small . $v['file'] : '')

								<li>
									<i><img src="{{ $img_small }}" alt="img" /></i>
									<div class="text">
										<h5 class="title">{!! $langSt($v['name']) !!}</h5>
										{!! $langSt($v['text']) !!}
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('footer')
	<script>
		formsFull.initRequestForAccommodation();
	</script>
	@endpush
@endsection