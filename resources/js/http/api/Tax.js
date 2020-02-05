import Api from './Api';

class Items extends Api {

    constructor() {
        super();
    }

   static getUrl(){
       return {
            INDEX: '/api/settings/taxes/index',
            GET: '/api/settings/taxes/get',
            SYNC: '/api/settings/taxes/sync',
            SEARCH: '/api/settings/taxes/search',
            DELETE: '/api/settings/taxes/destroy',
        };
    }


}

export default Items;
