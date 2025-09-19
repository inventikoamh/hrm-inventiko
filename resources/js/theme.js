// Theme management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Listen for theme changes from Livewire
    window.addEventListener('theme-changed', function(event) {
        const theme = event.detail;
        updateTheme(theme);
    });
    
    // Function to update theme
    function updateTheme(userTheme) {
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (userTheme === 'dark' || (userTheme === 'system' && systemPrefersDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        // Only update if user has set theme to 'system'
        const currentTheme = document.querySelector('[x-data]')?.__x?.$data?.theme || 'system';
        if (currentTheme === 'system') {
            if (e.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    });
});
