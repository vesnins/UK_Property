@php($catalog_marker = [])
@php($path = '/images/files/small/')

@php($url = [
  'catalog_new_building'         => 'invest-in-a-new-building',
  'catalog_development_projects' => 'invest-in-development-projects',
  'catalog_buy'                  => 'buy',
  'catalog_rent'                 => 'rent',
])

@foreach($catalog as $k => $v)
  @php($catalog_marker[$k]['coordinates'] = $v['coordinates'])
  @php($catalog_marker[$k]['little_description'] = $langSt($v['little_description']) )
  @php($catalog_marker[$k]['name'] = $langSt($v['name']) )
  @php($catalog_marker[$k]['choose'] = __('main.choose'))
  @php($catalog_marker[$k]['url'] = "/catalog/" . ($name_url ?? $url[$v['name_table']]) . '/' .
($v['translation'] ?? $v['id']) )
  @php($catalog_marker[$k]['more'] = __('main.more'))

  @php($catalog_marker[$k]['img'] = $v['file'] && $v['file'] !== '1'
      ? $v['crop'] && $v['crop'] !== '1' ? $path . $v['crop'] : $path . $v['file']
      : '/images/files/no-image.jpg')

  @if($v['price_money_from'] !== null || $v['price_money_to'] !== null || $v['price_money'] !== null)
    @if($v['price_money_from'] ?? false)
      @php($catalog_marker[$k]['price'] = '£' . number_format($v['price_money_from'], 0, ',', ',') . ' - ' .
       number_format($v['price_money_to'], 0, ',', ','))
    @else
      @php($catalog_marker[$k]['price'] = '£' . number_format($v['price_money'], 0, ',', ','))
    @endif
  @endif

  @if($v['area_from'] !== null || $v['area_to'] !== null || $v['area'] !== null)
    @if($v['area_from'] ?? false)
      @php($catalog_marker[$k]['area'] = 'S =<div class="s-pl">' + $v['area_from'] + '</div> -
      <div class="s-pl">' + $v['area_to'] + ' </div>' . __('main.м_2'))
    @else
      @php($catalog_marker[$k]['area'] = '<div class="s-pl">' + $v['area'] + '</div>' . __('main.м_2'))
    @endif
  @endif

@if($v['bedrooms_from'] !== null || $v['bedrooms_to'] !== null || $v['bedrooms'] !== null)
  @if($v['bedrooms_from'] ?? false)
    @php($catalog_marker[$k]['bedrooms'] = $v['bedrooms_from'] . ' - ' . $v['bedrooms_to'] . ' ' . __('main.bedrooms'))
  @else
    @php($catalog_marker[$k]['bedrooms'] = $v['bedrooms'] . ' ' . __('main.bedrooms'))
  @endif
@endif
@endforeach

<script>
window.objectCurrent = {!! json_encode($catalog_marker) !!} || [];
</script>
<div class="products">
@forelse($catalog as $val)
@php($img = $val['file'] && $val['file'] !== '1'
 ? $val['crop'] && $val['crop'] !== '1' ? $path . $val['crop'] : $path . $val['file']
 : '/images/files/no-image.jpg'
)

@php($is_favorite = array_search($val['id'], $favorites_id ?? []) !== false ? true : false)


<div class="product-item {{ $val['in_portfolio'] ? 'sold-product' : '' }}">
 @if($name_url || $show_like)
   <a href="javascript:void(0)"
     class="add-to-wishList like-button {!! $is_favorite ? 'active' : '' !!} like-button-{{ $val['id'] }}"

     onclick="catAll.addCart(
       '{{ $val['id'] }}',
       '{!! $is_favorite ? 'remove' : 'add' !!}',
       '{{ $name_url ?? $url[$val['name_table']] }}'
       )"
   >
     <svg>
       <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
     </svg>
   </a>
 @else
   <a
     href="javascript:void(0)"
     class="del-btn like-button {!! $is_favorite ? 'active' : '' !!} like-button-{{ $val['id'] }}"
     onclick="catAll.addCart('{{ $val['id'] }}', 'remove', '')"
   >
     <svg>
       <use xlink:href="/images/svg/sprite.svg#close-icon"></use>
     </svg>
   </a>
 @endif

 <style>
   .s-pl {
     display: inline;
   }
 </style>
 <a
   href="/catalog/{{ $name_url ?? $url[$val['name_table']] }}/{{ $val['translation'] ?? $val['id'] }}"
   class="product-link"
   target="_blank"
 >
   <div class="image-box" style="background-image: url('{{ $img }}')">
     <div class="product-details">
       @if($val['area_from'] !== null || $val['area_to'] !== null || $val['area'] !== null)
         <div class="cell">
           @if($val['area_from'] ?? false)
             S =
             <div class="s-pl">{{ $val['area_from'] }}</div>
             -
             <div class="s-pl">{{ $val['area_to'] }}</div>
             @lang('main.м_2')
           @else
             S = <div class="s-pl">{{ $val['area'] }}</div> @lang('main.м_2')
           @endif
         </div>
       @endif

       @if($val['bedrooms_from'] !== null || $val['bedrooms_to'] !== null || $val['bedrooms'] !== null)
         <div class="cell">
           @if($val['bedrooms_from'] ?? false)
             {{ $val['bedrooms_from'] }} - {{ $val['bedrooms_to'] }}
           @else
             {{ $val['bedrooms'] }}
           @endif
             @lang('main.bedrooms')
         </div>
         @endif
     </div>
   </div>

   <p>{{ $langSt($val['little_description']) }}</p>

   <div class="row flex-row align-row">
     <div class="col-xs-9">
       @if($val['price_money_from'] !== null || $val['price_money_to'] !== null || $val['price_money'] !== null)
         <span class="price">
           @if($val['price_money_from'] ?? false)
             £{{ number_format($val['price_money_from'], 0, ',', ',') }}
             -
             £{{ number_format($val['price_money_to'], 0, ',', ',') }}
           @else
             £{{ number_format($val['price_money'], 0, ',', ',') }}
           @endif
         </span>
       @endif
     </div>

     <div class="col-xs-3 text-right"><span class="pseudo-btn">@lang('main.choose')</span></div>
   </div>
 </a>
