<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>@yield('title')</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Bootstrap core CSS -->

	<link href="{{ asset('/modules/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/modules/css/fontawesome-all.min.css') }}">
	<link href="{{ asset('/modules/fonts/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/modules/css/animate.min.css') }}" rel="stylesheet">

	<!-- Custom styling plus plugins -->
	<link href="{{ asset('/modules/css/custom.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('/modules/css/maps/jquery-jvectormap-2.0.3.css') }}" />
	<link href="{{ asset('/modules/css/icheck/flat/green.css') }}" rel="stylesheet" />
	<link href="{{ asset('/modules/css/switchery/switchery.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('/modules/css/floatexamples.css') }}" rel="stylesheet" type="text/css" />

	<link href="{{ asset('/modules/css/select/select2.min.css') }}" rel="stylesheet">

	<script src="{{ asset('/modules/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/modules/js/nprogress.js') }}"></script>

	<!--[if lt IE 9]>
	<script src="{{ asset('../assets/js/ie8-responsive-file-warning.js') }}"></script>
	<![endif]-->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script src="{{ asset('/modules/js/tinymce/tinymce.min.js') }}"></script>
	<script>
		tinymce.init({
			selector: ".area",
			height  : 450,

			plugins: [
				"autolink",
				"lists",
				"link",
				"image",
				"charmap",
				"code",
				"insertdatetime",
				"media",
				"table",
				"paste",
				"imagetools"
			],

			toolbar: "insertfile undo redo | styleselect | bold italic blockquote |" +
			" bullist numlist | link | media image | code",

			images_upload_handler: function(blobInfo, success, failure) {
				var
					xhr,
					formData;

				xhr                 = new XMLHttpRequest();
				xhr.withCredentials = false;
				xhr.open('POST', '/admin/files/upload_img');

				xhr.onload = function() {
					var json;

					if(xhr.status != 200) {
						failure('HTTP Error: ' + xhr.status);
						return;
					}

					json = JSON.parse(xhr.responseText);

					if(!json || typeof json.name != 'string') {
						failure('Invalid JSON: ' + xhr.responseText);
						return;
					}

					success('/images/files/big/' + json.name);
				};

				formData = new FormData();
				formData.append('Filedata', blobInfo.blob(), blobInfo.filename());
				formData.append('name_table', '{{ $segment3 ?? '' }}');
				formData.append('name_field', 'text');
				formData.append('id_album', 0);

				xhr.send(formData);
			},

			image_class_list: [
				{title: 'None', value: ''},
				{title: 'Clear', value: 'clear'},
				{title: 'Thumbnail', value: 'thumbnail'}
			],

			class_list: [
				{title: 'None', value: ''},
				{title: 'Clear', value: 'clear'},
				{title: 'Thumbnail', value: 'thumbnail'}
			],

			style_formats: [
				{title: 'Headers', items: [
						{title: 'Header 1', format: 'h1'},
						{title: 'Header 2', format: 'h2'},
						{title: 'Header 3', format: 'h3'},
						{title: 'Header 4', format: 'h4'},
						{title: 'Header 5', format: 'h5'},
						{title: 'Header 6', format: 'h6'}
					]},
				{title: 'Inline', items: [
						{title: 'Bold', icon: 'bold', format: 'bold'},
						{title: 'Italic', icon: 'italic', format: 'italic'},
						{title: 'Underline', icon: 'underline', format: 'underline'},
						{title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
						{title: 'Superscript', icon: 'superscript', format: 'superscript'},
						{title: 'Subscript', icon: 'subscript', format: 'subscript'},
						{title: 'Code', icon: 'code', format: 'code'}
					]},

				{title: 'Paragraph', format: 'p'},

//				{title: 'Blocks', items: [
//						{title: 'Paragraph', format: 'p'},
//						{title: 'Blockquote', format: 'blockquote'},
//						{title: 'Div', format: 'div'},
//						{title: 'Pre', format: 'pre'}
//					]},
//				{title: 'Alignment', items: [
//						{title: 'Left', icon: 'alignleft', format: 'alignleft'},
//						{title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
//						{title: 'Right', icon: 'alignright', format: 'alignright'},
//						{title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
//					]}
			],

			content_css: [
				'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				'//www.tinymce.com/css/codepen.min.css'],

			setup: function (editor) {
				editor.addButton('paragraph', {
					text: 'Paragraph',
					icon: false,
					onclick: function () {
						editor.insertContent('<p>' + tinymce.activeEditor.selection.getContent() + '</p>');
					}
				});
			},

			menubar          : false,
			image_advtab     : true,
			image_dimensions : true,
			// image_prepend_url: "/",
			document_base_url: "/",
			relative_urls    : false,
			language         : "{{ \App::getLocale() }}",
			font_formats     : "Andale Mono=andale mono,times;" +
			"Arial=arial,helvetica,sans-serif;" +
			"Arial Black=arial black,avant garde;" +
			"Book Antiqua=book antiqua,palatino;" +
			"Comic Sans MS=comic sans ms,sans-serif;" +
			"Courier New=courier new,courier;" +
			"Georgia=georgia,palatino;" +
			"Helvetica=helvetica;" +
			"Impact=impact,chicago;" +
			"Symbol=symbol;" +
			"Tahoma=tahoma,arial,helvetica,sans-serif;" +
			"Terminal=terminal,monaco;" +
			"Times New Roman=times new roman,times;" +
			"Trebuchet MS=trebuchet ms,geneva;" +
			"Verdana=verdana,geneva;" +
			"Webdings=webdings;" +
			"Wingdings=wingdings,zapf dingbats"
		});

		tinymce.init({
			selector: ".area_min",
			menubar : false,
			language: "{{ \App::getLocale() }}",
		});

		// Applying the specified format
		//tinymce.formatter.apply('custom_format');
	</script>


	<script src="{{ asset('/modules/js/code_editor/lib/codemirror.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('/modules/js/code_editor/lib/codemirror.css') }}">
	<script src="{{ asset('/modules/js/code_editor/addon/edit/matchbrackets.js') }}"></script>
	<script src="{{ asset('/modules/js/code_editor/mode/htmlmixed/htmlmixed.js') }}"></script>
	<script src="{{ asset('/modules/js/code_editor/mode/xml/xml.js') }}"></script>
	<script src="{{ asset('/modules/js/code_editor/mode/javascript/javascript.js') }}"></script>
	<script src="{{ asset('/modules/js/code_editor/mode/css/css.js') }}"></script>
	<script src="{{ asset('/modules/js/code_editor/mode/clike/clike.js') }}"></script>
	<script src="{{ asset('/modules/js/code_editor/mode/php/php.js') }}"></script>
	<script src="{{ asset('/modules/js/code_editor/mode/markdown/markdown.js') }}"></script>

	<style type="text/css">
		.CodeMirror {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}
	</style>

	<link href="/css/admin_site.css" rel="stylesheet" type="text/css" />
	<script src="{{ asset('/modules/js/adm.js') }}"></script>

	<script>
		$(document).ready(function() {
			$.adm.initialize({
				url_req: '/'
			});
		})
	</script>

	@yield('header')
	@stack('header')
</head>
<body class="nav-md">
<div class="container body">
	<div class="main_container">