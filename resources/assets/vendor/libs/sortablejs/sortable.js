import Sortable from 'sortablejs/Sortable';

try {
  window.Sortable = Sortable;
} catch (e) {}

export { Sortable };
