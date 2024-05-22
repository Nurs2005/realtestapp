import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import ElementPlus from 'element-plus';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import 'element-plus/dist/index.css';

// Импорт всех компонентов страниц
const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(ElementPlus)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
