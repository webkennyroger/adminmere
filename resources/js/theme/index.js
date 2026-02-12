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
            if (this.theme === 'light') this.setTheme('dark');
            else if (this.theme === 'dark') this.setTheme('system');
            else this.setTheme('light');
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

            const html = document.documentElement;
            if (targetTheme === 'dark') {
                html.classList.add('dark');
                if (document.body) document.body.classList.add('dark', 'bg-zinc-900');
            } else {
                html.classList.remove('dark');
                if (document.body) document.body.classList.remove('dark', 'bg-zinc-900');
            }
        }
    });
}
