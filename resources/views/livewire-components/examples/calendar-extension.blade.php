<x-docs-code language="JavaScript" source="const unregister = window.SiriusCalendar.register('options-calendar', () => ({
    eventContent(info) {
        const text = document.createElement('span');
        text.textContent = info.event.title;
        return { domNodes: [text] };
    },
}));" />