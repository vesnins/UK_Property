<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width" name="viewport" />
	<meta name="author" content="{{ $meta['author'] ?? '' }}" />
	<title>{{ $meta['title'] ?? '' }}</title>
	<meta content="{{ $meta['description'] ?? '' }}" name="description">
	<meta content="{{ $meta['keywords'] ?? '' }}" name="keywords">
	<meta http-equiv="Last-Modified" content="{{ ($meta['created_at'] ?? '') ?? ($meta['updated_at'] ?? '') }}" />
	<link rel="icon" href="/favicon.ico" sizes="32x32" />
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet" />
	<link href="/css/styles.min.css" rel="stylesheet" />
	<link href="/css/common.css" rel="stylesheet" />
	<script type="text/javascript" src="/js/lodash.min.js"></script>
	<script type="text/javascript" src="/js/filters-villas.js"></script>
	<script type="text/javascript" src="/js/filters-full.js"></script>

	<meta property="og:title" content="{{ $meta['title'] ?? '' }}" />
	{{--<meta property="og:type" content="movie"/>--}}
	<meta property="og:url" content="http://greecobooking.niws.ru/villas/1" />
	<meta property="og:image" content="{{ $meta['og_image'] ?? '' }}" />
	{{--<meta property="og:site_name" content="IMDb"/>--}}
	{{--<meta property="fb:admins" content="USER_ID"/>--}}
	<meta property="og:description" content="{{ $meta['description'] ?? '' }}" />
