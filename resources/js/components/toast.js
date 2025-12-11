// Toast Manager
window.toastManager = function () {
    return {
        toasts: [],

        addToast(data) {
            console.log('Dados originais recebidos:', data);

            // Handle Livewire event detail structure (sometimes comes as array)
            if (Array.isArray(data) && data.length > 0) {
                data = data[0];
            }

            // If data is still just a string (sometimes happens with simple messages), handle it
            if (typeof data === 'string') {
                data = { message: data, type: 'info' };
            }

            console.log('Dados processados:', data);

            const id = Date.now() + Math.random();
            const type = data.type || 'success';

            const defaultTitles = {
                success: 'Sucesso!',
                info: 'Informação',
                warning: 'Atenção!',
                error: 'Erro!',
                custom: 'Atenção'
            };

            const bgClasses = {
                success: 'bg-green-500',
                info: 'bg-blue-500',
                warning: 'bg-yellow-500',
                error: 'bg-red-500',
                custom: 'bg-orange-500'
            };

            const textClasses = {
                success: 'text-green-500',
                info: 'text-blue-500',
                warning: 'text-yellow-500',
                error: 'text-red-500',
                custom: 'text-orange-500'
            };

            // Map types to consistent internal types
            let normalizedType = type;
            if (!bgClasses[normalizedType]) normalizedType = 'success';

            const toast = {
                id,
                type: normalizedType,
                title: data.title || defaultTitles[normalizedType] || 'Notificação',
                message: data.message || '',
                bgClass: bgClasses[normalizedType],
                textClass: textClasses[normalizedType],
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
