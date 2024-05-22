import Bloodhound from 'typeahead.js/dist/bloodhound';

try {
  window.Bloodhound = Bloodhound;
} catch (e) {}

export { Bloodhound };
