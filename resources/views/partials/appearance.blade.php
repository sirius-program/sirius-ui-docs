<script data-navigate-once>
    (() => {
        if (window.SiriusDocsAppearance) return;
        const key = 'sirius-docs.appearance';
        const system = window.matchMedia('(prefers-color-scheme: dark)');
        let preference = 'system';
        try {
            // Preserve the previous starter kit preference while removing its runtime.
            preference = localStorage.getItem(key) ?? localStorage.getItem('flux.appearance') ?? 'system';
        } catch {}
        if (!['light', 'dark', 'system'].includes(preference)) preference = 'system';
        const apply = () => {
            const dark = preference === 'dark' || (preference === 'system' && system.matches);
            document.documentElement.classList.toggle('dark', dark);
            document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
            document.documentElement.dataset.appearance = preference;
            document.querySelectorAll('[data-docs-appearance]').forEach(input => { input.checked = input.value === preference; });
        };
        window.SiriusDocsAppearance = {
            apply,
            set(value) {
                if (!['light', 'dark', 'system'].includes(value)) return;
                preference = value;
                try { localStorage.setItem(key, value); } catch {}
                apply();
            },
        };
        system.addEventListener('change', () => { if (preference === 'system') apply(); });
        window.addEventListener('storage', event => {
            if (event.key === key) window.SiriusDocsAppearance.set(event.newValue ?? 'system');
        });
        apply();
    })();
</script>
