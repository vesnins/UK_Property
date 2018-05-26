@push('header')
	<style>
		#map-l {
			width: 100%;
			height: 400px;
			margin-bottom: 15px;
		}
	</style>
@endpush

@push('footer')
	<script src="//api-maps.yandex.ru/2.1/?lang={{ $lang ?? 'ru' }}" type="text/javascript"></script>
@endpush

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
	<div class="col-md-6 col-sm-6 col-xs-12"><div id="map-l"></div></div>
</div>

<script>
	window.locationInit = function(w) {
		var inpL = $('#inputLocation');
		inpL.val(inpL.data('init-value'));

		ymaps.ready(function() {
			var
				myMap,
				mySearchControl,
				mySearchResults;

			myMap = new ymaps.Map("map-l", {
					center: [
						parseFloat('{!! $plugin['latitude'] ?? '' !!}}'),
						parseFloat('{!! $plugin['longitude'] ?? '' !!}}')
					],

					zoom    : 8,
					controls: ['zoomControl']
				}
			);

			// Создаем экземпляр класса ymaps.control.SearchControl
			mySearchControl = new ymaps.control.SearchControl({
				options: {
					noPlacemark: true
				}
			});

			// Результаты поиска будем помещать в коллекцию.
			mySearchResults = new ymaps.GeoObjectCollection(null, {
				draggable: true,
				hasHint  : false
			});

			myMap.controls.add(mySearchControl);
			myMap.geoObjects.add(mySearchResults);

			myMap.events.add('balloonopen', function(e) {
				var thisPlacemark = e.get('target');
				var coords        = thisPlacemark.geometry.getCoordinates();

				ymaps.geocode(coords, {
					results: 1
				}).then(function(res) {
					var newContent = res.geoObjects.get(0) ?
						res.geoObjects.get(0).properties.get('name') :
						'Не удалось определить адрес.';

					// Задаем новое содержимое балуна в соответствующее свойство метки.
					thisPlacemark.properties.set('balloonContentBody', newContent);
				});
			});

			mySearchResults.events.add('dragstart', function(e) {
				var thisPlacemark = e.get('target');
				thisPlacemark.options.set('preset', 'islands#blueIcon');
			});

			mySearchResults.events.add('dragend', function(e) {
				var
					thisPlacemark = e.get('target'),
					coords;

				thisPlacemark.options.set('preset', 'islands#redIcon');
				coords = thisPlacemark.geometry.getCoordinates();

				$("#inputCoordinates").val(coords[0].toPrecision(10) + ", " + coords[1].toPrecision(10));

				ymaps.geocode(coords, {
					results: 1
				}).then(function(res) {
					var
						newContent = res.geoObjects.get(0)
							? res.geoObjects.get(0).properties.get('name')
							: 'Не удалось определить адрес.';

					inpL.val(res.geoObjects.get(0).properties.get('text'));
					// Задаем новое содержимое балуна в соответствующее свойство метки.
					thisPlacemark.properties.set('balloonContentBody', newContent);
				});
			});

			mySearchControl.events.add('resultselect', function(e) {
				mySearchControl.getResult(e.get('index')).then(function(res) {
					var
						coords = res.geometry.getCoordinates();

					mySearchResults.add(res);

					ymaps.geocode(coords, {
						results: 1
					}).then(function(res) {
						var newContent = res.geoObjects.get(0)
							? res.geoObjects.get(0).properties.get('name')
							: '@lang('admin::main.addressCouldNot')';

						inpL.val(res.geoObjects.get(0).properties.get('text'));

						// Задаем новое содержимое балуна в соответствующее свойство метки.
						myMap.balloon.open(coords, newContent);
					});

					$("#inputCoordinates").val(coords[0].toPrecision(10) + ", " + coords[1].toPrecision(10));
				});
			}).add('submit', function() {
				mySearchResults.removeAll();
			})
		});
	}
</script>
