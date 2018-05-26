<div class="sharing">
	<div class="content">
		<ul>
			<li>
				<a
					href="javascript:void(0)"

					onclick="Share.facebook(
						document.location.href,
						'{{ $meta['title'] ?? '' }}',
						'',
						'{{ $meta['description'] ?? '' }}'
						)"
				>
					<i class="fb">
						<svg>
							<use xlink:href="/images/svg/sprite.svg#ico_share-fb"></use>
						</svg>
					</i>
					{{--<span>2356</span>--}}
				</a>
			</li>

			<li>
				<a
					href="javascript:void(0)"

					onclick="Share.google(
						document.location.href,
						'{{ $meta['title'] ?? '' }}',
						'',
						'{{ $meta['description'] ?? '' }}'
						)"
				>
					<i class="gp">
						<svg>
							<use xlink:href="/images/svg/sprite.svg#ico_share-google"></use>
						</svg>
					</i>
					{{--<span>355</span>--}}
				</a>
			</li>

			<li>
				<a
					href="javascript:void(0)"

					onclick="Share.twitter(
						document.location.href,
						'{{ $meta['title'] ?? '' }}',
						'{{ $meta['description'] ?? '' }}'
						)"
				>
					<i class="tw">
						<svg>
							<use xlink:href="/images/svg/sprite.svg#ico_share-tw"></use>
						</svg>
					</i>
					{{--<span>45</span>--}}
				</a>
			</li>

			<li>
				<a
					href="javascript:void(0)"

					onclick="Share.vkontakte(
						document.location.href,
						'{{ $meta['title'] ?? '' }}',
						'',
						'{{ $meta['description'] ?? '' }}'
						)"
				>
					<i class="vk">
						<svg>
							<use xlink:href="/images/svg/sprite.svg#ico_share-vk"></use>
						</svg>
					</i>
					{{--<span>233</span>--}}
				</a>
			</li>
		</ul>
	</div>
</div>

@push('footer')
<script>
	$(document).ready(function() {
		$('.pluso-more').remove();
//		$('.pluso-facebook').replaceWith('<i class="fb pluso-facebook"><svg>' +
//			'<use xlink:href="/images/svg/sprite.svg#ico_share-fb"></use>' +
//			'</svg></i>');
	})
</script>
@endpush