</div>
@empty
@if(!isset($no_empty_message))
 <p style="border-radius: 3px; text-align: center; border: solid 1px #eeeeee; padding: 15px; margin: 15px; width: 100%">
   @lang('main.empty_result')
 </p>
@endif
@endforelse
</div>

@if($paginate ?? false)
@if(method_exists($catalog, 'links'))
{!! $catalog->links('site.block.pagination') !!}
@endif
@endif

@if($paginate ?? false && $count ?? false && $limit ?? false)
@if(round($count / $limit) > 1)
<ul class="pagination">
 @foreach(range(1, ((int) $count)) as $v)
   @php($active = (int) $pagination === $v ? 'active' : '')
   @php($current = (int) $pagination === $v ? 'current' : '')

   @if($v === 1 && (int) $pagination !== $v)
     <li class="nav-btn prev">
       <a href="/portfolio/{{ $v }}" class="page-one prev">
         <svg>
           <use xlink:href="/images/svg/sprite.svg#arrow-left"></use>
         </svg>
       </a>
     </li>
   @endif

   <li class="{{ $active }}"><a href="/portfolio/{{ $v }}" class="page-one {{ $current }}">{{ $v }}</a></li>

   @if($count === $v && (int) $pagination !== $v)
     <li class="nav-btn next">
       <a href="/portfolio/{{ $v }}" class="page-one next">
         <svg>
           <use xlink:href="/images/svg/sprite.svg#arrow-right"></use>
         </svg>
       </a>
     </li>
   @endif
 @endforeach
</ul>
@endif
@endif
