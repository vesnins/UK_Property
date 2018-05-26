@extends('admin::layouts.default')
@section('title',"Помощь")
@section('content')
	<script src="/modules/js/markdown/markdown.js"></script>
	@include('admin::layouts.left-menu')
	@include('admin::layouts.top-menu')

	<style>
		.CodeMirror {
			width: 100%;
		}

		h2 {
			width: 100%;
		}
	</style>

	<div class="right_col" role="main">
		<br />

		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Помощь</h2>
						<hr class="clear"/>

						<form>
							<textarea class="mdSt">{!! $file !!}</textarea>
						</form>

						<hr class="clear"/>
						<div class="showMd"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="clear"></div>

		<script>
			var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

			$(document).ready(function () {



				CodeMirror.fromTextArea(document.getElementsByClassName("mdSt")[0], {
					// lineNumbers: true,
					matchBrackets: true,
					mode: "text/x-markdown",
					// indentUnit: 4,
					indentWithTabs: true,
					gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
					styleActiveLine: true,
					foldGutter: true,
					extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
					// theme: "dracula"
				});


				function Editor(input, preview) {
					this.update = function () {
						preview.innerHTML = Markdown.toHTML(input.value);
					};
					input.editor = this;
					this.update();
				}
				var $ = function (id) { return document.getElementById(id); };
				new Editor(document.getElementsByClassName("mdSt")[0], document.getElementsByClassName("showMd")[0]);
			})
		</script>
@stop