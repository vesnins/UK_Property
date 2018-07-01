@extends('admin::layouts.default')
@section('title',"Админ панель SMV 4.0DEV")
@section('content')

  @include('admin::layouts.left-menu')
  @include('admin::layouts.top-menu')
  <div class="right_col" role="main">
    <br/>
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>
              {{ $module['translate_key'] ?? '' ? trans('admin::main.' . $module['translate_key']) : $module['name_module'] }}

              @if(empty($data))
                <small>@lang('admin::main.creating')</small>
              @else
                <small>@lang('admin::main.editing')</small>
              @endif
            </h2>

            <div class="nav navbar-right panel_toolbox">
              <a href="/admin/engineer/update" class="btn btn-primary">
                @lang('admin::main.create')
              </a>
            </div>

            <hr class="clear">

            <div class="clear">
              <ul class="nav list-group">
                @foreach($modules as $module)
                  @if(!is_numeric($module['parent'] ?? false))
                    <li class="list-group-item">
                      <a href="/admin/engineer/update/{{ $module['link_module'] }}">
                        <div>{{ $module['name_module'] }}</div>
                      </a>

                      <ul>
                        @foreach($modules as $m)
                          @if((int) $m['parent'] === (int) $module['id'])
                            <li class="list-group-item">
                              <a href="/admin/engineer/update/{{ $m['menu_table_name'] }}">
                                <div>{{ $m['name_module'] }}</div>
                              </a>
                            </li>
                          @endif
                        @endforeach
                      </ul>
                    </li>
                  @endif
                @endforeach
              </ul>
            </div>

            <div class="container">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop