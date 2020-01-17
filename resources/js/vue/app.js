import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex';
import axios from 'axios';
import helpers from "./helpers/helpers";
import auth from "./middleware/auth";
import guest from "./middleware/guest";
import log from "./middleware/log";
import VueToastr from "vue-toastr";
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueToastr, {
    defaultTimeout: 1500,
    defaultProgressBar:false
});
Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(VueSweetalert2);

///start component import
Vue.component('Dashboard', require('./views/Dashboard').default);
Vue.component('Profile', require('./views/Profile').default);
Vue.component('Companies', require('./views/Companies/Companies').default);
Vue.component('Company', require('./views/Companies/Company').default);
Vue.component('paginate', require('vuejs-paginate'));
Vue.component('VInput', require('./components/form/VInput').default);
Vue.component('VueDropify', require('./components/form/Dropify').default);
Vue.component('NavBar', require('./components/NavBar').default);
Vue.component('SideBar', require('./components/SideBar').default);
Vue.component('VFooter', require('./components/Footer').default);
Vue.component('Login', require('./views/auth/Login').default);
Vue.component('App', require('./views/App.vue').default);
/// end

Vue.prototype.$http = axios;
Vue.prototype.$helpers = helpers;

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: "active",
    routes: [
        {
            path: '/',
            name: 'home',
            component: Vue.component('Dashboard'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/login',
            name: 'login',
            component: Vue.component('Login'),
            meta: {
                middleware: guest,
            },
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Vue.component('Dashboard'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/profile',
            name: 'profile',
            component: Vue.component('Profile'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/companies',
            name: 'companies',
            component: Vue.component('Companies'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/company/add',
            name: 'company-add',
            component: Vue.component('Company'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/company/edit/:id',
            name: 'company-edit',
            props:{edit:true},
            component: Vue.component('Company'),
            meta: {
                middleware: auth,
            },
        },
    ],
});

// Creates a `nextMiddleware()` function which not only
// runs the default `next()` callback but also triggers
// the subsequent Middleware function.
router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware)
            ? to.meta.middleware
            : [to.meta.middleware];

        const context = {
            from,
            next,
            router,
            to,
        };
        const nextMiddleware = helpers.nextFactory(context, middleware, 1);

        return middleware[0]({ ...context, next: nextMiddleware });
    }

    return next();
});
const store = new Vuex.Store({
    state:{
        jwt: localStorage.getItem('jwt'),
        user:null,
        url:{
            getCompanies:'/api/companies/get',
            getCompany:'/api/companies/get/',
            addCompany:'/api/companies/sync',
            destroyCompany:'/api/companies/destroy/',
        }
    },
    getters:{
        getUser: async (state)=>{
            if(!state.user){
              return   axios.post('/api/user', {
                    token: localStorage.getItem('jwt'),
                }).then( (request)=>{
                    state.user= request.data.user;
                    return request.data.user
              } ).catch( (error)=>{
                    console.log(error);
                    localStorage.removeItem('jwt')
                } );
            }else{
                return  state.user
            }

        }
    },
});

Vue.config.devtools = true;

const app = new Vue({
    router,store,
}).$mount('#app');
