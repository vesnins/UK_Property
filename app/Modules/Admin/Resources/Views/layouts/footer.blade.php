</div>
<!-- /page content -->
</div>
</div>
<div id="custom_notifications" class="custom-notifications dsp_none">
	<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group"></ul>
	<div class="clearfix"></div>
	<div id="notif-group" class="tabbed_notifications"></div>
</div>

<script src="{{ asset('/modules/js/bootstrap.min.js') }}"></script>

<!-- bootstrap progress js -->
<script src="{{ asset('/modules/js/progressbar/bootstrap-progressbar.min.js') }}"></script>
<script src="{{ asset('/modules/js/nicescroll/jquery.nicescroll.min.js') }}"></script>
<!-- icheck -->
<script src="{{ asset('/modules/js/icheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/switchery/switchery.min.js') }}"></script>
<!-- daterangepicker -->
<script type="text/javascript" src="{{ asset('/modules/js/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/datepicker/daterangepicker.js') }}"></script>
<!-- chart js -->
<script src="{{ asset('/modules/js/chartjs/chart.min.js') }}"></script>

<script src="{{ asset('/modules/js/select/select2.full.js') }}"></script>

<script src="{{ asset('/modules/js/custom.js') }}"></script>

<!-- flot js -->
<!--[if lte IE 8]>
<script type="text/javascript" src="{{ asset('/modules/js/excanvas.min.js') }}"></script><![endif]-->
<script type="text/javascript" src="{{ asset('/modules/js/flot/jquery.flot.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/flot/jquery.flot.pie.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/flot/jquery.flot.orderBars.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/flot/jquery.flot.time.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/flot/date.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/flot/jquery.flot.spline.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/flot/jquery.flot.stack.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/flot/curvedLines.js') }}"></script>
<script type="text/javascript" src="{{ asset('/modules/js/flot/jquery.flot.resize.js') }}"></script>
<!-- pace -->
<script src="{{ asset('/modules/js/pace/pace.min.js') }}"></script>
<script>
	$(document).ready(function() {
		if($('#textareaHtml_top').val() != undefined && $('#textareaHtml_top').val() != 'undefined') {
			CodeMirror.fromTextArea(document.getElementById("textareaHtml_top"), {
				lineNumbers: true,
				matchBrackets: true,
				mode: "application/x-httpd-php",
				indentUnit: 4,
				indentWithTabs: true,
				gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
				styleActiveLine: true,
				foldGutter: true,
				extraKeys: {
					"Ctrl-Q": function(cm) {
						cm.foldCode(cm.getCursor());
					}
				},
				theme: "dracula"
			});
			CodeMirror.fromTextArea(document.getElementById("textareaHtml_bottom"), {
				mode: "application/x-httpd-php",
				indentUnit: 4,
				indentWithTabs: true,
				gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
				lineNumbers: true,
				matchBrackets: true,
				styleActiveLine: true,
				foldGutter: true,
				extraKeys: {
					"Ctrl-Q": function(cm) {
						cm.foldCode(cm.getCursor());
					}
				},
				theme: "dracula"
			});
		}
	})
</script>
<!-- Modal -->
<div class="modal fade" id="modalDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<h4 class="modal-title modal-title-mess" id="myModalLabel">@lang('admin::main.remove')</h4>
			</div>

			<div class="modal-body modal-body-mess">@lang('admin::main.areYouSure')</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin::main.close')</button>
				<button type="button" class="btn btn-danger delbMod">@lang('admin::main.remove')</button>
			</div>
		</div>
	</div>
</div>

@yield('footer')
@stack('footer')
</body>
</html>
