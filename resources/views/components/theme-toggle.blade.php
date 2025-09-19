<button onclick="toggleTheme()" 
        class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors duration-200
               {{ $currentMode === 'light' 
                   ? 'bg-gray-100 hover:bg-gray-200 text-gray-700' 
                   : 'bg-gray-700 hover:bg-gray-600 text-gray-200' }}">
    @if($currentMode === 'light')
        <!-- Sun icon for light mode -->
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    @else
        <!-- Moon icon for dark mode -->
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
    @endif
    <span class="text-sm font-medium">{{ $oppositeLabel }} Mode</span>
</button>

<script>
function toggleTheme() {
    const currentMode = '{{ $currentMode }}';
    const newMode = currentMode === 'light' ? 'dark' : 'light';
    
    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<div class="flex items-center space-x-2"><div class="animate-spin rounded-full h-4 w-4 border-b-2 border-current"></div><span class="text-sm font-medium">Switching...</span></div>';
    button.disabled = true;
    
    // Make API call to update theme
    fetch('/api/theme/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ mode: newMode })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload page to apply new theme
            window.location.reload();
        } else {
            // Restore button on error
            button.innerHTML = originalContent;
            button.disabled = false;
            alert('Failed to switch theme. Please try again.');
        }
    })
    .catch(error => {
        // Restore button on error
        button.innerHTML = originalContent;
        button.disabled = false;
        alert('Failed to switch theme. Please try again.');
    });
}
</script>