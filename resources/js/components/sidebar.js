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

    // Track last width to only trigger on breakpoint crossing
    let lastWidth = window.innerWidth;

    const checkMobile = () => {
        const currentWidth = window.innerWidth;
        const sidebar = window.Alpine.store('sidebar');
        if (!sidebar) return;

        // Only act if we cross the breakpoint
        if (lastWidth >= 1280 && currentWidth < 1280) {
            // Transitioning TO mobile
            sidebar.setMobileOpen(false);
            sidebar.isExpanded = false;
        } else if (lastWidth < 1280 && currentWidth >= 1280) {
            // Transitioning TO desktop
            sidebar.isMobileOpen = false;
            sidebar.isExpanded = true;
        }
        
        lastWidth = currentWidth;
    };
    
    // Initial state setup based on current width
    const sidebar = window.Alpine.store('sidebar');
    if (window.innerWidth < 1280) {
        sidebar.isExpanded = false;
        sidebar.isMobileOpen = false;
    } else {
        sidebar.isExpanded = true;
        sidebar.isMobileOpen = false;
    }

    window.addEventListener('resize', checkMobile);
}
