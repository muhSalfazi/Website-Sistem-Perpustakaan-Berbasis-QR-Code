import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import timegridPlugin from '@fullcalendar/timegrid';

const calendarPlugins = {
  dayGrid: dayGridPlugin,
  interaction: interactionPlugin,
  list: listPlugin,
  timeGrid: timegridPlugin
};

try {
  window.Calendar = Calendar;
  window.dayGridPlugin = dayGridPlugin;
  window.interactionPlugin = interactionPlugin;
  window.listPlugin = listPlugin;
  window.timegridPlugin = timegridPlugin;
} catch (e) {}

export { Calendar, dayGridPlugin, interactionPlugin, listPlugin, timegridPlugin };
