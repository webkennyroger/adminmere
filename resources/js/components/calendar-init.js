import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin from "@fullcalendar/list";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

export function calendarInit() {
  const calendarWrapper = document.querySelector("#calendar");

  if (calendarWrapper) {
    // Calendar Modal Elements
    const getModalTitleEl = document.querySelector("#event-title");
    const getModalDescriptionEl = document.querySelector("#event-description");
    const getModalStartDateEl = document.querySelector("#event-start-date");
    const getModalTimeEl = document.querySelector("#event-time");
    const getModalPhotoEl = document.querySelector("#event-photo");
    const getModalAddBtnEl = document.querySelector(".btn-add-event");
    const getModalUpdateBtnEl = document.querySelector(".btn-update-event");
    const getModalDeleteBtnEl = document.querySelector(".btn-delete-event");
    const getModalHeaderEl = document.querySelector("#eventModalLabel");

    // Calendar Elements and options
    const calendarEl = document.querySelector("#calendar");

    const calendarHeaderToolbar = {
      left: "prev,next addEventButton",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay",
    };

    // Modal Functions
    const openModal = () => {
      const modal = document.getElementById("eventModal");
      if (modal) {
        modal.style.display = "flex";
        document.body.style.overflow = "hidden";
      }
    };

    const closeModal = () => {
      const modal = document.getElementById("eventModal");
      if (modal) {
        modal.style.display = "none";
        document.body.style.overflow = "";
      }
      resetModalFields();
    };

    const openViewModal = () => {
      const modal = document.getElementById("viewEventModal");
      if (modal) {
        modal.style.display = "flex";
        document.body.style.overflow = "hidden";
      }
    };

    const closeViewModal = () => {
      const modal = document.getElementById("viewEventModal");
      if (modal) {
        modal.style.display = "none";
        document.body.style.overflow = "";
      }
    };

    // Show delete confirmation modal
    const showDeleteConfirmation = (onConfirm) => {
      const confirmModal = document.getElementById("confirmDeleteModal");
      const confirmBtn = confirmModal.querySelector(".confirm-delete-btn");
      const cancelBtn = confirmModal.querySelector(".cancel-delete-btn");

      if (confirmModal) {
        confirmModal.style.display = "flex";
      }

      confirmBtn.onclick = () => {
        onConfirm();
        confirmModal.style.display = "none";
      };

      cancelBtn.onclick = () => {
        confirmModal.style.display = "none";
      };
    };

    // Reset modal fields
    function resetModalFields() {
      if (getModalTitleEl) getModalTitleEl.value = "";
      if (getModalDescriptionEl) {
        getModalDescriptionEl.value = "";
        window.dispatchEvent(new CustomEvent('update-quill-event-description', { detail: '' }));
      }
      if (getModalStartDateEl) getModalStartDateEl.value = "";
      if (getModalTimeEl) getModalTimeEl.value = "";
      if (getModalPhotoEl) getModalPhotoEl.value = "";

      const getModalIfCheckedRadioBtnEl = document.querySelector(
        'input[name="event-level"]:checked'
      );
      if (getModalIfCheckedRadioBtnEl) {
        getModalIfCheckedRadioBtnEl.checked = false;
      }
      // Set Primary as default
      const primaryRadio = document.querySelector('input[name="event-level"][value="Primary"]');
      if (primaryRadio) primaryRadio.checked = true;
    }

    // Calendar Select function
    const calendarSelect = (info) => {
      resetModalFields();

      if (getModalHeaderEl) {
        getModalHeaderEl.textContent = "Adicionar Evento";
      }

      if (getModalAddBtnEl) getModalAddBtnEl.style.display = "flex";
      if (getModalUpdateBtnEl) getModalUpdateBtnEl.style.display = "none";
      if (getModalDeleteBtnEl) getModalDeleteBtnEl.style.display = "none";

      if (getModalStartDateEl) getModalStartDateEl.value = info.startStr;

      openModal();
    };

    // Calendar AddEvent button click
    const calendarAddEvent = () => {
      resetModalFields();

      if (getModalHeaderEl) {
        getModalHeaderEl.textContent = "Adicionar Evento";
      }

      if (getModalAddBtnEl) getModalAddBtnEl.style.display = "flex";
      if (getModalUpdateBtnEl) getModalUpdateBtnEl.style.display = "none";
      if (getModalDeleteBtnEl) getModalDeleteBtnEl.style.display = "none";

      const currentDate = new Date();
      const yyyy = currentDate.getFullYear();
      const mm = String(currentDate.getMonth() + 1).padStart(2, "0");
      const dd = String(currentDate.getDate()).padStart(2, "0");
      const combineDate = `${yyyy}-${mm}-${dd}`;

      if (getModalStartDateEl) getModalStartDateEl.value = combineDate;

      openModal();
    };

    // Calendar Event Click function - Show view modal
    const calendarEventClick = (info) => {
      // Ignore clicks on edit/delete buttons - they have their own handlers
      if (info.jsEvent.target.closest('.event-edit-btn') || info.jsEvent.target.closest('.event-delete-btn')) {
        return;
      }

      const eventObj = info.event;

      // Populate view modal
      document.getElementById('view-event-title').textContent = eventObj.title;
      document.getElementById('view-event-date').textContent = eventObj.startStr;

      const typeMap = {
        'Danger': 'Urgente',
        'Success': 'Sucesso',
        'Primary': 'Normal',
        'Warning': 'Aviso'
      };
      document.getElementById('view-event-type').textContent = typeMap[eventObj.extendedProps.calendar] || 'Normal';

      // Description
      if (eventObj.extendedProps.description) {
        document.getElementById('view-event-description').innerHTML = eventObj.extendedProps.description;
        document.getElementById('view-event-description-container').classList.remove('hidden');
      } else {
        document.getElementById('view-event-description-container').classList.add('hidden');
      }

      // Time
      // Time
      if (eventObj.extendedProps.time && eventObj.extendedProps.time !== '00:00') {
        let timeStr = eventObj.extendedProps.time;
        // Parse if it is a full ISO string
        if (timeStr.includes('T')) {
            timeStr = timeStr.split('T')[1].substring(0, 5);
        }
        document.getElementById('view-event-time').textContent = timeStr;
        document.getElementById('view-event-time-container').classList.remove('hidden');
      } else {
        document.getElementById('view-event-time-container').classList.add('hidden');
      }

      // Photo
      if (eventObj.extendedProps.photo) {
        document.getElementById('view-event-photo').src = `/storage/${eventObj.extendedProps.photo}`;
        document.getElementById('view-event-photo-container').classList.remove('hidden');
      } else {
        document.getElementById('view-event-photo-container').classList.add('hidden');
      }

      // Store event ID for edit button
      document.querySelector('.btn-edit-from-view').dataset.eventId = eventObj.id;
      document.querySelector('.btn-edit-from-view').dataset.eventData = JSON.stringify(eventObj);

      openViewModal();
    };

    // Initialize Calendar
    const calendar = new Calendar(calendarEl, {
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
      selectable: true,
      initialView: "dayGridMonth",
      locale: 'pt-br',
      headerToolbar: calendarHeaderToolbar,
      buttonText: {
        today: 'Hoje',
        month: 'Mês',
        week: 'Semana',
        day: 'Dia'
      },
      events: async (fetchInfo, successCallback, failureCallback) => {
        try {
          const response = await fetch('/api/events');
          const events = await response.json();
          successCallback(events);
        } catch (error) {
          console.error('Erro ao carregar eventos:', error);
          failureCallback(error);
        }
      },
      select: calendarSelect,
      eventClick: calendarEventClick,
      displayEventTime: false,
      customButtons: {
        addEventButton: {
          text: "Adicionar Evento +",
          click: calendarAddEvent,
        },
      },
      eventContent(eventInfo) {
        const colorClass = `fc-bg-${eventInfo.event.extendedProps.calendar.toLowerCase()}`;
        return {
          html: `
            <div class="event-fc-color flex items-center justify-between fc-event-main ${colorClass} p-1 rounded-sm">
              <div class="flex items-center gap-1 flex-1 min-w-0">
                <div class="fc-daygrid-event-dot"></div>
                <div class="fc-event-title truncate">${eventInfo.event.title}</div>
              </div>
              <div class="flex items-center gap-1 ml-1 flex-shrink-0">
                <button class="event-edit-btn p-1 hover:bg-black/10 rounded" data-event-id="${eventInfo.event.id}" title="Editar">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                  </svg>
                </button>
                <button class="event-delete-btn p-1 hover:bg-red-100 rounded text-red-600" data-event-id="${eventInfo.event.id}" title="Deletar">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                  </svg>
                </button>
              </div>
            </div>
          `,
        };
      },
    });

    // Handle edit and delete button clicks within the calendar
    const handleCalendarClicks = async (e) => {
      // Handle edit button clicks on events
      const editBtn = e.target.closest(".event-edit-btn");
      if (editBtn) {
        e.stopPropagation();
        e.preventDefault();
        const eventId = editBtn.dataset.eventId;
        const event = calendar.getEventById(eventId);

        if (event) {
          // Populate edit modal
          resetModalFields();

          if (getModalHeaderEl) {
            getModalHeaderEl.textContent = "Editar Evento";
          }

          if (getModalTitleEl) getModalTitleEl.value = event.title;
          if (getModalDescriptionEl) {
            getModalDescriptionEl.value = event.extendedProps.description || "";
            window.dispatchEvent(new CustomEvent('update-quill-event-description', { detail: event.extendedProps.description || "" }));
          }
          if (getModalStartDateEl)
            getModalStartDateEl.value = event.startStr.split("T")[0];
          if (getModalTimeEl) {
            let timeVal = event.extendedProps.time || "";
            if (timeVal.includes('T')) {
                timeVal = timeVal.split('T')[1].substring(0, 5);
            }
            getModalTimeEl.value = timeVal;
          }

          const eventLevel = event.extendedProps.calendar;
          const radioBtn = document.querySelector(`input[value="${eventLevel}"]`);
          if (radioBtn) radioBtn.checked = true;

          if (getModalUpdateBtnEl) {
            getModalUpdateBtnEl.dataset.fcEventPublicId = event.id;
          }

          if (getModalAddBtnEl) getModalAddBtnEl.style.display = "none";
          if (getModalUpdateBtnEl) getModalUpdateBtnEl.style.display = "flex";
          if (getModalDeleteBtnEl) getModalDeleteBtnEl.style.display = "flex";

          openModal();
        }
      }

      // Handle delete button clicks on events
      const deleteBtn = e.target.closest(".event-delete-btn");
      if (deleteBtn) {
        e.stopPropagation();
        const eventId = deleteBtn.dataset.eventId;

        // Show confirmation modal instead of confirm()
        showDeleteConfirmation(async () => {
          try {
            const response = await fetch(`/api/events/${eventId}`, {
              method: "DELETE",
              headers: {
                "X-CSRF-TOKEN": document.querySelector(
                  'meta[name="csrf-token"]'
                ).content,
              },
            });

            if (!response.ok) throw new Error("Erro ao excluir evento");

            calendar.refetchEvents();
            window.showToast("error", "O evento foi removido do sistema!", "Evento Excluído");
          } catch (error) {
            console.error("Erro ao excluir evento:", error);
            window.showToast(
              "error",
              "Erro ao excluir evento. Por favor, tente novamente.",
              "Erro"
            );
          }
        });
      }
    };

    document.addEventListener("click", handleCalendarClicks);

    // Edit from view modal
    document.querySelector('.btn-edit-from-view').addEventListener('click', () => {
      const eventData = JSON.parse(document.querySelector('.btn-edit-from-view').dataset.eventData);

      closeViewModal();

      // Populate edit modal
      resetModalFields();

      if (getModalHeaderEl) {
        getModalHeaderEl.textContent = "Editar Evento";
      }

      if (getModalTitleEl) getModalTitleEl.value = eventData.title;
      if (getModalDescriptionEl) {
        getModalDescriptionEl.value = eventData.extendedProps.description || '';
        window.dispatchEvent(new CustomEvent('update-quill-event-description', { detail: eventData.extendedProps.description || '' }));
      }
      if (getModalStartDateEl) getModalStartDateEl.value = eventData.startStr.split("T")[0];
      if (getModalTimeEl) {
          let timeVal = eventData.extendedProps.time || '';
          if (timeVal.includes('T')) {
              timeVal = timeVal.split('T')[1].substring(0, 5);
          }
          getModalTimeEl.value = timeVal;
      }

      const eventLevel = eventData.extendedProps.calendar;
      const radioBtn = document.querySelector(`input[value="${eventLevel}"]`);
      if (radioBtn) radioBtn.checked = true;

      if (getModalUpdateBtnEl) {
        getModalUpdateBtnEl.dataset.fcEventPublicId = eventData.id;
      }

      if (getModalAddBtnEl) getModalAddBtnEl.style.display = "none";
      if (getModalUpdateBtnEl) getModalUpdateBtnEl.style.display = "flex";
      if (getModalDeleteBtnEl) getModalDeleteBtnEl.style.display = "flex";

      openModal();
    });

    // Update Calendar Event
    if (getModalUpdateBtnEl) {
      getModalUpdateBtnEl.addEventListener("click", async () => {
        const getPublicID = getModalUpdateBtnEl.dataset.fcEventPublicId;
        const getTitleUpdatedValue = getModalTitleEl.value;
        const getDescriptionValue = getModalDescriptionEl.value;
        const setModalStartDateValue = getModalStartDateEl.value;
        const getTimeValue = getModalTimeEl.value;
        const getModalUpdatedCheckedRadioBtnEl = document.querySelector(
          'input[name="event-level"]:checked'
        );

        const getModalUpdatedCheckedRadioBtnValue =
          getModalUpdatedCheckedRadioBtnEl
            ? getModalUpdatedCheckedRadioBtnEl.value
            : "Primary";

        if (!getTitleUpdatedValue) {
          window.showToast('warning', 'Por favor, insira um título para o evento', 'Atenção');
          return;
        }

        try {
          const formData = new FormData();
          formData.append('title', getTitleUpdatedValue);
          formData.append('description', getDescriptionValue);
          formData.append('start_date', setModalStartDateValue);
          formData.append('event_time', getTimeValue || '00:00');
          formData.append('event_level', getModalUpdatedCheckedRadioBtnValue);
          formData.append('_method', 'PUT');

          if (getModalPhotoEl.files[0]) {
            formData.append('photo', getModalPhotoEl.files[0]);
          }

          const response = await fetch(`/api/events/${getPublicID}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
          });

          if (!response.ok) throw new Error('Erro ao atualizar evento');

          // Reload calendar
          calendar.refetchEvents();
          closeModal();
          window.showToast('info', 'Evento atualizado com sucesso!', 'Evento Atualizado');
        } catch (error) {
          console.error('Erro ao atualizar evento:', error);
          window.showToast('error', 'Erro ao atualizar evento. Por favor, tente novamente.', 'Erro');
        }
      });
    }

    // Delete Event
    if (getModalDeleteBtnEl) {
      getModalDeleteBtnEl.addEventListener("click", async () => {
        // Show confirmation modal instead of alert
        showDeleteConfirmation(async () => {
          const getPublicID = getModalUpdateBtnEl.dataset.fcEventPublicId;

          try {
            const response = await fetch(`/api/events/${getPublicID}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              }
            });

            if (!response.ok) throw new Error('Erro ao excluir evento');

            calendar.refetchEvents();
            closeModal();
            window.showToast('error', 'O evento foi removido do sistema!', 'Evento Excluído');
          } catch (error) {
            console.error('Erro ao excluir evento:', error);
            window.showToast('error', 'Erro ao excluir evento. Por favor, tente novamente.', 'Erro');
          }
        });
      });
    }

    // Add Calendar Event
    if (getModalAddBtnEl) {
      getModalAddBtnEl.addEventListener("click", async () => {
        const getModalCheckedRadioBtnEl = document.querySelector(
          'input[name="event-level"]:checked'
        );

        const getTitleValue = getModalTitleEl.value;
        const getDescriptionValue = getModalDescriptionEl.value;
        const setModalStartDateValue = getModalStartDateEl.value;
        const getTimeValue = getModalTimeEl.value;
        const getModalCheckedRadioBtnValue = getModalCheckedRadioBtnEl
          ? getModalCheckedRadioBtnEl.value
          : "Primary";

        if (!getTitleValue) {
          window.showToast('warning', 'Por favor, insira um título para o evento', 'Atenção');
          return;
        }

        try {
          const formData = new FormData();
          formData.append('title', getTitleValue);
          formData.append('description', getDescriptionValue);
          formData.append('start_date', setModalStartDateValue);
          formData.append('event_time', getTimeValue || '00:00');
          formData.append('event_level', getModalCheckedRadioBtnValue);

          if (getModalPhotoEl.files[0]) {
            formData.append('photo', getModalPhotoEl.files[0]);
          }

          const response = await fetch('/api/events', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
          });

          if (!response.ok) throw new Error('Erro ao criar evento');

          // Reload calendar
          calendar.refetchEvents();
          closeModal();
          window.showToast('success', 'Evento criado com sucesso!', 'Evento Criado');
        } catch (error) {
          console.error('Erro ao criar evento:', error);
          window.showToast('error', 'Erro ao criar evento. Por favor, tente novamente.', 'Erro');
        }
      });
    }

    // Render Calendar
    calendar.render();

    // Close modal event listeners
    document.querySelectorAll(".modal-close-btn").forEach((btn) => {
      btn.addEventListener("click", closeModal);
    });

    document.querySelectorAll(".view-modal-close-btn").forEach((btn) => {
      btn.addEventListener("click", closeViewModal);
    });

    // Close when clicking outside modal
    window.addEventListener("click", (event) => {
      const modal = document.getElementById("eventModal");
      const viewModal = document.getElementById("viewEventModal");
      if (event.target === modal) {
        closeModal();
      }
      if (event.target === viewModal) {
        closeViewModal();
      }
    });
  }
}

export default calendarInit;

// Initialize calendar when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  calendarInit();
});
