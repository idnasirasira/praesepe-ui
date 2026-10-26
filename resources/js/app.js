import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import { initTheme } from './theme';
import { registerToastStore } from './toast';

window.Alpine = Alpine;

Alpine.plugin(focus);
registerToastStore(Alpine);

initTheme();

Alpine.start();
