import toastr from 'toastr/toastr';

try {
  window.toastr = toastr;
} catch (e) {}

export { toastr };
