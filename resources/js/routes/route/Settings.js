import Vue from "vue";
import auth from "../middleware/auth";

const Settings = [
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
];


export  default Settings;
