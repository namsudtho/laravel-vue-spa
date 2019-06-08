require('./bootstrap');

import 'es6-promise/auto';
import axios from 'axios';
import Vue from 'vue';
import VueAuth from '@websanova/vue-auth';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import Buefy from 'buefy';
import VeeValidate from 'vee-validate';

import Index from './Index';
import auth from './auth';
import router from './router';

// internal icons
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
    faUserCircle,
    faFingerprint,
    faCheck,
    faCheckCircle,
    faInfoCircle,
    faExclamationTriangle,
    faExclamationCircle,
    faArrowUp,
    faAngleRight,
    faAngleLeft,
    faAngleDown,
    faEye,
    faEyeSlash,
    faCaretDown,
    faCaretUp,
    faUpload
} from '@fortawesome/free-solid-svg-icons';
library.add(
    faUserCircle,
    faFingerprint,
    faCheck,
    faCheckCircle,
    faInfoCircle,
    faExclamationTriangle,
    faExclamationCircle,
    faArrowUp,
    faAngleRight,
    faAngleLeft,
    faAngleDown,
    faEye,
    faEyeSlash,
    faCaretDown,
    faCaretUp,
    faUpload
);
Vue.component('vue-fontawesome', FontAwesomeIcon);

// Set Vue globally
window.Vue = Vue;
Vue.use(Buefy, {
    defaultIconComponent: 'vue-fontawesome',
    defaultIconPack: 'fas'
});
Vue.use(VeeValidate);
Vue.use(VueAxios, axios);

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);

// Set Vue authentication
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api/v1`;
Vue.use(VueAuth, auth);

// Load Index
Vue.component('index', Index);
const app = new Vue({
    el: '#app',
    router
});
