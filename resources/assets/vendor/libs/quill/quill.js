import Quill from 'quill/dist/quill';

try {
  window.Quill = Quill;
} catch (e) {}

export { Quill };
