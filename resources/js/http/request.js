import axios from 'axios';
import router from "../routes/web";
import helpers from "../helpers/helpers";
import VueToastr from "vue-toastr";
import Vue from 'vue'
Vue.use(VueToastr);

const service = axios.create({
    baseURL: process.env.VUE_APP_BASE_API, // url = base url + request url
    // withCredentials: true, // send cookies when cross-domain requests
    timeout: 5000 // request timeout
});

// request interceptor
service.interceptors.request.use(
    config => {
        // do something before request is sent
        if (localStorage.getItem('jwt')) {
            // let each request carry token
            // ['X-Token'] is a custom headers key
            // please modify it according to the actual situation
            config.headers['Authorization'] = `Bearer ${localStorage.getItem('jwt')}`;
        }
        return config
    },
    error => {
        console.log(error); // for debug
        return Promise.reject(error)
    }
);

// response interceptor
service.interceptors.response.use(
    /**
     * If you want to get http information such as headers or status
     * Please return  response => response
     */

    /**
     * Determine the request status by custom code
     * Here is just an example
     * You can also judge the status by HTTP Status Code
     */
    response => {
        const res = response.data;

        if (res.code) {
            console.log('test ' + res.code)
        }
        return res

    },
    error => {
        let vue = new Vue();
        switch (error.request.status) {
            case 400:
                if (error.response.data.status === 'Authorization Token not found') {
                    vue.$toastr.e('Authorization Token not found');
                    helpers.log_out();
                    router.push({name: 'login'})
                }
                break;
            case 401:
                vue = new Vue();
                vue.$toastr.e(error.response.data.error);
                break;
            case 404:
                console.log(404);
                // router.push({name: '404'});
                break;
            case 422:
                vue = new Vue();
                Object.keys(error.response.data.errors).forEach(function (item) {
                    vue.$toaster.e(error.response.data.errors[item]);
                });
                break;
            default:
                vue.$toastr.e('undefined error');
                console.log('err - ' + error);
        }
        return Promise.reject(error)
    }
);


export default service;

