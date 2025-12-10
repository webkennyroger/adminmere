// Toast Manager
window.toastManager = function () {
    return {
        toasts: [],

        addToast(data) {
            console.log('Dados recebidos no toast:', data);

            const id = Date.now() + Math.random();
            const type = data.type || 'success';

            const defaultTitles = {
                success: 'Sucesso!',
                info: 'Informação',
                warning: 'Atenção!',
                error: 'Erro!',
                custom: 'Atenção'
            };

            const toast = {
                id,
                type: type,
                title: data.title || defaultTitles[type] || 'Notificação',
                message: data.message || '',
                show: false
            };

            console.log('Toast criado:', toast);

            this.toasts.push(toast);

            setTimeout(() => {
                const toastIndex = this.toasts.findIndex(t => t.id === id);
                if (toastIndex !== -1) {
                    this.toasts[toastIndex].show = true;
                }
            }, 100);

            setTimeout(() => {
                this.removeToast(id);
            }, data.duration || 5000);
        },

        removeToast(id) {
            const toastIndex = this.toasts.findIndex(t => t.id === id);
            if (toastIndex !== -1) {
                this.toasts[toastIndex].show = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 300);
            }
        }
    }
}

// Global toast function
window.showToast = function (type, message, title = null, duration = 5000) {
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { type, message, title, duration }
    }));
}
