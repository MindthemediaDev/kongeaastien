<div id="map" style="width:100%; height:500px;"></div>
<script src="https://cdn.jsdelivr.net/npm/ol@7.3.0/dist/ol.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.8.1/proj4.js"></script>
<script>
	proj4.defs('EPSG:25832', "+proj=utm +zone=32 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
	ol.proj.proj4.register(proj4);

	const projection = new ol.proj.Projection({ code: 'EPSG:25832', units: 'm' });

	const mapLayer = new ol.layer.Tile({
		source: new ol.source.WMTS({
			layer: 'nfkort',
			urls: ['/wp-content/themes/kongeaastien/proxy.php'], // point to the server-side proxy
			matrixSet: 'View1',
			wrapX: false,
			crossOrigin: 'anonymous',
			tileGrid: new ol.tilegrid.WMTS({
				matrixIds: ["L00","L01","L02","L03","L04","L05","L06","L07","L08","L09","L10","L11","L12","L13"],
				resolutions: [1638.4,819.2,409.6,204.8,102.4,51.2,25.6,12.8,6.4,3.2,1.6,0.8],
				extent: [120000.0,5900000.0,1000000.0,6500000.0],
				tileSize: 256
			}),
		})
	});

	const map = new ol.Map({
		target: 'map',
		layers: [mapLayer],
		view: new ol.View({
			center: [565703.61,6246901.12],
			zoom: 8,
			projection: projection
		})
	});
</script>