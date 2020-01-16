import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex';
import helpers from "./helpers/helpers";
import App from './views/App'
import Dashboard from "./views/Dashboard";
import auth from "./middleware/auth";
import Login from "./views/auth/Login";
import guest from "./middleware/guest";
import log from "./middleware/log";
import Profile from "./views/Profile";
import axios from 'axios';
import VueToastr from "vue-toastr";
import Companies from "./views/Companies/Companies";
import Company from "./views/Companies/Company";
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueSweetalert2);

Vue.prototype.$http = axios;
const router = new VueRouter({
    mode: 'history',
    linkActiveClass: "active",
    routes: [
        {
            path: '/',
            name: 'home',
            component: Dashboard,
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                middleware: guest,
            },
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                middleware: [auth, log],
            },
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile,
            meta: {
                middleware: [auth, log],
            },
        },
        {
            path: '/companies',
            name: 'companies',
            component: Companies,
            meta: {
                middleware: [auth, log],
            },
        },
        {
            path: '/company/add',
            name: 'company-add',
            component: Company,
            meta: {
                middleware: [auth, log],
            },
        },
        {
            path: '/company/edit/:id',
            name: 'company-edit',
            props:{edit:true},
            component: Company,
            meta: {
                middleware: [auth, log],
            },
        },
    ],
});

// Creates a `nextMiddleware()` function which not only
// runs the default `next()` callback but also triggers
// the subsequent Middleware function.
function nextFactory(context, middleware, index) {
    const subsequentMiddleware = middleware[index];
    // If no subsequent Middleware exists,
    // the default `next()` callback is returned.
    if (!subsequentMiddleware) return context.next;

    return (...parameters) => {
        // Run the default Vue Router `next()` callback first.
        context.next(...parameters);
        // Than run the subsequent Middleware with a new
        // `nextMiddleware()` callback.
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({ ...context, next: nextMiddleware });
    };
}

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
        const nextMiddleware = nextFactory(context, middleware, 1);

        return middleware[0]({ ...context, next: nextMiddleware });
    }

    return next();
});


Vue.use(VueToastr, {
    defaultTimeout: 1500,
    defaultProgressBar:false

});
Vue.use(Vuex);
Vue.use(VueRouter);

Vue.prototype.$helpers = helpers;

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


Vue.component('App', require('./views/App.vue').default);

Vue.config.devtools = true;

const app = new Vue({
    router,store,
    components: {App},
}).$mount('#app');
