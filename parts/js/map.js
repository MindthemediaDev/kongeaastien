document.addEventListener("DOMContentLoaded", () => {

  if (!document.getElementById("map")) return;

  // Create map
  const map = new ol.Map({
    target: "map",
    layers: [
      new ol.layer.Tile({
        source: new ol.source.XYZ({
          url: 'https://{a-c}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
          attributions: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
        })
      })
    ],
    view: new ol.View({
      center: ol.proj.fromLonLat([9.109674844339935, 55.434610698653131]),
      zoom: 10
    })
  });

  if (!window.etapeGpxFiles || !window.etapeGpxFiles.length) return;

  const colors = [
    '#347a28', '#2b4d18', '#347a28', '#2b4d18',
    '#347a28', '#2b4d18', '#347a28', '#2b4d18'
  ];

  const bounds = new ol.extent.createEmpty();

  window.etapeGpxFiles.forEach(file => {

    const color = file.color

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
      features.forEach(feature => {
        if (!feature.getGeometry()) return;
        const coords = feature.getGeometry().getCoordinates();
        if (!coords.length) return;

        const start = coords[0];
        const end = coords[coords.length - 1];

        // Start marker
        const startMarker = new ol.Feature({
          geometry: new ol.geom.Point(start),
          name: `Start ${index + 1}`
        });
        startMarker.setStyle(new ol.style.Style({
          image: new ol.style.Circle({
            radius: 7,
            fill: new ol.style.Fill({ color }),
            stroke: new ol.style.Stroke({ color: '#111', width: 1 })
          })
        }));

        // End marker
        const endMarker = new ol.Feature({
          geometry: new ol.geom.Point(end),
          name: `End ${index + 1}`
        });
        endMarker.setStyle(new ol.style.Style({
          image: new ol.style.Circle({
            radius: 7,
            fill: new ol.style.Fill({ color }),
            stroke: new ol.style.Stroke({ color: '#111', width: 4 })
          })
        }));

        const markerSource = new ol.source.Vector({
          features: [startMarker, endMarker]
        });
        map.addLayer(new ol.layer.Vector({ source: markerSource }));

        // Extend map bounds
        coords.forEach(c => ol.extent.extend(bounds, c));
      });

      // Fit map to all GPX tracks
      if (ol.extent.isEmpty(bounds) === false) {
        map.getView().fit(bounds, { padding: [40, 40, 40, 40] });
      }
    });

  });

  /*
  // Optional: add a parking GPX
  const parkingUrl = '/korttest/wpt/parking.gpx';
  const parkingSource = new ol.source.Vector({
    url: parkingUrl,
    format: new ol.format.GPX()
  });

  const parkingLayer = new ol.layer.Vector({
    source: parkingSource,
    style: new ol.style.Style({
      image: new ol.style.Circle({
        radius: 10,
        fill: new ol.style.Fill({ color: '#000' }),
        stroke: new ol.style.Stroke({ color: '#fff', width: 2 })
      })
    })
  });

  map.addLayer(parkingLayer);
*/
});
