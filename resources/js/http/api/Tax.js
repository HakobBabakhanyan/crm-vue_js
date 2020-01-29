import Api from './Api';

class Items extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            INDEX:'/api/settings/taxes/index',
            GET:'/api/settings/taxes/get',
            SYNC:'/api/settings/taxes/sync',
            SEARCH:'/api/settings/taxes/search',
            DELETE:'/api/settings/taxes/destroy',
        };
        return URL;
    }


}

export default Items;
