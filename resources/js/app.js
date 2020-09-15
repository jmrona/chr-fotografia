require('./bootstrap');
window.Vue = require('vue');

// Vuetify
import '@fortawesome/fontawesome-free/css/all.css';
import Vuetify from 'vuetify';
Vue.use(Vuetify);

// Vue-Router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import routes from './routes';
const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'is-active',
    routes
})

// Vuex
import Vuex from 'vuex'
Vue.use(Vuex);

//SweetAlert2
import Swal from 'vue-sweetalert2';
Vue.use(Swal);

//Toast
import Toast from 'vue-toast-notification';
Vue.use(Toast);

import App from './App.vue';

Vue.component('spinner', require('vue-simple-spinner'));

const app = new Vue({
    render: h => h(App),
    vuetify: new Vuetify({
        icons: {
            iconfont: 'fa',
        }
    }),
    router
}).$mount('#app');
