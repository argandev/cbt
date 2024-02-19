import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

import PrimeVue from "primevue/config";
import lara from './preset/lara'
import 'primeicons/primeicons.css'
import ToastService from 'primevue/toastservice'
const app = createApp(App)
import VueCountdown from '@chenfengyuan/vue-countdown';
import Tooltip from 'primevue/tooltip';
app.directive('tooltip', Tooltip);
app.use(PrimeVue,{
    unstyled: true,
    pt : lara,
});
app.component(VueCountdown.name, VueCountdown);
app.use(ToastService)
app.use(createPinia())
app.use(router)


app.mount('#app')
