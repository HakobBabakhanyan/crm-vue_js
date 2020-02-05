import Api from './Api';
import request from "../request";

class Invoices extends Api {

    constructor() {
        super();
    }

   static getUrl(){
       return {
            NUMBER: '/api/incomes/invoices/number'
        };
    }

    static getNumber(query){
        return request({
            url:this.getUrl().NUMBER,
            method:'get',
            params:query
        })
    }




}

export default Invoices;
