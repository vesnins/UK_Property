@extends('admin::layouts.default')
@section('title',"Админ панель SMV 4.0DEV")
@section('content')

  @include('admin::layouts.left-menu')
  @include('admin::layouts.top-menu')
  <div class="right_col" role="main">
    <br />

    <div class="container">
      <form method="post" class="form-modules">
        <input type="hidden" value="{{ $module['id'] or $modules[count($modules) - 1]['id'] + 1 }}" name="id" />
        <br />
        <br />

        <div class="form-group panel panel-body">
          <div class="panel panel-primary">
            <div class="panel-heading">Название модуля (Пункт меню)</div>

            <div class="panel-body">
              <input
                type="text"
                class="form-control"
                value="{{ $module['name_module'] or '' }}"
                name="name_module"
                placeholder="Название модуля"
              />
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Ссылка модуля (link_module)</div>

            <div class="panel-body">
              <input
                type="text"
                class="form-control"
                value="{{ $module['link_module'] or '' }}"
                name="link_module"
                placeholder="Ссылка модуля"
              />
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Сортировка (sort)</div>

            <div class="panel-body">
              <input
                type="text"
                class="form-control"
                value="{{ $module['sort'] or '' }}"
                name="sort"
                placeholder="Сортировка"
              />
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Класс иконки меню</div>

            <div class="panel-body">
              <input
                type="text"
                class="form-control"
                name="class_module"
                value="{{ $module['class_module'] or '' }}"
                placeholder="Класс иконки меню"
              />
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Количество элементов на странице</div>

            <div class="panel-body">
              <input
                type="text"
                class="form-control"
                name="count_module"
                value="{{ $module['count_module'] or '' }}"
                placeholder="Количество элементов на странице"
              />
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Имя таблицы для селоктов по умолчанию (menu_table_name)</div>

            <div class="panel-body">
              <input
                type="text"
                class="form-control"
                name="count_module"
                value="{{ $module['menu_table_name'] or '' }}"
                placeholder="Имя таблицы для селоктов по умолчанию"
              />
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Ключ перевода (translate_key)</div>

            <div class="panel-body">
              <input
                type="text"
                class="form-control"
                name="count_module"
                value="{{ $module['translate_key'] or '' }}"
                placeholder="Ключ перевода"
              />
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Размеры изображений</div>

            <div class="panel-body">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="panel-heading">Big width</div>

                      <input
                        type="text"
                        class="form-control"
                        name="big_width"
                        value="{{ $module['big_width'] or '' }}"
                        placeholder="Big width"
                      />
                    </div>
                  </div>

                  <div class=" col-md-3">
                    <div class="panel-heading">Big height</div>

                    <input
                      type="text"
                      class="form-control"
                      name="big_height"
                      value="{{ $module['big_height'] or '' }}"
                      placeholder="Big height"
                    />
                  </div>

                  <div class=" col-md-3">
                    <div class="panel-heading">Small width</div>

                    <input
                      type="text"
                      class="form-control"
                      name="small_width"
                      value="{{ $module['small_width'] or '' }}"
                      placeholder="Small width"
                    />
                  </div>

                  <div class="col-md-3">
                    <div class="row">
                      <div class="panel-heading">Small height</div>

                      <input
                        type="text"
                        class="form-control"
                        name="small_height"
                        value="{{ $module['small_height'] or '' }}"
                        placeholder="Small height"
                      />
                    </div>
                  </div>

                  <br />
                </div>
              </div>

              <div class="clear"></div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Способ отображения (views_module)</div>

            <div class="panel-body">
              <select class="select2 col-md-12" name="views_module">
                <option value="table" {{ ($module['views_module'] ?? '') == 'table' ? 'selected' : '' }}>Таблица</option>
                <option value="wood" {{ ($module['views_module'] ?? '') == 'wood' ? 'selected' : '' }}>Дерево</option>
              </select>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Статус отображения (active)</div>

            <div class="panel-body">
              <select class="select2 col-md-12" name="active">
                <option value="1" {{ ($module['active'] ?? '') == '1' ? 'selected' : '' }}>Модуль включен</option>
                <option value="0" {{ ($module['active'] ?? '') == '0' ? 'selected' : '' }}>МОдуль отключен</option>
              </select>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Отображать количество записей (show_count)</div>

            <div class="panel-body">
              <select class="select2 col-md-12" name="show_count" autocomplete="off">
                <option value="1" {{ ($module['show_count'] ?? '') == '1' ? 'selected' : '' }}>Отображать</option>
                <option value="0" {{ ($module['show_count'] ?? '') == '0' ? 'selected' : '' }}>Отображать</option>
              </select>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Родитель (parent)</div>

            <div class="panel-body">
              <select class="select2 col-md-12" name="parent" autocomplete="off">
                <option value="">-</option>

                @foreach($modules as $key => $val)
                  <option
                    value="{{ $val['id'] }}"
                    {{ $module['parent'] === $val['id'] ? 'selected' : '' }}
                  >{{ $val['menu_table_name'] . ': ' . $val['name_module'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Отображать в таблице (column_index)</div>

            <div class="panel-body">
              <select class="select2 col-md-12" name="column_index" multiple autocomplete="off">
                @foreach($plugins as $key => $val)
                  <option
                    value="{{ $key }}"
                    {{ array_search($key, ($module['column_index'] ?? [])) !== false ? 'selected' : '' }}
                  >{{ $val['column_index'] . ': ' . $val['description'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Отображать в фильтрах (filters)</div>

            <div class="panel-body">
              <select class="select2 col-md-12" name="filters" multiple autocomplete="off">
                @foreach($plugins as $key => $val)
                  <option
                    value="{{ $key }}"
                    {{ array_search($key, ($module['filters'] ?? [])) !== false ? 'selected' : '' }}
                  >{{ $val['filters'] . ': ' . $val['description'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Переводить (lang)</div>

            <div class="panel-body">
              <select class="select2 col-md-12" name="lang" multiple autocomplete="off">
                @foreach($plugins as $key => $val)
                  <option
                    value="{{ $key }}"
                    {{ array_search($key, ($module['lang'] ?? [])) !== false ? 'selected' : '' }}
                  >{{ $val['lang'] . ': ' . $val['description'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Ссылка на сайте</div>

            <div class="panel-body">
              <input
                class="form-control"
                name="link_site_module"
                value="{{ $module['small_height'] or '' }}"
                placeholder="Ссылка на сайте"
              />
            </div>
          </div>
        </div>

        <hr />

        <select class="select2_modules form-control" id="select_modules" tabindex="-1" multiple autocomplete="off">
          <option value="0">Добавить плагин</option>
          @foreach($plugins as $key => $val)
            <option
              value="{{ $key }}"
              {{ array_search($key, ($module['plugins'] ?? [])) !== false ? 'selected' : '' }}
            >{{ $val['name'] . ': ' . $val['description'] }}</option>
          @endforeach
        </select>
        <hr />
        <div class="cont-form" style="border: solid 3px #cc075f; padding: 15px"></div>
        <br />

        <div class="text-right">
          <div class="loader"></div>
          <button class="btn btn-success" type="submit">@lang('admin::main.save')</button>

          <button class="btn btn-primary" formaction="/admin/engineer/update/{{ $page }}/{{ $id }}/1" type="submit">
            @lang('admin::main.apply')
          </button>

          <button class="btn btn-default" formaction="/admin/engineer{{ $page . $url }}" type="submit">
            @lang('admin::main.close')
          </button>
        </div>
      </form>
    </div>
  </div>

  @push('footer')
    <script type="text/javascript" src="{{ asset('/modules/js/modules.js') }}"></script>
    <script>
      $(document).ready(function() {
        modules.initialize({
          plugins: '{{ join(',', $module['plugins']) }}'
        });
      });
    </script>
  @endpush
@stop