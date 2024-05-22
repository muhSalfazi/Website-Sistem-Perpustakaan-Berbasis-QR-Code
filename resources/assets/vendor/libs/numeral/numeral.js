import numeral from 'numeral';
import 'numeral/locales';

try {
  window.numeral = numeral;
} catch (e) {}

export { numeral };
