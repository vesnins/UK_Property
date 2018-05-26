@extends('admin::layouts.default')
@section('title',"Админ панель SMV 4.0DEV")
@section('content')

    @include('admin::layouts.left-menu')
    @include('admin::layouts.top-menu')
    <div class="right_col" role="main">
        <br />

        <div class="row">
            <div class="alert alert-dark">
                {{ $error }}
            </div>
        </div>
    </div>
@stop