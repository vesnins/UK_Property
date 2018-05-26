<script type="text/javascript" src="{{ asset('/modules/js/jquery-fileTree/enhance.js') }}"></script>
<script src="{{ asset('/modules/js/jquery-fileTree/jQuery.tree.js') }}" type="text/javascript"></script>
<link href="{{ asset('/modules/js/jquery-fileTree/enhanced.css') }}" rel="stylesheet" type="text/css" media="screen"/>

<div>
	<style>
		.inp_edit_u {
			display: block;
			float: left;
			margin-left: 28px;
			margin-top: 0px;
			padding-left: 0px;
		}
	</style>

	{!! $menu !!}
</div>

<script>
	$('.menu_tree').tree({
		expanded: 'li:first'
	});

	$(document).ready(function() {
		clM('.rowID-{{ $get_id }}');

		function clM(c) {
			var cl = $(c).parent().parent('li').attr('class');

			if(cl != undefined) {
				$(c).parent().parents('li').children('a').click();
				cl = $(c).parent().parent('li').attr('class');

				clM(cl);
			}
		}

		setTimeout(function() {
			$('.rowID-{{ $get_id }} > a').click();
			$('.rowID-{{ $get_id }} > div > input').click();

			window.location.href = window.location.href.split('#')[0] + '#{{ $get_id }}';
		}, 1000);
	});
</script>
