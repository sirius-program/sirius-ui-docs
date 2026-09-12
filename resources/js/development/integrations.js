// Development fixtures: libraries load only when a proof widget is mounted.
function integrationWidget(kind, initialValue) {
    let instance;
    let disposed = false;
    let update;
    let cleanup;

    return {
        value: initialValue,
        async init() {
            const control = this.$refs.control;
            const changed = (value) => { this.value = value; };

            if (kind === 'date') {
                const [{ default: flatpickr }] = await Promise.all([
                    import('flatpickr'), import('flatpickr/dist/flatpickr.css'),
                ]);
                if (disposed) return;
                instance = flatpickr(control, {
                    dateFormat: 'Y-m-d', defaultDate: this.value, disableMobile: true,
                    onChange: (_dates, value) => changed(value),
                });
                update = (value) => instance.setDate(value, false);
                cleanup = () => instance.destroy();
            } else if (kind === 'select') {
                const [{ default: TomSelect }] = await Promise.all([
                    import('tom-select'), import('tom-select/dist/css/tom-select.css'),
                ]);
                if (disposed) return;
                instance = new TomSelect(control, { onChange: changed });
                update = (value) => instance.setValue(value, true);
                cleanup = () => instance.destroy();
            } else {
                const [{ Editor }, { default: StarterKit }] = await Promise.all([
                    import('@tiptap/core'), import('@tiptap/starter-kit'),
                ]);
                if (disposed) return;
                instance = new Editor({
                    element: control, extensions: [StarterKit], content: this.value,
                    editorProps: { attributes: { 'aria-label': 'Rich text', role: 'textbox' } },
                    onUpdate: ({ editor }) => changed(editor.getHTML()),
                });
                update = (value) => {
                    if (instance.getHTML() !== value) {
                        instance.commands.setContent(value, { emitUpdate: false });
                    }
                };
                cleanup = () => instance.destroy();
            }

            update(this.value);
            this.$watch('value', (value) => { if (!disposed) update(value); });
            this.$el.dataset.ready = 'true';
        },
        destroy() {
            disposed = true;
            cleanup?.();
        },
    };
}

function integrationUpload(wire = null) {
    let pond;
    let disposed = false;
    let unwatch;

    return {
        async init() {
            const [FilePond] = await Promise.all([
                import('filepond'), import('filepond/dist/filepond.css'),
            ]);
            if (disposed) return;
            pond = FilePond.create(this.$refs.control, {
                credits: false, allowMultiple: false, storeAsFile: !wire,
                server: wire ? {
                    process: (_name, file, _metadata, load, error, progress, abort) => {
                        wire.upload('upload', file, load, error,
                            (event) => progress(true, event.detail.progress, 100), abort);
                        return { abort: () => wire.cancelUpload('upload') };
                    },
                    revert: (id, load) => wire.removeUpload('upload', id, load),
                } : null,
            });
            if (wire) {
                unwatch = wire.$watch('upload', (value) => {
                    if (!value && !disposed) pond.removeFiles({ revert: false });
                });
            }
            this.$el.dataset.ready = 'true';
        },
        destroy() {
            disposed = true;
            if (wire && pond?.getFiles().some((file) => file.status === 3)) {
                wire.cancelUpload('upload');
            }
            unwatch?.();
            pond?.destroy();
        },
    };
}

const register = () => {
    window.Alpine.data('integrationWidget', integrationWidget);
    window.Alpine.data('integrationUpload', integrationUpload);
};

if (window.Alpine) register();
else document.addEventListener('alpine:init', register, { once: true });
