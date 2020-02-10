import Vue from "vue";
import auth from "../middleware/auth";

const Items = [
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
];


export  default Items;
