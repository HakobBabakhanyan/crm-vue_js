import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: '#9c27b0',
    failedColor: 'red',
    height: '3px'
});
import auth from "./middleware/auth";
import guest from "./middleware/guest";
import "../components";

import Banking from './route/Banking'
import Incomes from "./route/Incomes";
import Settings from "./route/Settings";
import Items from "./route/Items";


 const router  = new VueRouter({
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
            path: '/companies/history',
            name: 'companies-history',
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
        ...Items,
        ...Settings,
        ...Incomes,
        ...Banking,
        {
            path: '*',
            name: '404',
            props:{edit:true},
            component: Vue.component('error_404'),
            meta: {
                middleware: auth,
            },
        },
    ],
});


let vue = new Vue();
// Creates a `nextMiddleware()` function which not only
// runs the default `next()` callback but also triggers
// the subsequent Middleware function.
router.beforeEach((to, from, next) => {
    vue.$Progress.start();
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

        return middleware[0]({...context, next: nextMiddleware});
    }

    return next();
});
router.afterEach(() => {
    vue.$Progress.finish()
});

function  nextFactory(context, middleware, index) {
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
        subsequentMiddleware({...context, next: nextMiddleware});
    };
}

export default router;
