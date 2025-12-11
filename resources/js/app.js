import './bootstrap';
import './components/toast';
// import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

// flatpickr
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

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
      "Jan",
      "Fev",
      "Mar",
      "Abr",
      "Mai",
      "Jun",
      "Jul",
      "Ago",
      "Set",
      "Out",
      "Nov",
      "Dez",
    ],
    longhand: [
      "Janeiro",
      "Fevereiro",
      "Março",
      "Abril",
      "Maio",
      "Junho",
      "Julho",
      "Agosto",
      "Setembro",
      "Outubro",
      "Novembro",
      "Dezembro",
    ],
  },
  rangeSeparator: " até ",
  time_24hr: true,
};

// FullCalendar
import { Calendar } from '@fullcalendar/core';

// window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
flatpickr.localize(Portuguese);
window.FullCalendar = Calendar;

document.addEventListener('alpine:init', () => {
    Alpine.data('quillEditor', ({ content, placeholder, name, theme, modelId }) => ({
        content: content,
        quill: null,
        modelId: modelId,
        init() {
            this.quill = new Quill(this.$refs.editor, {
                theme: theme || 'snow',
                placeholder: placeholder,
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'font': [] }],
                        [{ 'align': [] }],
                        ['clean']
                    ]
                }
            });

            // Set initial content
            if (this.content) {
                this.quill.root.innerHTML = this.content;
            }

            this.quill.on('text-change', () => {
                this.content = this.quill.root.innerHTML;
                if (name && this.$refs.hiddenInput) {
                    this.$refs.hiddenInput.value = this.content;
                    // Dispatch input event for wire:model handling if needed
                    this.$refs.hiddenInput.dispatchEvent(new Event('input'));
                }
            });

            this.$watch('content', (value) => {
                if (value !== this.quill.root.innerHTML) {
                    this.quill.root.innerHTML = value || '';
                }
            });

            // Listener for external updates via custom event
            if (this.modelId) {
                window.addEventListener('update-quill-' + this.modelId, (e) => {
                    this.content = e.detail;
                    this.quill.root.innerHTML = e.detail;
                });
            }
        }
    }));
});

// Alpine.start();

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Map imports
    if (document.querySelector('#mapOne')) {
        import('./components/map').then(module => module.initMap());
    }

    // Chart imports
    if (document.querySelector('#chartOne')) {
        import('./components/chart/chart-1').then(module => module.initChartOne());
    }
    if (document.querySelector('#chartTwo')) {
        import('./components/chart/chart-2').then(module => module.initChartTwo());
    }
    if (document.querySelector('#chartThree')) {
        import('./components/chart/chart-3').then(module => module.initChartThree());
    }
    if (document.querySelector('#chartSix')) {
        import('./components/chart/chart-6').then(module => module.initChartSix());
    }
    if (document.querySelector('#chartEight')) {
        import('./components/chart/chart-8').then(module => module.initChartEight());
    }
    if (document.querySelector('#chartThirteen')) {
        import('./components/chart/chart-13').then(module => module.initChartThirteen());
    }

    // Calendar init
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(module => module.calendarInit());
    }

    // New Chart imports
    if (document.querySelector('#userGrowthChart')) {
        import('./charts/user-growth').then(module => module.initUserGrowthChart());
    }
});
