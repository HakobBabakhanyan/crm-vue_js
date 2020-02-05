import Api from './Api';
import request from "../request";

class CustomerRequest extends Api {

    constructor() {
        super();
    }

    static prefix(){ return  '/api/customers'};

    static selects(query) {
        return request({
            url: '/api/customers/get/selects',
            method: 'get',
            params: query
        })
    }




}

export default CustomerRequest;
