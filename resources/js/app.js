import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import { commandPalette } from './command-palette';
import { initTheme } from './theme';
import { registerToastStore } from './toast';

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.data('commandPalette', commandPalette);
registerToastStore(Alpine);

initTheme();

Alpine.start();
