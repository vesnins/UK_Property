@extends('admin::layouts.default')
@section('title',"Админ панель SMV 4.0DEV")
@section('content')

    @include('admin::layouts.left-menu')
    @include('admin::layouts.top-menu')
    <div class="right_col" role="main">
        <br />

        <div class="form-group">

        </div>

        <div class="container">
            <form method="post" class="form-modules">
                <br /><br />
                <div class="form-group panel panel-body">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Название модуля (Пункт меню)
                        </div>
                        <div class="panel-body">
                            <input class="form-control" name="name_module" placeholder="Название модуля"/>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ссылка модуля (table sql)
                        </div>
                        <div class="panel-body">
                            <input class="form-control" name="link_module" placeholder="Ссылка модуля"/>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Класс иконки меню
                        </div>
                        <div class="panel-body">
                            <input class="form-control" name="class_module" placeholder="Класс иконки меню"/>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Количество элементов на странице
                        </div>
                        <div class="panel-body">
                            <input class="form-control" name="count_module" placeholder="Количество элементов на странице"/>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Размеры изображений
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class=" col-md-3">
                                        <div class="row">
                                            <input class="form-control" name="big_width" placeholder="Big width"/>
                                        </div>
                                    </div>
                                    <div class=" col-md-3">
                                        <input class="form-control" name="big_height" placeholder="Big height"/>
                                    </div>

                                    <div class=" col-md-3">
                                        <input class="form-control" name="small_width" placeholder="Small width"/>
                                    </div>
                                    <div class=" col-md-3">
                                        <div class="row">
                                            <input class="form-control" name="small_height" placeholder="Small height"/>
                                        </div>
                                    </div>
                                    <br />
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Способ отображения (views)
                        </div>
                        <div class="panel-body">
                            <select class="select2 col-md-12" name="views_height">
                                <option value="table">Выберите способ отображения</option>
                                <option value="table">Таблица</option>
                                <option value="wood">Дерево</option>
                            </select>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ссылка на сайте
                        </div>
                        <div class="panel-body">
                            <input class="form-control" name="link_site_module" placeholder="Ссылка на сайте"/>
                        </div>
                    </div>
                </div>
                <hr />
                <select class="select2_modules form-control" id="select_modules" tabindex="-1">
                    <option value="0">Выберите плагин</option>
                    @foreach($plugins as $val)
                        <option value="{{ $val['id'] }}">{{ $val['description'] }}</option>
                    @endforeach
                </select>
                <hr />
                <div class="cont-form"></div>
                <br />

                <div class="loader"></div>
                <button class="btn btn-primary" type="submit">Сохранить</button>
            </form>
        </div>

        <script type="text/javascript" src="{{ asset('/modules/js/modules.js') }}"></script>
        <script>
            $(document).ready(function(){
                modules.initialize({

                });
            });
        </script>
    </div>
@stop