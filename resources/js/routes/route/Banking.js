import Vue from "vue";
import auth from "../middleware/auth";

const Banking = [
    {
        path: '/banking/accounts',
        name: 'banking-accounts',
        component: Vue.component('BankingAccounts'),
        meta: {
            middleware: auth,
        },
    },
    {
        path: '/banking/account/create',
        name: 'banking-accounts-crete',
        component: Vue.component('BankingAccount'),
        meta: {
            middleware: auth,
        },
    },
    {
        path: '/banking/account/update/:id',
        name: 'banking-accounts-edit',
        props:{edit:true},
        component: Vue.component('BankingAccount'),
        meta: {
            middleware: auth,
        },
    },

];


export  default Banking;
