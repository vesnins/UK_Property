@extends('site.layouts.default')

@section('content')
	<main class="main">
		<div class="billboard" style="background-image: url('/images/banners/img_1.jpg')">
			<a href="#section_1" class="go-down-btn"><i class="line"></i></a>
			<video class="video-poster" poster="/images/banners/img_1.jpg" autoplay muted loop>
				<source src="/images/video/video.mp4" type="video/mp4">
				<source src="/images/video/video.webm" type="video/webm">
			</video>
			<div class="align-box">
				<div class="container large">
					<div class="row">
						<div class="col-lg-6 col-md-7 col-sm-9">
							<h1>эксперты <br> недвижимости</h1>
							<div class="billboard-slider">
								<div>
									<p>Подбор квартир на этапе строительства <br> и сопровождение всего цикла  инвестирования</p>
								</div>
								<div>
									<p>Подбор строительства квартир на этапе строительства <br> и сопровождение всего цикла инвестирования</p>
								</div>
								<div>
									<p>Подбор квартир на этапе строительства <br> и сопровождение всего цикла инвестирования сопровождение</p>
								</div>
							</div>
							<a href="#" class="button">Подобрать Недвижимость</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<section class="indent-block" id="section_1">
			<div class="container-fluid mb-lg">
				<h2 class="text-center">Наши услуги</h2>
				<div class="service-info-area">
					<div class="text-section">
						<div class="limit-box">
							<h3>Инвестиции в Новостройки</h3>
							<p>Сейчас управление недвижимостью становится все более и более популярным на территории России. Это связано с тем, что несмотря на кризис и следующий за ним тяжелый выход, недвижимости становится все больше.</p>
							<p>Ни для кого не секрет, что самым популярным вложением у физических лиц в России остается покупка недвижимости. </p>
							<a href="#" class="more-link">Подробнее</a>
						</div>
					</div>
					<div class="image-section">
						<div class="image-box" style="background-image: url('/images/content/img_1.jpg')"></div>
						<img class="small-img" src="/images/content/img_2.jpg" data-parallax='{"y": -80, "smoothness": 10}' alt="">
						<img class="decor-top" src="/images/decor/img_1.png" data-parallax='{"y": -40, "smoothness": 20}' alt="">
						<img class="decor-bottom" src="/images/decor/img_2.png" data-parallax='{"y": -120, "smoothness": 30}' alt="">
					</div>
				</div>
				<div class="products">
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_3.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_4.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_5.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_6.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="text-center">
					<a href="#" class="button">Другие варианты</a>
				</div>
			</div>
			<div class="container-fluid mb-lg">
				<div class="service-info-area reverse">
					<div class="text-section">
						<div class="limit-box">
							<h3>Инвестиции <br> в Девелоперские проекты</h3>
							<p>Сейчас управление недвижимостью становится все более и более популярным на территории России. Это связано с тем, что несмотря на кризис и следующий за ним тяжелый выход, недвижимости становится все больше.</p>
							<p>Ни для кого не секрет, что самым популярным вложением у физических лиц в России остается покупка недвижимости. </p>
							<a href="#" class="more-link">Подробнее</a>
						</div>
					</div>
					<div class="image-section">
						<div class="image-box" style="background-image: url('/images/content/img_7.jpg')"></div>
						<img class="small-img" src="/images/content/img_8.jpg" data-parallax='{"y": -80, "smoothness": 10}' alt="">
						<img class="decor-top" src="/images/decor/img_3.png" data-parallax='{"y": -40, "smoothness": 20}' alt="">
						<img class="decor-bottom" src="/images/decor/img_4.png" data-parallax='{"y": -120, "smoothness": 30}' alt="">
					</div>
				</div>
				<div class="products">
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_9.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_10.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_11.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_12.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="text-center">
					<a href="#" class="button">Другие варианты</a>
				</div>
			</div>
			<div class="container-fluid mb-lg">
				<div class="service-info-area">
					<div class="text-section">
						<div class="limit-box">
							<h3>Покупка</h3>
							<p>Сейчас управление недвижимостью становится все более и более популярным на территории России. Это связано с тем, что несмотря на кризис и следующий за ним тяжелый выход, недвижимости становится все больше.</p>
							<p>Ни для кого не секрет, что самым популярным вложением у физических лиц в России остается покупка недвижимости. </p>
							<a href="#" class="more-link">Подробнее</a>
						</div>
					</div>
					<div class="image-section">
						<div class="image-box" style="background-image: url('/images/content/img_13.jpg')"></div>
						<img class="small-img" src="/images/content/img_14.jpg" data-parallax='{"y": -80, "smoothness": 10}' alt="">
						<img class="decor-top" src="/images/decor/img_2.png" data-parallax='{"y": -40, "smoothness": 20}' alt="">
						<img class="decor-bottom" src="/images/decor/img_1.png" data-parallax='{"y": -120, "smoothness": 30}' alt="">
					</div>
				</div>
				<div class="products">
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_15.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_9.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_16.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_17.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="text-center">
					<a href="#" class="button">Другие варианты</a>
				</div>
			</div>
			<div class="container-fluid mb-lg">
				<div class="service-info-area reverse">
					<div class="text-section">
						<div class="limit-box">
							<h3>Аренда</h3>
							<p>Сейчас управление недвижимостью становится все более и более популярным на территории России. Это связано с тем, что несмотря на кризис и следующий за ним тяжелый выход, недвижимости становится все больше.</p>
							<p>Ни для кого не секрет, что самым популярным вложением у физических лиц в России остается покупка недвижимости. </p>
							<a href="#" class="more-link">Подробнее</a>
						</div>
					</div>
					<div class="image-section">
						<div class="image-box" style="background-image: url('/images/content/img_1.jpg')"></div>
						<img class="small-img" src="/images/content/img_2.jpg" data-parallax='{"y": -80, "smoothness": 10}' alt="">
						<img class="decor-top" src="/images/decor/img_1.png" data-parallax='{"y": -40, "smoothness": 20}' alt="">
						<img class="decor-bottom" src="/images/decor/img_2.png" data-parallax='{"y": -120, "smoothness": 30}' alt="">
					</div>
				</div>
				<div class="products">
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_3.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_4.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_5.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
					<div class="product-item">
						<a href="#" class="add-to-wishList"><svg><use xlink:href="/images/svg/sprite.svg#heart-icon"></use></svg></a>
						<a href="#" class="product-link">
							<div class="image-box" style="background-image: url('/images/content/img_6.jpg')">
								<div class="product-details"><div class="cell">S = 450 м²</div><div class="cell">4 спальни</div></div>
							</div>
							<p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>
							<div class="row flex-row align-row">
								<div class="col-xs-6">
									<span class="price">от 155 млн руб</span>
								</div>
								<div class="col-xs-6 text-right">
									<span class="pseudo-btn">Выбрать</span>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="text-center">
					<a href="#" class="button">Другие варианты</a>
				</div>
			</div>
			<div class="container">
				<ul class="service-links">
					<li>
						<a href="#" class="item-link">
							<div class="icon-box"><svg><use xlink:href="/images/svg/sprite.svg#rent"></use></svg></div>
							<div class="text-box">
								<h3>Продать</h3>
								<p>Делаем оптимальный подбор премиальных объектов под потребности клиента</p>
								<span class="more-link">Подробнее</span>
							</div>
						</a>
					</li>
					<li>
						<a href="#" class="item-link">
							<div class="icon-box"><svg><use xlink:href="/images/svg/sprite.svg#manage"></use></svg></div>
							<div class="text-box">
								<h3>Управление недвижимостью</h3>
								<p>Консультируем по оценке стоимости объектов недвижимости</p>
								<span class="more-link">Подробнее</span>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</section>
		<section class="subscribe-section" style="background-image: url('/images/banners/img_2.jpg')">
			<div class="container">
				<h3 class="text-center">Подпишитесь на рассылку!</h3>
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
								<option value="2">Статьи блога</option>
								<option value="3">Объекты и статьи блога</option>
							</select>
						</div>
						<input type="submit" class="button" value="Отправить">
					</div>
					<label class="checkbox-label"><input type="checkbox" name="checkbox" checked><span>I have read and agree to the <a href="#" target="_blank">Terms&Conditions</a> and <a href="#" target="_blank">Privacy policy</a>.</span></label>
				</form>
			</div>
		</section>
		<section class="indent-block">
			<h2 class="text-center">Как мы работаем</h2>
			<div class="video-box mb-md" style="background-image: url('/images/banners/img_3.jpg')">
				<a href="https://www.youtube.com/embed/l6pDOwNeTrg?rel=0&amp;controls=0&amp;showinfo=0" class="play-btn venobox-btn" data-autoplay="true" data-vbtype="video"><svg><use xlink:href="/images/svg/sprite.svg#triangle-icon"></use></svg></a>
			</div>
			<div class="container">
				<div class="service-slider simple-slider">
					<div>
						<div class="inner-box">
							<span class="slider-count">01</span>
							<h5>Consultation</h5>
							<p>We will provide you with free initial consultation with our expert. During the meeting you will receive a detailed overview on the current state of real estate market and its trends.  Our expert will help you define key parameters of your ideal property.</p>
						</div>
					</div>
					<div>
						<div class="inner-box">
							<span class="slider-count">02</span>
							<h5>Service Contract sign off</h5>
							<p>We sign a service agreement with you.</p>
						</div>
					</div>
					<div>
						<div class="inner-box">
							<span class="slider-count">03</span>
							<h5>Analysis of options</h5>
							<p>Our expert will make a thorough research for options that will meet your criteria. You will receive an invaluable comparative analysis of the options.</p>
						</div>
					</div>
					<div>
						<div class="inner-box">
							<span class="slider-count">04</span>
							<h5>Viewings</h5>
							<p>Our expert will organise and accompany you for viewings of selected options.</p>
						</div>
					</div>
					<div>
						<div class="inner-box">
							<span class="slider-count">05</span>
							<h5>Consultation</h5>
							<p>We will provide you with free initial consultation with our expert. During the meeting you will receive a detailed overview on the current state of real estate market and its trends.  Our expert will help you define key parameters of your ideal property.</p>
						</div>
					</div>
				</div>
				<div class="preview-post flex-row">
					<div class="text-box">
						<blockquote>
							<p>Мы соблюдаем этические и профессиональные нормы, и ценим время клиентов</p>
						</blockquote>
						<p>Экспертность компании — позволяет продать больше и дороже. Конкурентные преимущества компании с документальными фактами. К примеру, если компания действительно доставляет быстрее конкурентов, то пишите за какое время. Если у компании есть ноу-хау, стройте маркетинг на нём.</p>
						<p>Достижения компании в цифрах («800 тысяч тонн отгруженного сырья за год», «250 торговых точек по ЦФО»), но правда, а не вымысел. Лицензии, сертификаты, отраслевые награды. Информация о компании в СМИ. Будьте осторожны: заказные статьи в малотиражных СМИ негативно воспринимаются профессионалами.</p>
						<a href="#" class="more-link">Подробнее о компании</a>
					</div>
					<div class="img-box">
						<div class="position-box">
							<img src="/images/content/img_18.jpg" alt="">
							<a href="#" class="social-link"><svg><use xlink:href="/images/svg/sprite.svg#linkedin-square"></use></svg></a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="blog-section indent-block">
			<div class="container">
				<div class="posts-list">
					<div class="post-group single">
						<a href="#" class="post">
							<div class="img-box" style="background-image: url('/images/content/img_19.jpg')"></div>
							<div class="text-box">
								<header>
									<time datetime="2018-02-23">23.02.2018</time>
									<span class="post-author"><svg><use xlink:href="/images/svg/sprite.svg#user"></use></svg> Анна</span>
								</header>
								<h4>Заголовок статьи</h4>
								<p>Инвестиционная продажа жилья в столичном регионе и под Москвой. Мы предлагаем квартиры, пентхаусы и апартаменты в самых престижных районах столицы...</p>
							</div>
						</a>
					</div>
					<div class="post-group">
						<a href="#" class="post">
							<div class="img-box" style="background-image: url('/images/content/img_20.jpg')"></div>
							<div class="text-box">
								<header>
									<time datetime="2018-02-23">23.02.2018</time>
									<span class="post-author"><svg><use xlink:href="/images/svg/sprite.svg#user"></use></svg> Анна</span>
								</header>
								<h4>Очень длинный заголовок статьи, который даже в 2 строки</h4>
							</div>
						</a>
						<a href="#" class="post">
							<div class="img-box" style="background-image: url('/images/content/img_21.jpg')"></div>
							<div class="text-box">
								<header>
									<time datetime="2018-02-23">23.02.2018</time>
									<span class="post-author"><svg><use xlink:href="/images/svg/sprite.svg#user"></use></svg> Анна</span>
								</header>
								<h4>Заголовок статьи</h4>
							</div>
						</a>
					</div>
				</div>
				<div class="text-center">
					<a href="#" class="button">Все статьи</a>
				</div>
			</div>
			<img class="decor-left" src="/images/decor/img_5.png" data-parallax='{"y": -60, "smoothness": 30}' alt="">
			<img class="decor-right" src="/images/decor/img_6.png" data-parallax='{"y": -100, "smoothness": 15}' alt="">
			<img class="decor-bottom" src="/images/decor/img_7.png" data-parallax='{"y": -140, "smoothness": 45}' alt="">
		</div>

	</main>

	@include('site.block.sharing')
@endsection
