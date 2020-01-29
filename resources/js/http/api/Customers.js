import Api from './Api';
import request from "../request";

class Customers extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            INDEX:'/api/customers/index',
            GET:'/api/customers/get',
            SELECTS:'/api/customers/get/selects',
            SEARCH:'/api/customers/search',
            CREATE:'/api/customers/create',
            DELETE:'/api/customers/destroy/',
        };
        return URL;
    }

    static selects(query) {
        return request({
            url: this.getUrl().SELECTS,
            method: 'get',
            params: query
        })
    }

    static create(query){
        return request({
            url: this.getUrl().CREATE,
            method:'post',
            data:query
        })
    }



}

export default Customers;
