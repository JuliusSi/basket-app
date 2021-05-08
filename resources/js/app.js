/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import routes from './routes';
import { store } from './store/store';
import lang from './lang';
Vue.filter('trans', (...args) => {
    return lang.get(...args);
});
import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(fab, fas, far);
Vue.use(VueAxios, axios);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.use(VueRouter);
const router = new VueRouter({
    routes,
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    },
    mode: 'history'
})
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(Datetime);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('weather-check', require('./components/WeatherCheckComponent.vue').default);
Vue.component('radiation-check', require('./components/RadiationCheckComponent.vue').default);
Vue.component('chat-messages', require('./components/ChatMessages.vue').default);
Vue.component('chat-message', require('./components/ChatMessage.vue').default);
Vue.component('chat-form', require('./components/ChatForm.vue').default);
Vue.component('chat', require('./components/Chat.vue').default);
Vue.component('phone-verification', require('./components/PhoneVerification.vue').default);
Vue.component('basketball-courts', require('./components/BasketballCourtsComponent.vue').default);
Vue.component('create-arrivals', require('./components/court-arrivals/CreateArrival.vue').default);
Vue.component('datetime', Datetime);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: router,
});
