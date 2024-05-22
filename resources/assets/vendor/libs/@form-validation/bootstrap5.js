import { Bootstrap5 } from '@form-validation/plugin-bootstrap5';

try {
  FormValidation.plugins.Bootstrap5 = Bootstrap5;
} catch (e) {}

export { Bootstrap5 };
