import FormValidation from '@form-validation/bundle/popular'

try {
  window.FormValidation = FormValidation;
} catch (e) {}

export { FormValidation };

