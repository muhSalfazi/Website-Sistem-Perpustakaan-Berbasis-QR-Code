import moment from 'moment/moment';

try {
  window.moment = moment;
} catch (e) {}

export { moment };
