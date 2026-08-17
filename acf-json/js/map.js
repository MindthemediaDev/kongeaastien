document.addEventListener("DOMContentLoaded", () => {

  if (!document.getElementById("map")) return;

  // Register EPSG:25832 projection
  proj4.defs('EPSG:25832', "+proj=utm +zone=32 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
  ol.proj.proj4.register(proj4);
  const projection = new ol.proj.Projection({code: 'EPSG:25832', units: 'm'});

  // Original lat/lon
  const centerLatLon = [8.974675, 55.409203]; // [lon, lat]

  // Transform from EPSG:4326 → EPSG:25832
  const centerProjected = ol.proj.transform(centerLatLon, 'EPSG:4326', 'EPSG:25832');

  // Create map
  const map = new ol.Map({
    target: "map",
    layers: [
      // Natur- og Friluftskort WMTS via proxy
      new ol.layer.Tile({
        source: new ol.source.WMTS({
          layer: 'nfkort',
          urls: ['/wp-content/themes/kongeaastien/proxy.php'], // your server-side proxy
          matrixSet: 'View1',
          wrapX: false,
          crossOrigin: 'anonymous',
          tileGrid: new ol.tilegrid.WMTS({
            matrixIds: ["L00", "L01", "L02", "L03", "L04", "L05", "L06", "L07", "L08", "L09", "L10", "L11", "L12", "L13"],
            resolutions: [1638.4, 819.2, 409.6, 204.8, 102.4, 51.2, 25.6, 12.8, 6.4, 3.2, 1.6, 0.8],
            extent: [120000.0, 5900000.0, 1000000.0, 6500000.0],
            tileSize: 256
          })
        })
      }),
      // Optional: Carto basemap underneath
      //new ol.layer.Tile({
      //  source: new ol.source.XYZ({
      //    url: 'https://{a-c}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
      //    attributions: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
      //  })
      //})
    ],
    view: new ol.View({
      center: centerProjected,
      zoom: 13,
      projection: projection
    })
  });

  if (!window.etapeGpxFiles || !window.etapeGpxFiles.length) return;

  const bounds = ol.extent.createEmpty();

  window.etapeGpxFiles.forEach((file, index) => {

    const color = file.color || '#347a28';

    // Load GPX as vector layer
    const vectorSource = new ol.source.Vector({
      url: file.url,
      format: new ol.format.GPX()
    });

    const vectorLayer = new ol.layer.Vector({
      source: vectorSource,
      style: new ol.style.Style({
        stroke: new ol.style.Stroke({
          color: color,
          width: 4
        })
      })
    });

    map.addLayer(vectorLayer);

    // After vector loads, add start/end markers
    vectorSource.once('change', () => {
      if (vectorSource.getState() !== 'ready') return;

      const features = vectorSource.getFeatures();
      console.log("Features loaded for file:", file.url, features.length);

      features.forEach(feature => {
        const geometry = feature.getGeometry();
        if (!geometry) return;

        const coords = geometry.getCoordinates();

        // Transform all coordinates from EPSG:4326 to EPSG:25832
        const coordsTransformed = coords.map(c => ol.proj.transform(c, 'EPSG:4326', 'EPSG:25832'));
        //console.log("Transformed coordinates:", coordsTransformed);

        if (!coordsTransformed.length) return;

        const start = coordsTransformed[0];
        const end = coordsTransformed[coordsTransformed.length - 1];

        // Extend map bounds
        coordsTransformed.forEach(c => ol.extent.extend(bounds, c));
        //console.log("Current bounds:", bounds);

        // Start marker
        const startMarker = new ol.Feature({ geometry: new ol.geom.Point(start), name: `Start ${index + 1}` });
        startMarker.setStyle(new ol.style.Style({
          image: new ol.style.Circle({ radius: 7, fill: new ol.style.Fill({ color }), stroke: new ol.style.Stroke({ color: '#111', width: 1 }) })
        }));

        // End marker
        const endMarker = new ol.Feature({ geometry: new ol.geom.Point(end), name: `End ${index + 1}` });
        endMarker.setStyle(new ol.style.Style({
          image: new ol.style.Circle({ radius: 7, fill: new ol.style.Fill({ color }), stroke: new ol.style.Stroke({ color: '#111', width: 4 }) })
        }));

        const markerSource = new ol.source.Vector({ features: [startMarker, endMarker] });
        map.addLayer(new ol.layer.Vector({ source: markerSource }));
      });

      // Fit map to all GPX tracks
      if (!ol.extent.isEmpty(bounds)) {
        //console.log("Fitting map to bounds:", bounds);
        map.getView().fit(bounds, { padding: [40, 40, 40, 40], duration: 1000 });
      } else {
        //console.log("Bounds are empty, cannot fit map.");
      }
    });

  });

});
