export function initChatStore() {
    window.Alpine.store('chatSidebar', {
        isOpen: false,
        toggle() {
            this.isOpen = !this.isOpen;
        },
        close() {
            this.isOpen = false;
        },
        open() {
            this.isOpen = true;
        }
    });
}
