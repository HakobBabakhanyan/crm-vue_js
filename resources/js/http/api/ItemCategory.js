import Api from './Api';

class ItemCategory extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            INDEX:'/api/items/categories/index',
            GET:'/api/items/categories/get/',
            SEARCH:'/api/items/categories/search',
            SYNC:'/api/items/categories/sync',
            DELETE:'/api/items/categories/destroy/',
        };
        return URL;
    }


}

export default ItemCategory;
