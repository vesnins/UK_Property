@php($i = 0)
@php($how_working = $langSt($how_working))

@foreach($how_working['how_working_name'] ?? [] as $key => $how_work)
  @if(!empty($how_work))
    <div>
      <div class="inner-box">
        <span class="slider-count">{{ str_pad($i,  2, '0', STR_PAD_LEFT) }}</span>
        <h5>{{ $how_working['how_working_name'][$key] }}</h5>
        <p>{{ $how_working['how_working_text'][$key] }}</p>
      </div>
    </div>

    @php($i++)
  @endif
@endforeach

