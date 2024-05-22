import leaFlet from 'leaflet';

import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

delete leaFlet.Icon.Default.prototype._getIconUrl;

leaFlet.Icon.Default.mergeOptions({
  iconRetinaUrl: markerIcon2x,
  iconUrl: markerIcon,
  shadowUrl: markerShadow
});

try {
  window.leaFlet = leaFlet;
} catch (e) {}

export { leaFlet };
