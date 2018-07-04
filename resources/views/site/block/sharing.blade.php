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
    <svg>
      <use xlink:href="/images/svg/sprite.svg#facebook"></use>
    </svg>
    {{--123--}}
  </a>
</li>
<li>
  <a
    href="javascript:void(0)"

    onclick="Share.linkedin(
      document.location.href,
      '{{ $meta['title'] ?? '' }}',
      '',
      '{{ $meta['description'] ?? '' }}'
      )"
  >
    <svg>
      <use xlink:href="/images/svg/sprite.svg#linkedin"></use>
    </svg>
    {{--95--}}
  </a>
</li>
