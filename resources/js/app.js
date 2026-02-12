import './bootstrap';
import './components/toast';
import ApexCharts from 'apexcharts';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { Calendar } from '@fullcalendar/core';
import intersect from '@alpinejs/intersect';

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

// Single point of initialization for Alpine stores
const registerStores = () => {
    try {
        if (!window.Alpine) {
            console.error('Alpine not found during store registration');
            return;
        }
        
        // Prevent duplicate registration
        if (window.Alpine.store('theme')) {
            console.log('Stores already registered, skipping...');
            return;
        }

        console.log('Registering Alpine Stores...');

        // Initialize stores
        initThemeStore();
        initSidebarStore();
        initChatStore();

        // Register plugins
        if (typeof intersect !== 'undefined') {
            window.Alpine.plugin(intersect);
        }

        console.log('Alpine Stores & Plugins Ready');
        window.mereStoresReady = true;
    } catch (e) {
        console.error('Error in registerStores:', e);
    }
};

// Listen for Alpine initialization
if (window.Alpine) {
    registerStores();
} else {
    document.addEventListener('alpine:init', registerStores);
}

// Fallback for Livewire
document.addEventListener('livewire:init', () => {
    if (!window.mereStoresReady) {
        registerStores();
    }
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
