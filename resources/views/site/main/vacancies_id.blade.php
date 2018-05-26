@extends('site.layouts.default')

@section('content')
	<section class="simple-page--bg">
		@php($path_big = '/images/files/big/')
		@php($img_big = $vacancy['file'] ? $vacancy['crop'] ? $path_big . $vacancy['crop'] : $path_big . $vacancy['file'] : '')
		<div class="intro-figure dynamic">
			<figure style="background-image: url('{{ $img_big }}')"></figure>
		</div>

		<div class="content">
			<header class="light-style">
				<h1 class="headline_main">{{ $langSt($vacancy['name']) }}</h1>

				<div class="headline_btn">
					<a href="javascript:void(0);" class="btn btn_subm show-modal"  data-modal="resume-form">
						@lang('main.apply_now')
					</a>
				</div>
			</header>
		</div>
	</section>

	<div class="simple-page--main">
		<div class="content content_sm">
			<div class="text-box">
				<h3>@lang('main.description')</h3>
				{!! $langSt($vacancy['text']) !!}
			</div>
		</div>
	</div>

	@if(count($vacancies))
		<div class="vacancy">
			<div class="content">
				<div class="vacancy-box inside-mob">
					<div class="content content_md">
						<header>
							<h2 class="headline_main">@lang('main.vacancies')</h2>
							<h4 class="headline_submain">{{ $langSt($params['vacancies_vacancies_h3']['key']) }}</h4>
						</header>

						<ul class="vacancy-list">
							@foreach($vacancies as $val)
								<li>
									<a href="/vacancies/{{ $val['id'] }}">
										<h3 class="title">{{ $langSt($val['name']) }}</h3>
										<span class="price">&euro; {{ $val['price_money'] }}</span>
										<span class="place">
									<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_mark"></use> </svg></i>
									<span>{{ $val['location'] }}</span>
								</span>
										<span class="arrow">
									<svg> <use xlink:href="/images/svg/sprite.svg#ico_arrow-right-small"></use> </svg>
								</span>
									</a>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	@endif

	<!--modals-->
	<div class="modal">
		<div class="close"></div>
		<div class="modal--main">
			<div class="resume-form" data-modal="resume-form">
				<span class="close"><svg><use xlink:href="/images/svg/sprite.svg#ico_close"></use></svg></span>

				<div class="resume-form--wrap">
					<div class="resume-form--main animate-bg">
						<h5 class="title">@lang('main.to_send_a_resume')</h5>

						<form action="#" id="resume-form">
							<div class="fields">
								<div class="fieldset">
									<div class="field">
										<div class="load">
											<label>
												<input type="file" name="file" id="file-upload" />
												<span id="file-name">@lang('main.upload_your_cv')</span>
											</label>
										</div>
									</div>
								</div>

								<div class="fieldset">
									<div class="field">
										<div class="input">
											<input id="name-form-resume" name="name" type="text" placeholder="*@lang('main.your_name')" />
										</div>
									</div>

									<div class="field">
										<div class="input">
											<input type="text" id="mail-form-resume" name="mail" placeholder="*@lang('main.e_mail')" />
										</div>
									</div>

									<div class="field">
										<div class="input">
											<input
												type="text"
												id="telephone-form-resume"
												name="telephone"
												placeholder=*"@lang('main.phone')"
											/>
										</div>
									</div>
								</div>

								<div class="fieldset">
									<div class="field">
										<div class="input">
											<textarea
												id="message-form-resume"
												name="message"
												rows="3"
												placeholder="@lang('main.write_a_message')"
											></textarea>
										</div>
									</div>
								</div>

								<div class="fieldset">
									<div class="check check_field">
										<label>
											<input type="checkbox" checked id="securityPolicy" name="securityPolicy" />

											<span>
												<a href="/privacy-policy" target="_blank" class="link-black">
													*@lang('main.security_policy_text')
												</a>
											</span>
										</label>
									</div>
								</div>

								<div class="fieldset">
									<p class="asterisk">*@lang('main.required_fields')</p>
								</div>
							</div>

							<div class="btn-box">
								<button type="submit">
									<i>
										<svg>
											<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/images/svg/sprite.svg#ico_submit"></use>
										</svg>
									</i>
								</button>
							</div>
						</form>
					</div>
				</div>

				<div class="form-success">
					<div class="form-success--main">
						<div class="text">
							<h5 class="success-title">@lang('main.message_sent')</h5>

							<p>@lang('main.resume_form_mess')</p>
							<div class="btn_center">
								<a href="/blog" class="more">@lang('main.read_our_blog')</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--validate-->

	@push('footer')
	<script>
		formsFull.initResumeForm('@lang('main.upload_your_cv')');
	</script>
	@endpush
@endsection