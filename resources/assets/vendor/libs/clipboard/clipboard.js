import ClipboardJS from 'clipboard';

try {
  window.ClipboardJS = ClipboardJS;
} catch (e) {}

export { ClipboardJS };
