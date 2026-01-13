import './bootstrap';
import './components/toast';
import ApexCharts from 'apexcharts';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { Calendar } from '@fullcalendar/core';
import intersect from '@alpinejs/intersect';

// Register Alpine plugins via alpine:init if needed
document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(intersect);
});

// Configuração de localização em Português
const Portuguese = {
    weekdays: {
        shorthand: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
        longhand: [
            "Domingo",
            "Segunda-feira",
            "Terça-feira",
            "Quarta-feira",
            "Quinta-feira",
            "Sexta-feira",
            "Sábado",
        ],
    },
    months: {
        shorthand: [
            "Jan", "Fev", "Mar", "Abr", "Mai", "Jun",
            "Jul", "Ago", "Set", "Out", "Nov", "Dez",
        ],
        longhand: [
            "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro",
        ],
    },
    rangeSeparator: " até ",
    time_24hr: true,
};

// Expor bibliotecas globalmente
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

// Configurar flatpickr em português
flatpickr.localize(Portuguese);

// Alpine Stores Initialization
import { initThemeStore } from './theme';
import { initSidebarStore } from './components/sidebar';
import { initChatStore } from './components/chat';

document.addEventListener('alpine:init', () => {
    initThemeStore();
    initSidebarStore();
    initChatStore();
});

// Inicializar componentes quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    // Gráficos
    if (document.querySelector('#goalChart')) {
        import('./components/goals-chart').then(module => module.initGoalChart());
    }
    // Gráfico de Crescimento de Usuários
    if (document.querySelector('#userGrowthChart')) {
        import('./components/user-growth-chart');
    }

    // Calendário
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(module => module.calendarInit());
    }

    // Quill Editor
    import('./components/quill-editor').then(module => module.initQuillEditor());
});
