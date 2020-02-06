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
        // Route for items
        {
            path: '/items/index',
            name: 'item-index',
            component: Vue.component('Items'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/items/create',
            name: 'item-create',
            component: Vue.component('Item'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/items/edit/:id',
            name: 'item-edit',
            props: {edit: true},
            component: Vue.component('Item'),
            meta: {
                middleware: auth,
            },
        },
        {
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
        },
        {
            path: '/settings/currencies/edit/:id',
            name: 'settings-currencies-edit',
            props: {edit: true},
            component: Vue.component('Currency'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/settings/taxes',
            name: 'settings-taxes',
            props: {edit: true},
            component: Vue.component('Taxes'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/settings/taxes/create',
            name: 'settings-taxes-create',
            component: Vue.component('Tax'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/settings/taxes/edit/:id',
            name: 'settings-taxes-edit',
            props: {edit: true},
            component: Vue.component('Tax'),
            meta: {
                middleware: auth,
            },
        },

        //  ROUTE INCOMES  //

        {
            path: '/incomes/invoices',
            name: 'incomes-invoices-index',
            component: Vue.component('IncomesInvoices'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/incomes/invoices/create',
            name: 'incomes-invoices-create',
            component: Vue.component('IncomesInvoice'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/incomes/invoices/update/:id',
            name: 'incomes-invoices-edit',
            props: {edit: true},
            component: Vue.component('IncomesInvoice'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/incomes/categories',
            name: 'incomes-categories-index',
            component: Vue.component('IncomesCategories'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/incomes/categories/create',
            name: 'incomes-categories-create',
            component: Vue.component('IncomesCategory'),
            meta: {
                middleware: auth,
            },
        },
        {
            path: '/incomes/categories/edit/:id',
            name: 'incomes-categories-edit',
            props:{edit:true},
            component: Vue.component('IncomesCategory'),
            meta: {
                middleware: auth,
            },
        },
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
