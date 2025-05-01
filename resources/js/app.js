require('./bootstrap');
require('../css/multiselect.css');

import { createApp, h } from 'vue';
import PrimeVue from 'primevue/config';
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Preloader from './Components/Preloader.vue';
import Tooltip from 'primevue/tooltip'
import Aura from '@primeuix/themes/aura';
import Chart from 'primevue/chart'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import SelectButton from 'primevue/selectbutton'
import AnimateOnScroll from 'primevue/animateonscroll';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const vueApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .component('InertiaLink', Link)
            .component('Chart', Chart)
            .component('DataTable', DataTable)
            .component('Column', Column)
            .component('SelectButton', SelectButton)
            .directive('animateonscroll', AnimateOnScroll)
            .use(PrimeVue, {
                theme: {
                    preset: Aura
                }
            })
            .directive('tooltip', Tooltip)
            .mixin({ methods: { route } });

        vueApp.mount(el);

        const preloaderEl = document.createElement('div');
        document.body.appendChild(preloaderEl);
        createApp(Preloader).mount(preloaderEl);
    },
});

InertiaProgress.init({
    color: '#4B5563',
    showSpinner: false
});
