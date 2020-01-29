import axios from 'axios';
// import router from "../routes/web";

// axios.interceptors.request.use(function (config) {
//     if(localStorage.getItem('jwt')){
//         config.headers.Authorization = `Bearer ${localStorage.getItem('jwt')}`;
//     }
//     console.log(1)
//     return config;
// },function (error) {
//     return Promise.reject(error);
// });
// axios.interceptors.response.use(function (response) {
//     return response;
// }, function (error) {
//     if (error.response) {
//         if (error.response.status === 400) {
//             if (error.response.data.status === 'Authorization Token not found') {
//                 localStorage.removeItem('jwt');
//                 router.push({name: 'login'})
//             }
//         }
//     }
//     return Promise.reject(error);
// });

export default axios;

