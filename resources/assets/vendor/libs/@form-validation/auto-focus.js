import { AutoFocus } from '@form-validation/plugin-auto-focus';

try {
  FormValidation.plugins.AutoFocus = AutoFocus;
} catch (e) {}

export { AutoFocus };
