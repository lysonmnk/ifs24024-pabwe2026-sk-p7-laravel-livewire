// Application JS Entrypoint with Lazy React Island Mount
function initReactIslands() {
    if (document.getElementById('grid-motion-root')) {
        import('./components/GridMotion/mountGridMotion.jsx')
            .then(({ mountGridMotion }) => {
                mountGridMotion();
            })
            .catch((err) => {
                console.error('Failed to load GridMotion background:', err);
            });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReactIslands);
} else {
    initReactIslands();
}

// Support Livewire SPA navigation if used
document.addEventListener('livewire:navigated', initReactIslands);
