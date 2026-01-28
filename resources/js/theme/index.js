export function initThemeStore() {
    Alpine.store('theme', {
        init() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            this.theme = savedTheme || systemTheme;
            this.updateTheme();
        },
        theme: 'light',
        toggle() {
            this.theme = this.theme === 'light' ? 'dark' : 'light';
            localStorage.setItem('theme', this.theme);
            this.updateTheme();
        },
        updateTheme() {
            const html = document.documentElement;
            if (this.theme === 'dark') {
                html.classList.add('dark');
                if (document.body) document.body.classList.add('dark', 'bg-zinc-900');
            } else {
                html.classList.remove('dark');
                if (document.body) document.body.classList.remove('dark', 'bg-zinc-900');
            }
        }
    });
}
