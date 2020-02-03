import Api from './Api';
import request from "../request";

class IncomesCategories extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            INDEX: '/api/incomes/categories/index',
            SYNC: '/api/incomes/categories/sync',
            GET:'/api/incomes/categories/get',
        };
        return URL;
    }



}

export default IncomesCategories;