</head>
<body>
<div id="wrapper">
	<header id="header" class="header">
		<div class="content">
			<div class="header--wrap">
				<div class="logo">
					<a href="/">
						<svg xmlns="http://www.w3.org/2000/svg" width="249" height="22" viewBox="0 0 3365 293" shape-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"><path d="m145 183v-58h149c0 1 0 4 0 6 1 2 1 6 1 10 0 48-13 85-39 112-25 26-61 40-107 40-22 0-42-4-60-11-18-6-33-17-47-31-13-13-24-29-31-47-7-18-11-38-11-58 0-20 4-40 11-57 7-18 17-33 32-47 14-14 30-24 48-31 18-7 37-11 58-11 28 0 52 6 73 17 21 10 39 26 53 48l-66 31c-8-10-17-18-27-24-9-5-20-8-33-8-23 0-40 8-54 23-13 15-19 36-19 63 0 26 6 47 19 62 14 16 31 23 54 23 20 0 36-5 49-14 13-9 20-22 22-38h-75m196 103v-279h80c31 0 52 1 65 4 12 3 23 8 31 14 11 8 18 18 24 29 5 12 8 25 8 40 0 21-6 39-16 52-11 14-26 23-47 27l76 113h-86l-64-109v109h-71m71-147h15c16 0 28-3 35-9 8-5 12-14 12-26 0-14-4-24-11-30-7-6-19-9-35-9h-16v74m179 147v-279h171v61h-96v48h91v60h-91v47h96v63h-171m424-268v83c-10-12-21-20-31-26-10-5-22-8-33-8-22 0-40 8-53 23-14 14-21 34-21 58 0 22 7 41 21 56 14 14 31 22 53 22 11 0 23-3 33-8 10-6 21-14 31-26v83c-12 6-24 11-36 14-12 3-24 4-36 4-15 0-29-2-42-5-13-4-25-10-36-17-21-14-37-32-48-53-10-21-16-45-16-72 0-21 4-40 10-58 7-17 18-33 32-47 13-14 28-24 45-31 16-7 35-10 55-10 12 0 24 1 36 4 12 3 24 8 36 14m330 129c0 20-4 39-11 56-8 18-18 34-32 47-15 14-31 25-49 32-19 8-38 11-57 11-20 0-39-3-58-11-18-7-34-18-48-32-14-13-25-29-32-47-8-18-12-36-12-56 0-20 4-39 12-57 7-17 18-33 32-47 14-13 30-24 48-31 19-8 38-12 58-12 20 0 39 4 57 12 18 7 35 18 49 31 14 14 24 30 32 47 7 18 11 37 11 57m-149 82c21 0 38-8 52-23 14-16 21-36 21-59 0-24-7-43-21-59-14-15-32-23-52-23-22 0-39 8-53 23-14 16-20 35-20 59 0 24 6 43 20 59 14 15 31 23 53 23m267-111h15c19 0 32-2 39-6 7-4 11-11 11-21 0-11-4-18-10-23-7-4-19-6-38-6h-17v56m-71 168v-279h77c32 0 54 1 66 3 13 2 23 5 32 10 11 6 19 14 24 23 5 10 8 21 8 33 0 16-4 29-12 38-8 10-21 17-39 22 20 1 36 8 47 21 11 12 17 28 17 49 0 15-4 28-10 40-6 11-15 20-27 26-9 5-21 9-35 11-14 2-37 3-69 3h-79m71-57h27c18 0 31-2 38-7 8-4 11-12 11-23 0-11-3-19-10-24-7-5-19-7-38-7h-28v61m481-82c0 20-4 39-11 56-7 18-18 34-32 47-14 14-31 25-49 32-18 8-37 11-57 11-20 0-39-3-57-11-19-7-35-18-48-32-15-13-26-29-33-47-8-18-11-36-11-56 0-20 3-39 11-57 7-17 18-33 33-47 13-13 29-24 48-31 18-8 37-12 57-12 20 0 39 4 57 12 19 7 35 18 49 31 14 14 24 30 32 47 7 18 11 37 11 57m-149 82c21 0 38-8 52-23 14-16 21-36 21-59 0-24-7-43-21-59-14-15-31-23-52-23-21 0-39 8-52 23-14 16-21 35-21 59 0 24 7 43 20 59 14 15 31 23 53 23m483-82c0 20-3 39-11 56-7 18-18 34-32 47-14 14-30 25-49 32-18 8-37 11-57 11-20 0-39-3-57-11-18-7-34-18-48-32-15-13-25-29-33-47-7-18-11-36-11-56 0-20 4-39 11-57 8-17 18-33 33-47 14-13 30-24 48-31 18-8 37-12 57-12 20 0 39 4 58 12 18 7 34 18 48 31 14 14 25 30 32 47 8 18 11 37 11 57m-149 82c21 0 39-8 53-23 13-16 20-36 20-59 0-24-7-43-21-59-14-15-31-23-52-23-21 0-38 8-52 23-14 16-21 35-21 59 0 24 7 43 21 59 13 15 31 23 52 23m197 57v-279h75v127l89-127h88l-103 136 112 143h-95l-91-125v125h-75m285 0v-279h77v279h-77m138 0v-279h74l106 143c2 3 5 9 9 18 5 9 10 19 16 32-2-12-3-22-3-31-1-9-2-17-2-24v-138h74v279h-74l-105-144c-2-3-6-9-10-18-5-9-10-19-15-31 1 12 2 22 3 31 1 9 1 17 1 24v138h-74m466-103v-58h150c0 1 0 4 0 6 0 2 0 6 0 10 0 48-13 85-38 112-25 26-61 40-107 40-23 0-43-4-60-11-18-6-34-17-48-31-13-13-23-29-30-47-8-18-11-38-11-58 0-20 3-40 10-57 7-18 18-33 32-47 14-14 30-24 48-31 18-7 38-11 59-11 27 0 51 6 73 17 21 10 38 26 53 48l-66 31c-8-10-17-18-27-24-10-5-21-8-33-8-23 0-41 8-54 23-13 15-20 36-20 63 0 26 7 47 20 62 13 16 31 23 54 23 19 0 35-5 48-14 13-9 21-22 23-38h-76" fill-rule="nonzero"/></svg>
					</a>
				</div>

				<nav class="nav">
					<div class="nav-table">
						<div class="main-navigate">
							<ul>
{{--								{{ print_r($menu) }}--}}
								@foreach($menu as $val)
									@if(current($val)['cat'] === 0)
										@foreach($val as $v)
											@if($v['translation'] == 'location')
												<li class="has-submenu">
													<span class=""><span>{{ $langSt($v['name']) }}</span></span>
													<div class="submenu">
														<ul>
															@foreach($menu[$v['id']] as $vSub)
																<li>
																	<a
																		href="/{{ $v['translation'] ?? $v['id'] }}/{{ $vSub['translation'] ?? $vSub['id'] }}"
																		class="@if(($vSub['translation'] ?? $vSub['id']) === $segment1) active @endif"
																	>
																		{{ $langSt($vSub['name']) }}
																	</a>
																</li>
															@endforeach
														</ul>
													</div>
												</li>
											@else
												<li
													style="{{ ($v['translation'] == 'favorite' && !$isShowFavorite) ? 'display: none;' : '' }}"
													class="{{ $v['translation'] == 'favorite' ? 'top-favorite' : '' }}"
												>
													<a
														href="/{{ $v['translation'] ?? $v['id'] }}"
														class="@if(($v['translation'] ?? $v['id']) === $segment1) active @endif"
													>
														<span>{{ $langSt($v['name']) }}</span>
														{!! $v['translation'] == 'favorite' ? '<span class="cnt">'. $isShowFavorite . '</span>' : '' !!}
													</a>
												</li>
											@endif
										@endforeach
									@endif
								@endforeach
							</ul>
						</div>
					</div>
				</nav>

				<div class="elements">
					<div class="search">
						<div class="form" id="searchForm">
							<form action="/search">
								<div class="field">
									<input id="searchInput" name="q" type="text" placeholder="@lang('main.search')">
								</div>

								<button type="submit">
									<svg>
										<use xlink:href="/images/svg/sprite.svg#ico_search"></use>
									</svg>
								</button>
							</form>
						</div>

						<label id="search_btn" for="searchInput" class="search-icon">
							<i>
								<svg>
									<use xlink:href="/images/svg/sprite.svg#ico_search"></use>
								</svg>
							</i>
						</label>
					</div>

					<div class="language has-submenu">
						<ul>
							@if($lang === 'en')
								<li class="{!! $lang === 'en' ? 'current' : '' !!}"><a style="z-index: 9999" href="?setLang=en"><span>EN</span></a></li>
								<li class="{!! $lang === 'ru' ? 'current' : '' !!}"><a style="z-index: 9999" href="?setLang=ru">RU</a></li>
							@else
								<li class="{!! $lang === 'ru' ? 'current' : '' !!}"><a style="z-index: 9999" href="?setLang=ru">RU</a></li>
								<li class="{!! $lang === 'en' ? 'current' : '' !!}"><a style="z-index: 9999" href="?setLang=en"><span>EN</span></a></li>
							@endif
						</ul>
					</div>

					<div class="request">
						<a href="/selection-request" class="btn btn_bord">@lang('main.selection_request')</a>
					</div>

					<span id="burger" class="burger">
						<span class="line1"></span>
						<span class="line2"></span>
						<span class="line3"></span>
					</span>
				</div>
			</div>
		</div>

		<div class="scroll-up tablet-hidden">
			<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_scroll-up"></use> </svg></i>
		</div>
	</header>

	<div id="main">