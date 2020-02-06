import Api from './Api';
import request from "../request";

class InvoiceRequest extends Api {


   // static getUrl(){
   //     return {
   //          NUMBER: '/api/incomes/invoices/number'
   //      };
   //  }
    static prefix(){ return  '/api/invoices'};

    static getNumber(query){
        return request({
            url:this.prefix() + '/number',
            method:'get',
            params:query
        })
    }




}

export default InvoiceRequest;
