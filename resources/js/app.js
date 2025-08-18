import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('alpine:initialized', () => {
    Alpine.data('formTracker', () => ({
        formChanged: false,
        init() {
            const form = this.$el.closest('form');
            const initialData = new FormData(form);

            form.addEventListener('change', () => {
                const currentData = new FormData(form);
                this.formChanged = ![...initialData].every(
                    ([key, value]) => currentData.get(key) === value
                );
            });
        }
    }));
});