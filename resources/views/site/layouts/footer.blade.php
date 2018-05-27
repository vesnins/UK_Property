<footer class="site-footer">
	<div class="container-fluid">
		<div class="row flex-row">
			<div class="foo-col contact-info">
				<h4>Контакты</h4>
				<address>
					<span class="address-info">
						<svg><use xlink:href="/images/svg/sprite.svg#pin"></use></svg>
						UK Property Advisors Ltd. <br> 71-75 Shelton street <br> London, WC2H 9JQ
					</span>
					<span class="address-info">
						<svg><use xlink:href="/images/svg/sprite.svg#envelope"></use></svg>
						<a href="mailto:info@ukpropadv.com">info@ukpropadv.com</a>
					</span>
					<span class="address-info">
						<svg><use xlink:href="/images/svg/sprite.svg#phone"></use></svg>
						WhatsApp/Viber/Telegram: <br>
						<a href="tel:+440-755-310-9657">+44 (0) 755 310 9657</a> <br>
						<a href="tel:+440-2086-05-2068">+44 (0) 2086 05 2068</a>
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
				<h4>Услуги</h4>
				<ul class="menu">
					<li><a href="#">Инвестировать в новострой</a></li>
					<li><a href="#">Инвестировать в девелоперские проекты</a></li>
					<li><a href="#">Купить</a></li>
					<li><a href="#">Арендовать</a></li>
					<li><a href="#">Продать</a></li>
					<li><a href="#">Управление недвижимостью</a></li>
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
					<label class="checkbox-label"><input type="checkbox" name="checkbox" checked><span>I have read and agree to the <a href="#" target="_blank">Terms&Conditions</a> and <a href="#" target="_blank">Privacy policy</a>.</span></label>
					<label class="checkbox-label"><input type="checkbox" checked><span>I agree to receive property updates and latest news via email.</span></label>
				</form>
				<ul class="additional-links">
					<li><a href="#">Terms&Conditions</a></li>
					<li><a href="#">Privacy&Cookies</a></li>
					<li><a href="#">TDS explained</a></li>
				</ul>
				<ul class="social-list">
					<li><a href="#"><svg><use xlink:href="/images/svg/sprite.svg#facebook"></use></svg></a></li>
					<li><a href="#"><svg><use xlink:href="/images/svg/sprite.svg#linkedin"></use></svg></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="secondary-footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10">
					<p>© 2018 UK Property Все права защищены Соглашение об обработке персональных данных</p>
				</div>
				<div class="col-sm-2 text-right">
					<a href="https://reconcept.ru/">ReConcept</a>
				</div>
			</div>
		</div>
	</div>
	<div class="go-top" style="display: block;"><svg><use xlink:href="/images/svg/sprite.svg#arrow-up"></use></svg></div>
</footer>

<audio
	class="audio-record"
	autoplay="{{ env('AUDIO_AUTOPLAY') ? 'true' : 'false' }}"
	loop="{{ env('AUDIO_LOOP') ? 'true' : 'false' }}"
	hidden="{{ env('AUDIO_HIDDEN') ? 'true' : 'false' }}"
>
	<source src="/images/audio/audio-record.mp3">
</audio>
</div>

<div class="modal fade request-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<svg><use xlink:href="/images/svg/sprite.svg#close-icon"></use></svg>
				</button>

				<div class="decor-box" style="background-image: url('images/banners/img_6.jpg')"></div>
				<h3 class="text-center">@lang('main.request_a_call')</h3>

				<form action="#" class="validate-form">
					<div class="input-holder">
						<input type="tel" name="phone" placeholder="Your Phone *">
					</div>

					<div class="input-holder">
						<input type="email" placeholder="Convenient time for a call">
					</div>

					<div class="input-holder">
						<input type="text" name="name" placeholder="First Name *">
					</div>

					<div class="input-holder">
						<input type="text" name="surname" placeholder="Second Name *">
					</div>

					<div class="input-holder">
						<label class="checkbox-label">
							<input type="checkbox" name="checkbox" checked />

							<span>
								I have read and agree to the
								<a href="#" target="_blank">Terms&Conditions</a>
								and <a href="#" target="_blank">Privacy policy</a>.
							</span>
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
					<svg><use xlink:href="/images/svg/sprite.svg#close-icon"></use></svg>
				</button>

				<div class="decor-box" style="background-image: url('images/banners/img_6.jpg')"></div>
				<h3 class="text-center">Получить консультацию</h3>
				<form action="#" class="validate-form">
					<div class="input-holder">
						<input type="text" name="name" placeholder="First Name *">
					</div>
					<div class="input-holder">
						<input type="text" name="surname" placeholder="Second Name *">
					</div>
					<div class="input-holder">
						<input type="tel" name="phone" placeholder="Phone Number *">
					</div>
					<div class="input-holder">
						<input type="email" placeholder="Email">
					</div>
					<div class="input-holder">
						<textarea placeholder="Message"></textarea>
					</div>
					<div class="input-holder">
						<label class="checkbox-label"><input type="checkbox" name="checkbox" checked><span>I have read and agree to the <a href="#" target="_blank">Terms&Conditions</a> and <a href="#" target="_blank">Privacy policy</a>.</span></label>
						<label class="checkbox-label"><input type="checkbox" checked><span>I agree to receive property updates and latest news via email.</span></label>
					</div>
					<div class="text-center">
						<input class="button" type="submit" value="send">
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
					<svg><use xlink:href="/images/svg/sprite.svg#close-icon"></use></svg>
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
	if (!window.jQuery) document.write('<script src="/js/jquery-1.12.4.min.js"><\/script>');
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/svg4everybody/2.1.9/svg4everybody.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/svg4everybody/2.1.9/svg4everybody.legacy.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sticky-js/1.2.0/sticky.compile.js"></script>
<script src="/js/bootstrap-components/bootstrap-modal.min.js"></script>
<script src="/js/parallax-js/jquery.parallax-scroll.js"></script>
<script src="/js/libs/venobox.min.js"></script>
<script src="/js/main.js"></script>
@stack('footer')
</body>
</html>