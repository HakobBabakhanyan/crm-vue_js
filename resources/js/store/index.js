import Vue from 'vue'
import Vuex from 'vuex';
import axios from "axios";
Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        jwt: localStorage.getItem('jwt'),
        user: null,
        url: {
            getCustomers: '/api/customers/get',
            getCustomersCompanies: '/api/customers/get/companies',
            getCustomersPersons: '/api/customers/get/persons', // TODO remove const created
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


export default store;
