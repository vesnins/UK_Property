<div class="products">
  @forelse($catalog as $val)
    @php($path = '/images/files/small/')

    @php($img = $val['file']
      ? $val['crop'] ? $path . $val['crop'] : $path . $val['file']
      : '/images/files/no-image.jpg'
    )

    @php($is_favorite = array_search($val['id'], $favorites_id ?? []) !== false ? true : false)

    <div class="product-item">
      @if($name_url)
        <a href="javascript:void(0)"
          class="add-to-wishList like-button {!! $is_favorite ? 'active' : '' !!} like-button-{{ $val['id'] }}"

          onclick="catAll.addCart(
            '{{ $val['id'] }}',
            '{!! $is_favorite ? 'remove' : 'add' !!}',
            '{{ $name_url ?? $val['name_url'] }}'
            )"
        >
          <svg>
            <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
          </svg>
        </a>
      @else
        <a href="javascript:void(0)"
          class="del-btn like-button {!! $is_favorite ? 'active' : '' !!} like-button-{{ $val['id'] }}"
          onclick="catAll.addCart('{{ $val['id'] }}', 'remove', '')"
        >
          <svg>
            <use xlink:href="/images/svg/sprite.svg#close-icon"></use>
          </svg>
        </a>
      @endif

      <a href="/catalog/{{ $name_url ?? $val['name_url'] }}/{{ $val['translation'] ?? $val['id'] }}" class="product-link">
        <div class="image-box" style="background-image: url('{{ $img }}')">
          <div class="product-details">
            <div class="cell">S = {{ $val['area_from'] }} м²</div>
            <div class="cell">{{ $val['bedrooms_from'] }} спальни</div>
          </div>
        </div>

        <p>{{ $langSt($val['name']) }}</p>

        <div class="row flex-row align-row">
          <div class="col-xs-6"><span class="price">от {{ $val['price_money_from'] }} млн руб</span></div>
          <div class="col-xs-6 text-right"><span class="pseudo-btn">Выбрать</span></div>
        </div>
      </a>
    </div>
  @empty
    <p style="border-radius: 3px; text-align: center; border: solid 1px #eeeeee; padding: 15px; margin: 15px; width: 100%">
      @lang('main.empty_result')
    </p>
  @endforelse
</div>

@if($paginate ?? false)
  {!! $catalog->links('site.block.pagination') !!}
@endif
