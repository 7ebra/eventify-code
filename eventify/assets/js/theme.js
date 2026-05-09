/**
 * Theme controller — light / dark with localStorage memory
 */
(function () {
    const KEY = 'eventify-theme';
    const root = document.documentElement;
    const toggle = document.getElementById('themeToggle');
    const icon = toggle?.querySelector('.theme-icon');

    const setTheme = (theme) => {
        root.setAttribute('data-theme', theme);
        localStorage.setItem(KEY, theme);
        if (icon) icon.textContent = theme === 'dark' ? '☀️' : '🌙';
    };

    // Initialize from storage
    const stored = localStorage.getItem(KEY) || 'light';
    setTheme(stored);

    if (toggle) {
        toggle.addEventListener('click', () => {
            const current = root.getAttribute('data-theme');
            setTheme(current === 'dark' ? 'light' : 'dark');
        });
    }
})();