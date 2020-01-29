import Api from './Api';

class Items extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            INDEX:'/api/items/index',
            GET:'/api/items/get',
            SEARCH:'/api/items/search',
            SYNC:'/api/items/sync',
            DELETE:'/api/items/destroy',
        };
        return URL;
    }


}

export default Items;
