import './bootstrap';
import './components/toast';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import ApexCharts from 'apexcharts';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { Calendar } from '@fullcalendar/core';

// Stores
import { initThemeStore } from './theme';
import { initSidebarStore } from './components/sidebar';
import { initChatStore } from './components/chat';

// 1. Initialize & Globalize Alpine
window.Alpine = Alpine;
Alpine.plugin(intersect);

// 2. Register Stores BEFORE Starting Alpine
console.log('Pre-starting: Registering Alpine Stores...');
initThemeStore();
initSidebarStore();
initChatStore();

// 3. Start Alpine
Alpine.start();
console.log('Alpine Started and Stores Registered');

// 4. Global Libraries
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

// 5. Localization & Components
const Portuguese = {
    weekdays: { shorthand: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"], longhand: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"] },
    months: { shorthand: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"], longhand: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"] },
    rangeSeparator: " até ",
    time_24hr: true,
};
flatpickr.localize(Portuguese);

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#goalChart')) {
        import('./components/goals-chart').then(m => m.initGoalChart());
    }
    if (document.querySelector('#userGrowthChart')) {
        import('./components/user-growth-chart');
    }
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(m => m.calendarInit());
    }
    import('./components/quill-editor').then(m => m.initQuillEditor());
});
