require('./bootstrap');
import { createApp } from 'vue';
import * as VueRouter from 'vue-router';

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    },
});

const app = createApp({}).use(router);

import axios from 'axios';
import VueAxios from 'vue-axios';
import routes from './routes';
import { store } from './store/store';
import Datepicker from 'vue3-date-time-picker';
import 'vue3-date-time-picker/dist/main.css';
import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(fab, fas, far);
app.use(VueAxios, axios);
app.component('font-awesome-icon', FontAwesomeIcon);
import Vue3Langjs from 'vue3-langjs';
import lang from './lang';
app.use(Vue3Langjs, lang);

app.component('example-component', require('./components/ExampleComponent.vue').default);
app.component('weather-check', require('./components/WeatherCheckComponent.vue').default);
app.component('radiation-check', require('./components/RadiationCheckComponent.vue').default);
app.component('chat-messages', require('./components/ChatMessages.vue').default);
app.component('chat-message', require('./components/ChatMessage.vue').default);
app.component('chat-form', require('./components/ChatForm.vue').default);
app.component('chat', require('./components/Chat.vue').default);
app.component('phone-verification', require('./components/PhoneVerification.vue').default);
app.component('basketball-courts', require('./components/BasketballCourtsComponent.vue').default);
app.component('create-arrivals', require('./components/court-arrivals/CreateArrival.vue').default);
app.component('datetime', Datepicker);
app.component('weather-notification-settings', require('./components/user/settings/WeatherNotificationSmsSettings.vue').default);
app.component('user-main-settings', require('./components/user/settings/UserMainSettings.vue').default);

// admin
app.component('admin-sidebar', require('./components/admin/Sidebar.vue').default);

app.mount('#app');
