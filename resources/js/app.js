import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import { initTheme } from './theme';

window.Alpine = Alpine;

Alpine.plugin(focus);

initTheme();

Alpine.start();
