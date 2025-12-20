<div wire:ignore>
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <x-common.page-breadcrumb pageTitle="Calendário" />
        <button
            class="btn-create-main px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Novo Evento
        </button>
    </div>

    <div class="rounded-2xl border border-zinc-200 bg-white pt-4 dark:border-zinc-800 dark:bg-zinc-900">
        <div id="calendar" class="p-4 min-h-[600px]"></div>
    </div>

    <!-- Modal de Criar/Editar Evento -->
    <div id="eventModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50"
        style="display: none;">
        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="eventModalLabel" class="text-lg font-semibold text-zinc-900 dark:text-white">Adicionar
                        Evento</h3>
                    <button type="button"
                        class="modal-close-btn text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Título do Evento -->
                    <div>
                        <label for="event-title"
                            class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Título do Evento <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="event-title"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg dark:bg-zinc-800 dark:text-white"
                            placeholder="Digite o título do evento">
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="event-description"
                            class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Descrição
                        </label>
                        <textarea id="event-description"
                            class="w-full h-32 px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg dark:bg-zinc-800 dark:text-white resize-none"
                            placeholder="Descrição do evento"></textarea>
                    </div>

                    <!-- Data de Início -->
                    <div>
                        <x-form.date-picker label="Data *" name="event-start-date" id="event-start-date"
                            placeholder="Selecione a data" />
                    </div>

                    <!-- Hora -->
                    <div>
                        <x-form.date-picker label="Hora" name="event-time" id="event-time" mode="time" dateFormat="H:i"
                            placeholder="Selecione a hora" />
                    </div>

                    <!-- Tipo de Evento (Cor) -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Tipo de Evento
                        </label>
                        <div class="flex gap-4 flex-wrap">
                            <label class="flex items-center">
                                <input type="radio" name="event-level" value="Danger" class="mr-2">
                                <span class="text-sm text-red-600">Urgente</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="event-level" value="Success" class="mr-2">
                                <span class="text-sm text-green-600">Sucesso</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="event-level" value="Primary" class="mr-2" checked>
                                <span class="text-sm text-blue-600">Normal</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="event-level" value="Warning" class="mr-2">
                                <span class="text-sm text-yellow-600">Aviso</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Ações do Modal -->
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button"
                        class="modal-close-btn px-4 py-2 bg-zinc-200 text-zinc-800 rounded-lg hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200">
                        Cancelar
                    </button>
                    <button type="button"
                        class="btn-add-event px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Adicionar Evento
                    </button>
                    <button type="button"
                        class="btn-update-event px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                        style="display: none;">
                        Atualizar Evento
                    </button>
                    <button type="button"
                        class="btn-delete-event px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center gap-2"
                        style="display: none;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Excluir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Visualização de Evento -->
    <div id="viewEventModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50"
        style="display: none;">
        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Detalhes do Evento</h3>
                    <button type="button"
                        class="view-modal-close-btn text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <h4 id="view-event-title" class="text-xl font-bold text-zinc-900 dark:text-white"></h4>
                    </div>

                    <div id="view-event-description-container" class="hidden">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Descrição</label>
                        <p id="view-event-description" class="text-zinc-600 dark:text-zinc-400"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Data</label>
                        <p id="view-event-date" class="text-zinc-600 dark:text-zinc-400"></p>
                    </div>
                </div>

                <!-- Ações do Modal de Visualização -->
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button"
                        class="view-modal-close-btn px-4 py-2 bg-zinc-200 text-zinc-800 rounded-lg hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200">
                        Fechar
                    </button>
                    <button type="button"
                        class="btn-edit-from-view px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Editar
                    </button>
                    <button type="button"
                        class="btn-delete-event-view px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Excluir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var eventModal = document.getElementById('eventModal');
            var viewEventModal = document.getElementById('viewEventModal');
            var currentEventId = null;

            const closeModal = () => {
                eventModal.style.display = 'none';
                viewEventModal.style.display = 'none';
            }

            // Close buttons
            document.querySelectorAll('.modal-close-btn').forEach(btn => {
                btn.addEventListener('click', closeModal);
            });
            document.querySelectorAll('.view-modal-close-btn').forEach(btn => {
                btn.addEventListener('click', closeModal);
            });

            // Initialize Calendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'pt-br',
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia'
                },
                editable: true,
                selectable: true,
                events: @json($this->getEvents()),

                select: function (info) {
                    // Open modal for creating event
                    currentEventId = null;
                    document.getElementById('eventModalLabel').textContent = 'Adicionar Evento';
                    document.getElementById('event-title').value = '';
                    document.getElementById('event-description').value = '';

                    const dateInput = document.getElementById('event-start-date');
                    if (dateInput && dateInput._flatpickr) {
                        dateInput._flatpickr.setDate(info.startStr);
                    } else if (dateInput) {
                        dateInput.value = info.startStr;
                    }

                    document.querySelector('.btn-add-event').style.display = 'inline-block';
                    document.querySelector('.btn-update-event').style.display = 'none';
                    document.querySelector('.btn-delete-event').style.display = 'none';

                    eventModal.style.display = 'flex';
                },

                eventClick: function (info) {
                    // View event details
                    var event = info.event;
                    currentEventId = event.id;

                    document.getElementById('view-event-title').textContent = event.title;
                    document.getElementById('view-event-date').textContent = event.start.toLocaleDateString('pt-BR');

                    // Show modal
                    viewEventModal.style.display = 'flex';

                    // Setup delete button in view modal
                    document.querySelector('.btn-delete-event-view').onclick = function () {
                        if (confirm('Tem certeza que deseja excluir?')) {
                            @this.deleteEvent(currentEventId).then(() => {
                                event.remove();
                                closeModal();
                                window.showToast('success', 'Evento excluído com sucesso!');
                            });
                        }
                    };

                    // Setup edit button in view modal
                    document.querySelector('.btn-edit-from-view').onclick = function () {
                        closeModal();

                        // Populate edit modal
                        document.getElementById('eventModalLabel').textContent = 'Editar Evento';
                        document.getElementById('event-title').value = event.title;

                        // Handle description safely
                        const desc = event.extendedProps.description || '';
                        document.getElementById('event-description').value = desc;

                        const dateInput = document.getElementById('event-start-date');
                        const startStr = event.start.toISOString().split('T')[0];
                        if (dateInput && dateInput._flatpickr) {
                            dateInput._flatpickr.setDate(startStr);
                        } else if (dateInput) {
                            dateInput.value = startStr;
                        }

                        // Set level
                        const level = event.extendedProps.calendar || 'Primary';
                        const radio = document.querySelector(`input[name="event-level"][value="${level}"]`);
                        if (radio) radio.checked = true;

                        document.querySelector('.btn-add-event').style.display = 'none';
                        document.querySelector('.btn-update-event').style.display = 'inline-block';
                        document.querySelector('.btn-delete-event').style.display = 'inline-block';

                        // Update button logic
                        document.querySelector('.btn-update-event').onclick = function () {
                            var title = document.getElementById('event-title').value;
                            var description = document.getElementById('event-description').value;
                            var startDate = document.getElementById('event-start-date').value;
                            var level = document.querySelector('input[name="event-level"]:checked').value;

                            @this.updateEvent(currentEventId, title, startDate, startDate, level).then(() => {
                                event.setProp('title', title);
                                event.setStart(startDate);
                                event.setExtendedProp('calendar', level);
                                event.setExtendedProp('description', description);
                                closeModal();
                                window.showToast('success', 'Evento atualizado com sucesso!');
                            });
                        };

                        // Delete button in edit modal
                        document.querySelector('.btn-delete-event').onclick = function () {
                            if (confirm('Tem certeza que deseja excluir?')) {
                                @this.deleteEvent(currentEventId).then(() => {
                                    event.remove();
                                    closeModal();
                                    window.showToast('success', 'Evento excluído com sucesso!');
                                });
                            }
                        };

                        eventModal.style.display = 'flex';
                    };


                },
                eventDrop: function (info) {
                    // Handle drag and drop update
                    @this.updateEvent(
                        info.event.id,
                        info.event.title,
                        info.event.start.toISOString(),
                        info.event.end ? info.event.end.toISOString() : info.event.start.toISOString(),
                        info.event.extendedProps.calendar || 'Primary'
                    );
                }
            });

            calendar.render();

            // Add Event Button Logic
            document.querySelector('.btn-add-event').addEventListener('click', function () {
                var title = document.getElementById('event-title').value;
                var description = document.getElementById('event-description').value;
                var startDate = document.getElementById('event-start-date').value;
                var level = document.querySelector('input[name="event-level"]:checked').value;

                if (!title || !startDate) {
                    alert('Preencha os campos obrigatórios');
                    return;
                }

                @this.createEvent(title, startDate, startDate, level).then(() => {
                    calendar.addEvent({
                        title: title,
                        start: startDate,
                        color: getColor(level)
                    });
                    closeModal();
                    window.showToast('success', 'Evento criado com sucesso!');
                    setTimeout(() => location.reload(), 1000); // Reload to sync ID
                });
            });

            // Main Create Button Logic
            document.querySelector('.btn-create-main').addEventListener('click', function () {
                var today = new Date().toISOString().split('T')[0];

                currentEventId = null;
                document.getElementById('eventModalLabel').textContent = 'Adicionar Evento';
                document.getElementById('event-title').value = '';
                document.getElementById('event-description').value = '';

                const dateInput = document.getElementById('event-start-date');
                if (dateInput && dateInput._flatpickr) {
                    dateInput._flatpickr.setDate(today);
                } else if (dateInput) {
                    dateInput.value = today;
                }

                document.querySelector('.btn-add-event').style.display = 'inline-block';
                document.querySelector('.btn-update-event').style.display = 'none';
                document.querySelector('.btn-delete-event').style.display = 'none';

                eventModal.style.display = 'flex';
            });

            function getColor(level) {
                switch (level) {
                    case 'Danger': return '#dc2626';
                    case 'Success': return '#16a34a';
                    case 'Warning': return '#ca8a04';
                    default: return '#2563eb';
                }
            }
        });
    </script>
    <style>
        /* Custom FullCalendar Styles for Dark Mode */
        .dark .fc {
            --fc-page-bg-color: #18181b;
            --fc-neutral-bg-color: #27272a;
            --fc-list-event-hover-bg-color: #3f3f46;
            --fc-border-color: #3f3f46;
            --fc-button-text-color: #fff;
            --fc-button-bg-color: #27272a;
            --fc-button-border-color: #3f3f46;
            --fc-button-hover-bg-color: #3f3f46;
            --fc-button-hover-border-color: #52525b;
            --fc-button-active-bg-color: #52525b;
            --fc-button-active-border-color: #71717a;
            color: #fff;
        }

        .dark .fc-col-header-cell-cushion,
        .dark .fc-daygrid-day-number {
            color: #e4e4e7;
        }

        .fc-event {
            cursor: pointer;
        }

        .dark .fc-theme-standard td,
        .dark .fc-theme-standard th {
            border-color: #3f3f46;
        }
    </style>
@endpush
</div>