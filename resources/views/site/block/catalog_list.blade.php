<div class="products">
  @foreach($catalog as $val)
    @php($path = '/images/files/small/')

    @php($img = $val['file']
      ? $val['crop'] ? $path . $val['crop'] : $path . $val['file']
      : '/images/files/no-image.jpg'
    )

    <div class="product-item">
      <a href="#" class="add-to-wishList">
        <svg>
          <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
        </svg>
      </a>

      <a href="#" class="product-link">
        <div class="image-box" style="background-image: url('{{ $img }}')">
          <div class="product-details">
            <div class="cell">S = 450 м²</div>
            <div class="cell">4 спальни</div>
          </div>
        </div>

        <p>Новый пентхаус в Вестминстере это уникальный новый девелопмент в историческом центре излучине Темзы</p>

        <div class="row flex-row align-row">
          <div class="col-xs-6"><span class="price">от 155 млн руб</span></div>
          <div class="col-xs-6 text-right"><span class="pseudo-btn">Выбрать</span></div>
        </div>
      </a>
    </div>
  @endforeach
</div>

@if($paginate ?? false)
  {!! $catalog->links('site.block.pagination') !!}
@endif
