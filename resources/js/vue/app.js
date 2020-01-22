import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex';
import axios from 'axios';
import helpers from "./helpers/helpers";
import CONST from "./helpers/const";

import auth from "./middleware/auth";
import guest from "./middleware/guest";
import log from "./middleware/log";
import VueToastr from "vue-toastr";
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueToastr, {
    defaultTimeout: 1500,
    defaultProgressBar: false
});
Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(VueSweetalert2);

///start component import
Vue.component('VTable', require('./components/table/VTable').default);
Vue.component('VTextarea', require('./components/form/VTextarea').default);
Vue.component('VCheckbox', require('./components/form/VCheckbox').default);
Vue.component('VInput', require('./components/form/VInput').default);
Vue.component('SideBarCollapse', require('./components/SideBarCollapse').default);



Vue.component('Dashboard', require('./views/Dashboard').default);
Vue.component('Profile', require('./views/Profile').default);
Vue.component('Companies', require('./views/Companies/Companies').default);
Vue.component('Company', require('./views/Companies/Company').default);
Vue.component('paginate', require('vuejs-paginate'));
Vue.component('VueDropify', require('./components/form/Dropify').default);
Vue.component('NavBar', require('./components/NavBar').default);
Vue.component('SideBar', require('./components/SideBar').default);
Vue.component('VFooter', require('./components/Footer').default);
Vue.component('Login', require('./views/auth/Login').default);
Vue.component('App', require('./views/App.vue').default);
Vue.component('Persons', require('./views/Persons/Persons').default);
Vue.component('Person', require('./views/Persons/Person').default);
Vue.component('Multiselect', require('vue-multiselect').default);
Vue.component('Customers', require('./views/Customers/Customers').default);
Vue.component('Customer', require('./views/Customers/Customer').default);
// item
Vue.component('Items', require('./views/Items/Items').default);
Vue.component('Item', require('./views/Items/Item').default);
Vue.component('ItemCategories', require('./views/Items/Categories/ItemCategories').default);
Vue.component('ItemCategory', require('./views/Items/Categories/ItemCategory').default);
// settings
Vue.component('Currencies', require('./views/Settings/Currencies/Currencies').default);
Vue.component('Currency', require('./views/Settings/Currencies/Currency').default);

/// end


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
            props: {edit: true},
            component: Vue.component('Company'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/persons',
            name: 'persons',
            component: Vue.component('Persons'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/persons/add',
            name: 'person-add',
            component: Vue.component('Person'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/persons/edit/:id',
            name: 'person-edit',
            props: {edit: true},
            component: Vue.component('Person'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/customers',
            name: 'customers',
            component: Vue.component('Customers'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/customers/persons/add',
            name: 'customers-persons-add',
            props: {type: 'PERSONS'},
            component: Vue.component('Customer'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/customers/companies/add',
            name: 'customers-companies-add',
            props: {type: 'COMPANIES'},
            component: Vue.component('Customer'),
            meta: {
                middleware: auth,
            },
        },
        // Route for items

        {
            path: '/items/index',
            name: 'item-index',
            component: Vue.component('Items'),
            meta: {
                middleware: auth,
            },
        },{
            path: '/items/create',
            name: 'item-create',
            component: Vue.component('Item'),
            meta: {
                middleware: auth,
            },
        },{
            path: '/items/edit/:id',
            name: 'item-edit',
            props: {edit: true},
            component: Vue.component('Item'),
            meta: {
                middleware: auth,
            },
        }, {
            path: '/items/categories/index',
            name: 'item-categories-index',
            component: Vue.component('ItemCategories'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/items/categories/create',
            name: 'item-categories-create',
            component: Vue.component('ItemCategory'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/items/categories/edit/:id',
            name: 'item-categories-edit',
            props: {edit: true},
            component: Vue.component('ItemCategory'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/settings/currencies',
            name: 'settings-currencies',
            component: Vue.component('Currencies'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/settings/currencies/create',
            name: 'settings-currencies-create',
            component: Vue.component('Currency'),
            meta: {
                middleware: auth,
            },
        },{
            path: '/settings/currencies/edit/:id',
            name: 'settings-currencies-edit',
            props: {edit: true},
            component: Vue.component('Currency'),
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

        return middleware[0]({...context, next: nextMiddleware});
    }

    return next();
});
const store = new Vuex.Store({
    state: {
        jwt: localStorage.getItem('jwt'),
        user: null,
        url: {  // TODO  remove to const
            getCompanies: '/api/companies/get',
            getCompaniesAll: '/api/companies/get/all',
            getCompany: '/api/companies/get/',
            syncCompany: '/api/companies/sync',
            destroyCompany: '/api/companies/destroy/',

            getPersons: '/api/persons/get',
            getPersonsAll: '/api/persons/get/all',
            getPerson: '/api/persons/get/',
            syncPerson: '/api/persons/sync',
            destroyPerson: '/api/persons/destroy/',

            getCustomers: '/api/customers/get',
            getCustomersCompanies: '/api/customers/get/companies',
            getCustomersPersons: '/api/customers/get/persons',
            getSelectsItems: '/api/customers/get/selects',
            createCustomer: '/api/customers/create',
            destroyCustomers: '/api/customers/destroy/',

        }
    },
    getters: {
        getUser: async (state) => {
            if (!state.user) {
                if (localStorage.getItem('jwt')) {
                    return axios.post('/api/user', {
                        token: localStorage.getItem('jwt'),
                    }).then((request) => {
                        state.user = request.data.user;
                        return request.data.user
                    }).catch((error) => {
                        localStorage.removeItem('jwt')
                    });
                } else return state.user;

            } else {
                return state.user
            }

        }
    },
});

Vue.config.devtools = true;


Vue.prototype.$const = CONST;
axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response) {
        if (error.response.status === 400) {
            if (error.response.data.status === 'Authorization Token not found') {
                localStorage.removeItem('jwt')
                router.push({name: 'login'})
            }
        }
    }
    // localStorage.removeItem('jwt')
    return Promise.reject(error);
});
Vue.prototype.$http = axios;

Vue.prototype.$helpers = helpers;
const app = new Vue({
    router, store, URL,
}).$mount('#app');
