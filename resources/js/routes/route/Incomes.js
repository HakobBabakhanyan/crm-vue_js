import Vue from "vue";
import auth from "../middleware/auth";

const Incomes = [
    {
        path: '/incomes/invoices',
        name: 'incomes-invoices-index',
        component: Vue.component('IncomesInvoices'),
        meta: {
            middleware: auth,
        },
    },
    {
        path: '/incomes/invoices/:id/show',
        name: 'incomes-invoices-show',
        component: Vue.component('IncomesInvoiceShow'),
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
        path: '/incomes/categories/update/:id',
        name: 'incomes-categories-edit',
        props:{edit:true},
        component: Vue.component('IncomesCategory'),
        meta: {
            middleware: auth,
        },
    },
];


export  default Incomes;
