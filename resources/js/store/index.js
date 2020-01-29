import Vue from 'vue'
import Vuex from 'vuex';
import axios from "axios";
Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        jwt: localStorage.getItem('jwt'),
        user: null,
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
