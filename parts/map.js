document.addEventListener("DOMContentLoaded", () => {
  if (!document.getElementById("map")) return;

  // Register EPSG:25832 projection
  proj4.defs('EPSG:25832', "+proj=utm +zone=32 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs");
  ol.proj.proj4.register(proj4);
  const projection = new ol.proj.Projection({ code: 'EPSG:25832', units: 'm' });

  const centerLatLon = [8.974675, 55.409203]; // [lon, lat]
  const centerProjected = ol.proj.transform(centerLatLon, 'EPSG:4326', 'EPSG:25832');

  // Create map
  const map = new ol.Map({
    target: "map",
    layers: [
      new ol.layer.Tile({
        source: new ol.source.WMTS({
          layer: 'nfkort',
          urls: ['/wp-content/themes/kongeaastien/proxy.php'],
          matrixSet: 'View1',
          wrapX: false,
          crossOrigin: 'anonymous',
          tileGrid: new ol.tilegrid.WMTS({
            matrixIds: ["L00","L01","L02","L03","L04","L05","L06","L07","L08","L09","L10","L11","L12","L13"],
            resolutions: [1638.4,819.2,409.6,204.8,102.4,51.2,25.6,12.8,6.4,3.2,1.6,0.8],
            extent: [120000.0,5900000.0,1000000.0,6500000.0],
            tileSize: 256
          })
        })
      })
    ],
    view: new ol.View({
      center: centerProjected,
      zoom: 12,
      maxZoom: 17,
      minZoom: 12,
      projection: projection
    })
  });

  // Overlay for popup
  const popup = document.createElement('div');
  popup.id = 'popup';
  popup.className = 'popup ol-popup bg-white shadow-[0_0_10px_rgba(0,0,0,0.75)] pr-10 rounded-md p-3';
  document.body.appendChild(popup);

  const overlay = new ol.Overlay({
    element: popup,
    positioning: 'bottom-center',
    stopEvent: true,
    offset: [0, -10],
  });
  map.addOverlay(overlay);

  // Select interaction for vector layers
  const select = new ol.interaction.Select({
    layers: layer => layer instanceof ol.layer.Vector,
  });
  map.addInteraction(select);

  if (!window.etapeGpxFiles || !window.etapeGpxFiles.length) return;

  const bounds = ol.extent.createEmpty();

  window.etapeGpxFiles.forEach((file, index) => {
    const color = file.color || '#347a28';

    const vectorSource = new ol.source.Vector({
      url: file.url,
      format: new ol.format.GPX()
    });

    vectorSource.on('addfeature', function (e) {
      const feature = e.feature;
      console.log("file", file);
      feature.set('name', file.name);
      feature.set('laengde', file.laengde);
      feature.set('etapenr', file.etapenr);
      feature.set('etapenummer', file.etapenummer);
      feature.set('readmore', file.readmore);
    });

    const vectorLayer = new ol.layer.Vector({
      source: vectorSource,
      style: new ol.style.Style({
        stroke: new ol.style.Stroke({ color: color, width: 4 })
      }),
      zIndex: 1
    });

    map.addLayer(vectorLayer);

    // Wait for GPX to load
    vectorSource.once('change', () => {
      if (vectorSource.getState() !== 'ready') return;

      const features = vectorSource.getFeatures();
      features.forEach((feature, index) => {
        const geometry = feature.getGeometry();
        if (!geometry) return;

        let coords = geometry.getCoordinates();
        if (geometry.getType() === 'MultiLineString') {
          coords = coords[0]; // take first segment
        }

        console.log('coords[0] (already in map units):', coords[0]);

        // Extend bounds
        coords.forEach(c => ol.extent.extend(bounds, c));

        // Start marker
        const start = coords[0];

        const startMarker = new ol.Feature({
          geometry: new ol.geom.Point(start),
          name: `${file.name}`,
          laengde: file.laengde,
          etapenr: file.etapenr || `${index + 1}`,
          readmore: file.readmore
        });

        startMarker.setStyle(new ol.style.Style({
          image: new ol.style.Icon({
            anchor: [0.5, 1], // bottom-center of pin
            src: createNumberedPinIcon('#2B4D18', file.etapenummer),
            scale: 1
          })
        }));

        map.addLayer(new ol.layer.Vector({
          source: new ol.source.Vector({ features: [startMarker] }),
          zIndex: 10
        }));
      });

      // Fit map to bounds
      if (!ol.extent.isEmpty(bounds)) {
        map.getView().fit(bounds, { padding: [40, 40, 40, 40], duration: 1000 });
      }
    });
  });

  // Track last click
  let lastClickCoord = null;
  let lastClickPixel = null;
  map.on('click', evt => {
    lastClickCoord = evt.coordinate;
    lastClickPixel = evt.pixel;
  });

  // Popup on select
  select.on('select', e => {
    const feature = e.selected[0];
    if (!feature) {
      overlay.setPosition(undefined);
      return;
    }
    console.log("leangde");
    console.log(feature.get('laengde'), typeof feature.get('laengde'));
    const geometry = feature.getGeometry();
    if (!geometry) return;
    console.log("feature", feature);
    console.log(feature);
    const name = feature.get('name') || 'Unnamed path';
    const laengde = feature.get('laengde')
      ? `${feature.get('laengde')} km.`
      : '';
    const etapenr = feature.get('etapenr') ? feature.get('etapenr') : 'Etapen';
    const etapenummer = feature.get('etapenummer') || 'Etapen';
    const readmore = feature.get('readmore') || 'Læs mere';

    const mapSize = map.getSize();
    const view = map.getView();
    const resolution = view.getResolution();
    let coord = lastClickCoord;

    const dx = lastClickCoord[0] - coord[0];
    const dy = lastClickCoord[1] - coord[1];

// Convert map units → pixels
    const px = dx / resolution;
    const py = dy / resolution;

    let positionClass = 'center';

    if (Math.abs(px) > Math.abs(py)) {
      positionClass = px > 0 ? 'left' : 'right';
    } else {
      positionClass = py > 0 ? 'bottom' : 'top';
    }

    popup.classList.add(positionClass);

       popup.innerHTML = `
      <div class="top-row text-xs">
        <span>${etapenr}</span>
        <span>${laengde}</span>
      </div>
      <div class="text-lg font-light">${name}</div>
      <div class="mt-4 text-xs color-darkgrean underline">${readmore}</div>
      <div class="popup-arrow"></div>
    `;


    if (geometry.getType() === 'LineString') {
      coord = geometry.getClosestPoint(lastClickCoord);
    }

    const pixel = lastClickPixel;
    const coordinate = map.getCoordinateFromPixel(pixel);

    overlay.setPosition(coord);

    setTimeout(() => {
      if (!lastClickPixel) return;

      const popupRect = popup.getBoundingClientRect();

      const popupCenterX = popupRect.left + popupRect.width / 2;
      const popupCenterY = popupRect.top + popupRect.height / 2;

      const dx = lastClickPixel[0] - popupCenterX;
      const dy = lastClickPixel[1] - popupCenterY;

      let positionClass = 'center';

      if (Math.abs(dx) > Math.abs(dy)) {
        positionClass = dx > 0 ? 'left' : 'right';
      } else {
        positionClass = dy > 0 ? 'top' : 'bottom';
      }

      popup.classList.remove('left', 'right', 'top', 'bottom');
      popup.classList.add(positionClass);
    }, 0);
  });

  // Change cursor over vector features
  map.on('pointermove', evt => {
    const hit = map.hasFeatureAtPixel(evt.pixel, {
      layerFilter: layer => layer instanceof ol.layer.Vector
    });
    map.getTargetElement().style.cursor = hit ? 'pointer' : '';
  });

  if (window.mapPoints && window.mapPoints.length) {
    const markerLayer = new ol.layer.Vector({
      source: new ol.source.Vector(),
      zIndex: 20
    });

    map.addLayer(markerLayer);

    window.mapPoints.forEach(point => {
      if (!point.lat || !point.lng) return;

      const coord = ol.proj.transform(
        [parseFloat(point.lng), parseFloat(point.lat)],
        'EPSG:4326',
        'EPSG:25832'
      );

      const feature = new ol.Feature({
        geometry: new ol.geom.Point(coord),
        name: point.title,
        category: point.category,
        image: point.image
      });

      // Simple icon (you can customize per category)
      feature.setStyle(new ol.style.Style({
        image: new ol.style.Icon({
          src: getCategoryIcon(point.category),
          scale: 0.8,
          anchor: [0.5, 1]
        })
      }));

      markerLayer.getSource().addFeature(feature);
    });
  }

  function createNumberedPinIcon(color, number) {
    const svg = `
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="41" viewBox="0 0 25 41">
      <path
        d="M12.5 0.5
           C5.8 0.5 0.5 5.8 0.5 12.5
           C0.5 19.9 6.4 24.6 9.2 29.2
           C10.4 31.2 11.1 33.7 12.5 40.5
           C13.9 33.7 14.6 31.2 15.8 29.2
           C18.6 24.6 24.5 19.9 24.5 12.5
           C24.5 5.8 19.2 0.5 12.5 0.5 Z"
        fill="${color}"
        stroke="#1f2933"
        stroke-width="1"
      />
      <circle cx="12.5" cy="13" r="7" fill="${color}" />
      <text x="12.5" y="16"
            text-anchor="middle"
            font-size="10"
            font-family="system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif"
            fill="#ffffff"
            font-weight="700">
        ${number}
      </text>
    </svg>
  `;
    return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
  }

  function getCategoryIcon(category) {
    switch (category) {
      case 'shelter':
        return '/icons/shelter.png';
      case 'toilet':
        return 'https://www.icsafety.dk/6903-large_default/na013-lejrplads-med-shelter.jpg';
      default:
        return '/icons/default-pin.png';
    }
  }
});
