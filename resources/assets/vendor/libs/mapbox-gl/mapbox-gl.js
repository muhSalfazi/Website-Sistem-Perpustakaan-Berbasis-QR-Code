import mapboxgl from 'mapbox-gl';

try {
  window.mapboxgl = mapboxgl;
} catch (e) {}

export { mapboxgl };
