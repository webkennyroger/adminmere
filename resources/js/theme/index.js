export function initThemeStore() {
    window.Alpine.store('theme', {
        theme: localStorage.getItem('theme') || 'system',

        init() {
            this.updateTheme();
            
            // Watch for system theme changes if in system mode
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (this.theme === 'system') {
                    this.updateTheme();
                }
            });
        },

        toggle() {
            if (this.theme === 'dark') this.setTheme('light');
            else this.setTheme('dark');
        },

        setTheme(theme) {
            this.theme = theme;
            localStorage.setItem('theme', theme);
            this.updateTheme();
        },

        updateTheme() {
            let targetTheme = this.theme;
            
            if (targetTheme === 'system') {
                targetTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            const isDark = targetTheme === 'dark';
            document.documentElement.classList.toggle('dark', isDark);
            
            // Debug log
            console.log('Mere Theme updated:', targetTheme, 'isDark:', isDark);
        }
    });
}
