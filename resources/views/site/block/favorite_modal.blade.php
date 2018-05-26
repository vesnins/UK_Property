<!--modals-->
<div class="modal">
	<div class="close"></div>
	<div class="modal--main">
		<div class="friend-form" data-modal="friend-form">
			<span class="close"><svg> <use xlink:href="/images/svg/sprite.svg#ico_close"></use> </svg></span>

			<div class="friend-form--wrap">
				<figure style="background-image: url('/images/items/eirini-luxury-villas-patmos.jpg')"></figure>

				<div class="friend-form--main animate-bg">
					<h5 class="title">@lang('main.send_to_a_friend')</h5>

					<form action="#" id="friend-form">
						<div class="fields">
							<div class="fieldset your-name-cont" style="display:none;">
								<div class="field">
									<div class="input">
										<input
											id="yourEmail"
											name="yourEmail"
											type="text"
											placeholder="*@lang('main.your_e_mail')"
											disabled="disabled"
										/>
									</div>
								</div>
							</div>

							<div class="add-fieldset">
								<span class="add" id="addFieldset" style="pointer-events: all">+1</span>
								<div class="fieldset">
									<div class="field">
										<div class="input">
											<input
												id="friendMail"
												name="friendMail[]"
												type="text"
												placeholder="*@lang('main.to'): @lang('main.write_email_a_friend')"
											/>
										</div>
									</div>
								</div>
							</div>

							<div class="fieldset">
								<div class="field">
									<div class="input">
										<input
											id="yourName"
											name="yourName"
											type="text"
											placeholder="*@lang('main.from'): @lang('main.write_your_name')"
										/>
									</div>
								</div>
							</div>

							<div class="fieldset">
								<div class="field">
									<div class="input">
											<textarea
												id="message"
												name="message"
												rows="3"
												placeholder="@lang('main.write_a_message')"
											></textarea>
									</div>
								</div>
							</div>

							<div class="fieldset">
								<div class="check">
									<label>
										<input type="checkbox" name="send-me" autocomplete="off" />
										<span>@lang('main.a_copy_of_the_letter_to_me')</span>
									</label>
								</div>

								<p class="asterisk">*@lang('main.required_fields')</p>
							</div>

							<div class="fieldset">
								<div class="check check_field">
									<label>
										<input type="checkbox" checked id="securityPolicy" name="securityPolicy" />

										<span>
											<a href="/privacy-policy" target="_blank" class="link">*@lang('main.security_policy_text')</a>
										</span>
									</label>
								</div>
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
						<p>@lang('main.selection_sent_to_your_friends')</p>

						<div class="btn_center">
							<a href="/blog" class="more">@lang('main.read_our_blog')</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@push('footer')
<!--validate-->
<script>
	formsFull.initFriendForm();
</script>
@endpush