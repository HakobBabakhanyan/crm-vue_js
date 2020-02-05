import Api from './Api';

class IncomesCategories extends Api {

    constructor() {
        super();
    }

   static getUrl(){
       return {
            INDEX: '/api/incomes/categories/index',
            SYNC: '/api/incomes/categories/sync',
            GET: '/api/incomes/categories/get',
        };
    }



}

export default IncomesCategories;
