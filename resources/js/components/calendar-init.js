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

    // Calendar Event Click function
    const calendarEventClick = (info) => {
      const eventObj = info.event;
      
      // Populate view modal
      if (document.getElementById('view-event-title')) {
          document.getElementById('view-event-title').textContent = eventObj.title;
      }
      if (document.getElementById('view-event-date')) {
           document.getElementById('view-event-date').textContent = eventObj.startStr;
      }

      const typeMap = {
          'Danger': 'Urgente',
          'Success': 'Sucesso',
          'Primary': 'Normal',
          'Warning': 'Aviso'
      };
      if (document.getElementById('view-event-type')) {
          document.getElementById('view-event-type').textContent = typeMap[eventObj.extendedProps.calendar] || 'Normal';
      }

      // Description
      const descContainer = document.getElementById('view-event-description-container');
      const descEl = document.getElementById('view-event-description');
      if (descContainer && descEl) {
          if (eventObj.extendedProps.description) {
              descEl.innerHTML = eventObj.extendedProps.description;
              descContainer.classList.remove('hidden');
          } else {
              descContainer.classList.add('hidden');
          }
      }

      // Time
      const timeContainer = document.getElementById('view-event-time-container');
      const timeEl = document.getElementById('view-event-time');
      if (timeContainer && timeEl) {
          if (eventObj.extendedProps.time && eventObj.extendedProps.time !== '00:00') {
              let timeStr = eventObj.extendedProps.time;
              if (timeStr.includes('T')) {
                  timeStr = timeStr.split('T')[1].substring(0, 5);
              }
              timeEl.textContent = timeStr;
              timeContainer.classList.remove('hidden');
          } else {
              timeContainer.classList.add('hidden');
          }
      }

      // Photo
      const photoContainer = document.getElementById('view-event-photo-container');
      const photoEl = document.getElementById('view-event-photo');
      if (photoContainer && photoEl) {
          if (eventObj.extendedProps.photo) {
              photoEl.src = `/storage/${eventObj.extendedProps.photo}`;
              photoContainer.classList.remove('hidden');
          } else {
              photoContainer.classList.add('hidden');
          }
      }

      // Store event ID for edit button
      const editBtn = document.querySelector('.btn-edit-from-view');
      if (editBtn) {
          editBtn.dataset.eventId = eventObj.id;
          editBtn.dataset.eventData = JSON.stringify({
              id: eventObj.id,
              title: eventObj.title,
              startStr: eventObj.startStr,
              extendedProps: eventObj.extendedProps
          });
      }
      
      // Store event ID for delete button in view modal
      const deleteBtn = document.querySelector('.btn-delete-event-view');
      if(deleteBtn) {
          deleteBtn.dataset.eventId = eventObj.id;
           deleteBtn.onclick = function () {
                // Show confirmation modal
                showDeleteConfirmation(async () => {
                  try {
                    const response = await fetch(`/api/events/${eventObj.id}`, {
                      method: "DELETE",
                      headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                      },
                    });

                    if (!response.ok) throw new Error("Erro ao excluir evento");

                    calendar.refetchEvents();
                    closeViewModal();
                    window.showToast("error", "O evento foi removido do sistema!", "Evento Excluído");
                  } catch (error) {
                    console.error("Erro ao excluir evento:", error);
                    window.showToast("error", "Erro ao excluir evento. Por favor, tente novamente.", "Erro");
                  }
                });
            };
      }

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
            <div class="event-fc-color flex items-center fc-event-main ${colorClass} p-1.5 rounded-md cursor-pointer hover:opacity-90 transition-opacity w-full overflow-hidden">
                <div class="fc-daygrid-event-dot !border-0 !m-0 !mr-2"></div>
                <div class="fc-event-title truncate font-medium text-xs text-white" style="color: #ffffff !important;">${eventInfo.event.title}</div>
            </div>
          `,
        };
      },
    });

    // Removed handleCalendarClicks listener as logic is now in eventClick or direct button listeners
    // document.addEventListener("click", handleCalendarClicks);

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
