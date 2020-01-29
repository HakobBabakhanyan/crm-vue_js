import Api from './Api';
import request from "../request";

class IncomesCategories extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            GET:'/api/incomes/categories/get'
        };
        return URL;
    }



}

export default IncomesCategories;
