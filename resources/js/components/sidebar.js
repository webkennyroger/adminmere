export function initSidebarStore() {
    window.Alpine.store('sidebar', {
        isExpanded: window.innerWidth >= 1280,
        isMobileOpen: false,
        isHovered: false,

        init() {
            // Initial check
            this.handleResize();

            // Resize listener
            window.addEventListener('resize', () => {
                this.handleResize();
            });
        },

        handleResize() {
            const width = window.innerWidth;
            if (width < 1280) {
                this.isMobileOpen = false;
                this.isExpanded = false;
            } else {
                this.isMobileOpen = false;
                this.isExpanded = true;
            }
        },

        toggleExpanded() {
            this.isExpanded = !this.isExpanded;
            this.isMobileOpen = false;
        },

        toggleMobileOpen() {
            this.isMobileOpen = !this.isMobileOpen;
        },

        setMobileOpen(val) {
            this.isMobileOpen = val;
        },

        setHovered(val) {
            if (window.innerWidth >= 1280 && !this.isExpanded) {
                this.isHovered = val;
            }
        }
    });
}
