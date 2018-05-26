<div class="modal-body">
	<!-- image cropping -->
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<!-- <h3 class="page-header">Demo:</h3> -->
				<div class="img-container_2 img-container{{ $name }}" style="width: 100%">
					<img src="/images/files/original/{{ $file[0]->file }}" style="width: 100%" alt="Picture">
				</div>
			</div>

			<div class="col-md-3">
				<!-- <h3 class="page-header">Preview:</h3> -->
				<div class="docs-preview clearfix">
					<div class="img-preview img-preview{{ $name }} preview-lg"></div>
					<div class="img-preview img-preview{{ $name }} preview-md"></div>
					<div class="img-preview img-preview{{ $name }} preview-sm"></div>
					<div class="img-preview img-preview{{ $name }} preview-xs"></div>
				</div>

				<!-- <h3 class="page-header">Data:</h3> -->
				<div class="docs-data">
					<div class="input-group">
						<label class="input-group-addon" for="dataX{{ $name }}">X</label>
						<input class="form-control" id="dataX{{ $name }}" type="text" placeholder="x">
						<span class="input-group-addon">px</span>
					</div>

					<div class="input-group">
						<label class="input-group-addon" for="dataY{{ $name }}">Y</label>
						<input class="form-control" id="dataY{{ $name }}" type="text" placeholder="y">
						<span class="input-group-addon">px</span>
					</div>

					<div class="input-group">
						<label class="input-group-addon" for="dataWidth{{ $name }}">Width</label>
						<input class="form-control" id="dataWidth{{ $name }}" type="text" placeholder="width">
						<span class="input-group-addon">px</span>
					</div>

					<div class="input-group">
						<label class="input-group-addon" for="dataHeight{{ $name }}">Height</label>
						<input class="form-control" id="dataHeight{{ $name }}" type="text" placeholder="height">
						<span class="input-group-addon">px</span>
					</div>

					<div class="input-group">
						<label class="input-group-addon" for="dataRotate{{ $name }}">Rotate</label>
						<input class="form-control" id="dataRotate{{ $name }}" type="text" placeholder="rotate">
						<span class="input-group-addon">deg</span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-9 docs-buttons">
				<!-- <h3 class="page-header">Toolbar:</h3> -->
				<div class="btn-group">
					{{--<button class="btn btn-primary" data-method="setDragMode" data-option="move" type="button" title="Move">--}}
					{{--<span class="docs-tooltip" data-toggle="tooltip"--}}
					{{--title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">--}}
					{{--<span class="fa fa-arrows"></span>--}}
					{{--</span>--}}
					{{--</button>--}}

					{{--<button class="btn btn-primary" data-method="setDragMode" data-option="crop" type="button" title="Crop">--}}
					{{--<span class="docs-tooltip" data-toggle="tooltip"--}}
					{{--title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">--}}
					{{--<span class="fa fa-crop"></span>--}}
					{{--</span>--}}
					{{--</button>--}}

					<button class="btn btn-primary" data-method{{ $name }}="zoom" data-option="0.1" type="button" title="Zoom In">
						<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
							<span class="fa fa-search-plus"></span>
						</span>
					</button>

					<button class="btn btn-primary" data-method{{ $name }}="zoom" data-option="-0.1" type="button"
						title="Zoom Out">
						<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
							<span class="fa fa-search-minus"></span>
						</span>
					</button>

					<button class="btn btn-primary" data-method{{ $name }}="rotate" data-option="-45" type="button"
						title="Rotate Left">
						<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, -45)">
							<span class="fa fa-rotate-left"></span>
						</span>
					</button>

					<button class="btn btn-primary" data-method{{ $name }}="rotate" data-option="45" type="button"
						title="Rotate Right">
						<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, 45)">
							<span class="fa fa-rotate-right"></span>
						</span>
					</button>
				</div>

				{{--<div class="btn-group">--}}
				{{--<button class="btn btn-primary" data-method="disable" type="button" title="Disable">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;disable&quot;)">--}}
				{{--<span class="fa fa-lock"></span>--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<button class="btn btn-primary" data-method="enable" type="button" title="Enable">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;enable&quot;)">--}}
				{{--<span class="fa fa-unlock"></span>--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<button class="btn btn-primary" data-method="clear" type="button" title="Clear">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;clear&quot;)">--}}
				{{--<span class="fa fa-close"></span>--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<button class="btn btn-primary" data-method="reset" type="button" title="Reset">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;reset&quot;)">--}}
				{{--<span class="fa fa-refresh"></span>--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">--}}
				{{--<input class="sr-only" id="inputImage" name="file" type="file" accept="image/*">--}}

				{{--<span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">--}}
				{{--<span class="fa fa-upload"></span>--}}
				{{--</span>--}}
				{{--</label>--}}

				{{--<button class="btn btn-primary" data-method="destroy" type="button" title="Destroy">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;destroy&quot;)">--}}
				{{--<span class="fa fa-power-off"></span>--}}
				{{--</span>--}}
				{{--</button>--}}
				{{--</div>--}}

				{{--<div class="btn-group btn-group-crop">--}}
				{{--<button class="btn btn-primary" data-method="getDataURL" data-option="image/jpeg" type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip"--}}
				{{--title="$().cropper(&quot;getDataURL&quot;, &quot;image/jpeg&quot;)">--}}
				{{--JPG--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<button class="btn btn-primary" data-method="getDataURL"--}}
				{{--data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }" type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip"--}}
				{{--title="$().cropper(&quot;getDataURL&quot;, { &quot;width&quot;: 160, &quot;height&quot;: 90 })">--}}
				{{--160 &times; 90--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<button class="btn btn-primary" data-method="getDataURL"--}}
				{{--data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }" type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip"--}}
				{{--title="$().cropper(&quot;getDataURL&quot;, { &quot;width&quot;: 320, &quot;height&quot;: 180 })">--}}
				{{--320 &times; 180--}}
				{{--</span>--}}
				{{--</button>--}}
				{{--</div>--}}

				{{--<div class="btn-group">--}}
				{{--<button class="btn btn-primary" data-method="getData" data-option="" data-target="#putData" type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getData&quot;)">--}}
				{{--Get Data--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<button class="btn btn-primary" data-method="getData" data-option="true" data-target="#putData" type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getData&quot;, true)">--}}
				{{--Rounded--}}
				{{--</span>--}}
				{{--</button>--}}
				{{--</div>--}}

				{{--<div class="btn-group">--}}
				{{--<button class="btn btn-primary" data-method="getImageData" data-option="" data-target="#putData" type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getImageData&quot;)">--}}
				{{--Get Image Data--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<button class="btn btn-primary" data-method="getImageData" data-option="true" data-target="#putData"--}}
				{{--type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip"--}}
				{{--title="$().cropper(&quot;getImageData&quot;, true)">--}}
				{{--All--}}
				{{--</span>--}}
				{{--</button>--}}
				{{--</div>--}}

				{{--<button class="btn btn-primary" data-method="setImageData" data-target="#putData" type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setImageData&quot;, data)">--}}
				{{--Set Image Data--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<button class="btn btn-primary" data-method="getCropBoxData" data-option="" data-target="#putData"--}}
				{{--type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCropBoxData&quot;)">--}}
				{{--Get Crop Box Data--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<button class="btn btn-primary" data-method="setCropBoxData" data-target="#putData" type="button">--}}
				{{--<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setCropBoxData&quot;, data)">--}}
				{{--Set Crop Box Data--}}
				{{--</span>--}}
				{{--</button>--}}

				{{--<input class="form-control" id="putData" type="text" placeholder="Get data to here or set data with this value">--}}
			</div>
			<!-- /.docs-buttons -->

			<div class="col-md-3 docs-toggles">
				<!-- <h3 class="page-header">Toggles:</h3> -->
				<div class="btn-group btn-group-justified" data-toggle="buttons">
					<label class="btn btn-primary active" data-method{{ $name }}="setAspectRatio" data-option="1.7777777777777777"
						title="Set Aspect Ratio">
						<input class="sr-only" id="aspestRatio1" name="aspestRatio" value="1.7777777777777777" type="radio">

						<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 16 / 9)">
							16:9
						</span>
					</label>

					<label class="btn btn-primary" data-method{{ $name }}="setAspectRatio" data-option="1.3333333333333333"
						title="Set Aspect Ratio">
						<input class="sr-only" id="aspestRatio2" name="aspestRatio" value="1.3333333333333333" type="radio">

						<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 4 / 3)">
							4:3
						</span>
					</label>

					<label class="btn btn-primary" data-method{{ $name }}="setAspectRatio" data-option="1"
						title="Set Aspect Ratio">
						<input class="sr-only" id="aspestRatio3" name="aspestRatio" value="1" type="radio">

						<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 1 / 1)">
							1:1
						</span>
					</label>

					<label class="btn btn-primary" data-method{{ $name }}="setAspectRatio" data-option="0.6666666666666666"
						title="Set Aspect Ratio">
						<input class="sr-only" id="aspestRatio4" name="aspestRatio" value="0.6666666666666666" type="radio">
						<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 2 / 3)">
							2:3
						</span>
					</label>

					<label class="btn btn-primary" data-method{{ $name }}="setAspectRatio" data-option="NaN"
						title="Set Aspect Ratio">
						<input class="sr-only" id="aspestRatio5" name="aspestRatio" value="NaN" type="radio">

						<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, NaN)">
							Free
						</span>
					</label>
				</div>

			{{--<div class="dropdown dropup docs-options">--}}
			{{--<button class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" type="button"--}}
			{{--data-toggle="dropdown" aria-expanded="true">--}}
			{{--Toggle Options--}}
			{{--<span class="caret"></span>--}}
			{{--</button>--}}

			{{--<ul class="dropdown-menu" role="menu" aria-labelledby="toggleOptions">--}}
			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="global" checked> global--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="responsive" checked> responsive--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="checkImageOrigin" checked> checkImageOrigin--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="modal" checked> modal--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="guides" checked> guides--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="highlight" checked> highlight--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="background" checked> background--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="autoCrop" checked> autoCrop--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="dragCrop" checked> dragCrop--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="movable" checked> movable--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="resizable" checked> resizable--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="rotatable" checked> rotatable--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="zoomable" checked> zoomable--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="touchDragZoom" checked> touchDragZoom--}}
			{{--</label>--}}
			{{--</li>--}}

			{{--<li role="presentation">--}}
			{{--<label class="checkbox-inline">--}}
			{{--<input type="checkbox" name="option" value="mouseWheelZoom" checked> mouseWheelZoom--}}
			{{--</label>--}}
			{{--</li>--}}
			{{--</ul>--}}
			{{--</div>--}}
			<!-- /.dropdown -->
			</div>
			<!-- /.docs-toggles -->
		</div>
	</div>
	<!-- /image cropping -->

	<!-- image cropping -->
	<script src="{{ asset('/modules/js/cropping/cropper.min.js') }}"></script>
	<script src="{{ asset('/modules/js/cropping/main2.js') }}"></script>

	<script>
		$(window).ready(function() {
			'use strict';

			var
				console     = window.console || {
					log: function() {
					}
				},
				$alert      = $('.docs-alert'),
				$message    = $alert.find('.message'),
				showMessage = function(message, type) {
					$message.text(message);

					if(type) {
						$message.addClass(type);
					}

					$alert.fadeIn();

					setTimeout(function() {
						$alert.fadeOut();
					}, 3000);
				};

			(function() {
				var
					$image      = $('.img-container{{ $name }} > img'),
					$dataX      = $('#dataX{{ $name }}'),
					$dataY      = $('#dataY{{ $name }}'),
					$dataHeight = $('#dataHeight{{ $name }}'),
					$dataWidth  = $('#dataWidth{{ $name }}'),
					$dataRotate = $('#dataRotate{{ $name }}'),

					options     = {
						aspectRatio: 16 / 9,
						preview    : '.img-preview{{ $name }}',

						crop: function(data) {
							$dataX.val(Math.round(data.x));
							$dataY.val(Math.round(data.y));
							$dataHeight.val(Math.round(data.height));
							$dataWidth.val(Math.round(data.width));
							$dataRotate.val(Math.round(data.rotate));
						}
					};

				$image.on({
					'build.cropper': function(e) {
						console.log(e.type);
					},
					'built.cropper': function(e) {
						console.log(e.type);
					}
				}).cropper(options);

				// Methods
				$('[data-method{{ $name }}]').unbind('click');

				$('[data-method{{ $name }}]').click(function() {
					var
						data = $(this).data(),
						$target,
						result;

					if(data.method{{ $name }}) {
						data = $.extend({}, data); // Clone a new one

						if(typeof data.target !== 'undefined') {
							$target = $(data.target);

							if(typeof data.option === 'undefined') {
								try {
									data.option = JSON.parse($target.val());
								} catch(e) {
									console.log(e.message);
								}
							}
						}

						result = $image.cropper('getCropBoxData');

						if(data.method{{ $name }} === 'getCropBoxData') {
							var
								id = $('.btnsav{{ $name }}').attr('data-id');

							result['x']      = $('#dataX{{ $name }}').val();
							result['y']      = $('#dataY{{ $name }}').val();
							result['width']  = $('#dataWidth{{ $name }}').val();
							result['height'] = $('#dataHeight{{ $name }}').val();

							$.ajax({
								type    : "POST",
								url     : "/admin/files/edit_img",
								dataType: 'json',

								data: {
									id    : id,
									file  : '{{ $file[0]->file }}',
									option: result
								},

								cache: false,

								success: function(req) {
									if(req['result'] === 'ok') {
										$('.btncl{{ $name }}').click();
										$('.rowID{{ $name }}-' + id).html(
											'<div class="thumbnail">' +
											'<div class="image view view-first pointer" onclick="editImg{{ $name }}(' + id + ')">' +
											'<img src="' + req["file"] + '" style="width: 100%; display: block;">' +
											'</div>' +
											'<div class="caption" style="padding-bottom: 0">' +
											'<div class="tools tools-bottom" style="text-align: center">' +
											'<a href="javascript:void(0)" onclick="editImg{{ $name }}(' + id + ')" class="btn"><i class="fa fa-pencil"></i></a>' +
											'<a href="javascript:void(0)" onclick="cropImg{{ $name }}(' + id + ')" class="btn"><i class="fa fa-crop"></i></a>' +
											'<a href="javascript:void(0)" onclick="$.adm.rowDelete(' + id + ', \'files\', \'\' ,\'{{ $name }}\')" class="btn"><i class="fa fa-times"></i></a>' +
											'<a href="javascript:void(0)" class="btn" onclick="toMain{{ $name }}(' + id + ')">' +
											'</div>' +
											'</div>' +
											'</div>' +
											'</div>');
									}
								}
							});

							window.ajax{{ $name }} = false;
						}

						if($.isPlainObject(result) && $target) {
							try {
								$target.val(JSON.stringify(result));
							} catch(e) {
								console.log(e.message);
							}
						}
					}
				}).on('keydown', function(e) {

					switch(e.which) {
					case 37:
						e.preventDefault();
						$image.cropper('move', -1, 0);
						break;

					case 38:
						e.preventDefault();
						$image.cropper('move', 0, -1);
						break;

					case 39:
						e.preventDefault();
						$image.cropper('move', 1, 0);
						break;

					case 40:
						e.preventDefault();
						$image.cropper('move', 0, 1);
						break;
					}

				});

				// Import image
				var
					$inputImage = $('#inputImage'),
					URL         = window.URL || window.webkitURL,
					blobURL;

				if(URL) {
					$inputImage.change(function() {
						var
							files = this.files,
							file;

						if(files && files.length) {
							file = files[0];

							if(/^image\/\w+$/.test(file.type)) {
								blobURL = URL.createObjectURL(file);
								$image.one('built.cropper', function() {
									URL.revokeObjectURL(blobURL); // Revoke when load complete
								}).cropper('reset', true).cropper('replace', blobURL);
								$inputImage.val('');
							} else {
								showMessage('Please choose an image file.');
							}
						}
					});
				} else {
					$inputImage.parent().remove();
				}

				// Options
				$('.docs-options :checkbox').on('change', function() {
					var $this = $(this);

					options[$this.val()] = $this.prop('checked');
					$image.cropper('destroy').cropper(options);
				});

				// Tooltips
				$('[data-toggle="tooltip"]').tooltip();
			}());
		});
	</script>
</div>

<div class="modal-footer">
	<div class="text-right">
		<button
			type="button"
			class="btn btn-default btncl{{ $name }}"
			data-dismiss="modal"
			type="button"
			style="margin-bottom: 0"
		>
			@lang('admin::main.close')
		</button>

		<button class="btn btn-primary btnsav{{ $name }}" data-method{{ $name }}="getCropBoxData" type="button">
			@lang('admin::main.save')
		</button>
	</div>
</div>
