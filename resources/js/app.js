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
    // quillEditor removed to fix build. Will be moved to inline script if needed.
});

// Alpine.start();

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Map imports
    // if (document.querySelector('#mapOne')) {
    //     import('./components/map').then(module => module.initMap());
    // }

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
    // if (document.querySelector('#chartSix')) {
    //     import('./components/chart/chart-6').then(module => module.initChartSix());
    // }
    // if (document.querySelector('#chartEight')) {
    //     import('./components/chart/chart-8').then(module => module.initChartEight());
    // }
    // if (document.querySelector('#chartThirteen')) {
    //     import('./components/chart/chart-13').then(module => module.initChartThirteen());
    // }

    // Calendar init
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(module => module.calendarInit());
    }

    // New Chart imports
    if (document.querySelector('#userGrowthChart')) {
        import('./charts/user-growth').then(module => module.initUserGrowthChart());
    }
});

document.addEventListener('alpine:init', () => {
    Alpine.data('quillEditor', (
        model, // wire:model
        elementId, // unique ID
        initialValue = '', // value from backend
        livewireComponent // to emit events
    ) => ({
        quill: null,
        content: initialValue,

        init() {
            // Wait for Quill to load from CDN
            if (typeof window.Quill === 'undefined') {
                console.error('Quill is not loaded. Please ensure the CDN script is included.');
                return;
            }

            this.quill = new window.Quill(this.$refs.editor, {
                theme: 'snow',
                placeholder: this.$el.getAttribute('placeholder') || 'Escreva algo...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
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

            // Sync changes to Livewire
            this.quill.on('text-change', () => {
                this.content = this.quill.root.innerHTML;
                
                // Update wire:model
                if (model) {
                    this.$wire.set(model, this.content);
                }
                
                // Dispatch event for other listeners
                this.$dispatch('input', this.content);
            });

            // Listen for external updates (e.g. from Livewire)
            this.$watch('content', (value) => {
                if (this.quill.root.innerHTML !== value) {
                    this.quill.root.innerHTML = value;
                }
            });
            
             // Listen for custom event to reset/update content
            window.addEventListener('update-quill-event-description', (e) => {
                 if (e.detail.id === elementId) {
                     this.quill.root.innerHTML = e.detail.content;
                 }
            });
        }
    }));
});

document.addEventListener('alpine:init', () => {
    Alpine.data('quillEditor', (
        model, // wire:model
        elementId, // unique ID
        initialValue = '', // value from backend
        livewireComponent // to emit events
    ) => ({
        quill: null,
        content: initialValue,

        init() {
            // Wait for Quill to load from CDN
            if (typeof window.Quill === 'undefined') {
                console.error('Quill is not loaded. Please ensure the CDN script is included.');
                return;
            }

            this.quill = new window.Quill(this.$refs.editor, {
                theme: 'snow',
                placeholder: this.$el.getAttribute('placeholder') || 'Escreva algo...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
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

            // Sync changes to Livewire
            this.quill.on('text-change', () => {
                this.content = this.quill.root.innerHTML;
                
                // Update wire:model
                if (model) {
                    this.$wire.set(model, this.content);
                }
                
                // Dispatch event for other listeners
                this.$dispatch('input', this.content);
            });

            // Listen for external updates (e.g. from Livewire)
            this.$watch('content', (value) => {
                if (this.quill.root.innerHTML !== value) {
                    this.quill.root.innerHTML = value;
                }
            });
            
             // Listen for custom event to reset/update content
            window.addEventListener('update-quill-event-description', (e) => {
                 if (e.detail.id === elementId) {
                     this.quill.root.innerHTML = e.detail.content;
                 }
            });
        }
    }));
});
