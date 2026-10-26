import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import { commandPalette } from './command-palette';
import { highlightCodeBlocks } from './code-highlight';
import { paletteLab } from './palette-lab';
import { initTheme } from './theme';
import { registerToastStore } from './toast';

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.data('commandPalette', commandPalette);
Alpine.data('paletteLab', paletteLab);
registerToastStore(Alpine);

initTheme();

Alpine.start();
highlightCodeBlocks();
