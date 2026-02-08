export function initSidebarStore() {
    window.Alpine.store('sidebar', {
        isExpanded: window.innerWidth >= 1280,
        isMobileOpen: false,
        isHovered: false,

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

    // Resize listener
    const checkMobile = () => {
        const sidebar = window.Alpine.store('sidebar');
        if (!sidebar) return;

        if (window.innerWidth < 1280) {
            sidebar.setMobileOpen(false);
            sidebar.isExpanded = false;
        } else {
            sidebar.isMobileOpen = false;
            sidebar.isExpanded = true;
        }
    };
    
    // Initial check (optional, as store init handles most)
    // checkMobile(); 

    window.addEventListener('resize', checkMobile);
}
