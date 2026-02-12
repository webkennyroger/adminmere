import ApexCharts from 'apexcharts';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { Calendar } from '@fullcalendar/core';
import intersect from '@alpinejs/intersect';
import { initThemeStore } from './theme';
import { initSidebarStore } from './components/sidebar';
import { initChatStore } from './components/chat';

// 1. Define Store Registration
const registerStores = () => {
    try {
        if (!window.Alpine) return;
        if (window.Alpine.store('theme')) return;

        console.log('Registering Alpine Stores...');
        initThemeStore();
        initSidebarStore();
        initChatStore();

        if (typeof intersect !== 'undefined') {
            window.Alpine.plugin(intersect);
        }

        console.log('Alpine Stores Ready');
        window.mereStoresReady = true;
    } catch (e) {
        console.error('Store Registration Error:', e);
    }
};

// 2. Immediate & Event-based Registration
if (window.Alpine) {
    registerStores();
} else {
    document.addEventListener('alpine:init', registerStores);
}

document.addEventListener('livewire:init', () => {
    if (!window.mereStoresReady) registerStores();
});

// 3. Bootstrap (Echo/Pusher) - Safe Load
import('./bootstrap').catch(e => console.error('Bootstrap Load Error:', e));
import('./components/toast').catch(e => console.error('Toast Load Error:', e));

// 4. Global Libraries & Config
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

const Portuguese = {
    weekdays: { shorthand: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"], longhand: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"] },
    months: { shorthand: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"], longhand: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"] },
    rangeSeparator: " até ",
    time_24hr: true,
};
flatpickr.localize(Portuguese);

// 5. Component Initialization
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
