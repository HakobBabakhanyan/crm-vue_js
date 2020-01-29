import Vue from 'vue';
import helpers from "./helpers/helpers";
import CONST from "./helpers/const";
import router from './routes/web'
import store from "./store";
import axios from './http/index'

Vue.config.devtools = true;
Vue.prototype.$const = CONST;
Vue.prototype.$helpers = helpers;
Vue.prototype.$http = axios;

const app = new Vue({router, store}).$mount('#app');
