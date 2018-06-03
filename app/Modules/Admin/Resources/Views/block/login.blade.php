@extends('admin::layouts.default')
@section('title',trans('admin::main.authorization'))
@section('footer')

@endsection
@section('content')
	<div id="wrapper">
		<div id="login" class="animate form" style="background: #fff; padding: 10px">
			<section class="login_content">
				<form method="post">
					<h1>@lang('admin::main.authorization')</h1>

					<div>
						<input type="text" name="email" class="form-control" placeholder="Email" required="" />
					</div>

					<div>
						<input
							type="password"
							name="password"
							class="form-control"
							placeholder="@lang('admin::main.password')"
							required=""
						/>
					</div>

					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div>
						<button type="submit" class="btn btn-default submit" href="/admin/login">@lang('admin::main.logIn')</button>
						{{--<a class="reset_pass" href="#">Lost your password?</a>--}}
					</div>

					<div class="clearfix"></div>
					<div class="separator">
						<div class="clearfix"></div>
						<br/>

						<div>
							<a href="/" class="logo">
								@lang('admin::main.nameSite')
							</a>
						</div>
					</div>
				</form>
				<!-- form -->
			</section>
			<!-- content -->
		</div>

		<div style="clear: both; width: 100%"></div>
	</div>
@stop