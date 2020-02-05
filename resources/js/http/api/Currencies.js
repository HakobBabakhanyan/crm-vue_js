import Api from './Api';

class Currencies extends Api {

    constructor() {
        super();
    }

   static getUrl(){
       return {
            INDEX: '/api/settings/currencies/index',
            GET: '/api/settings/currencies/get',
            SEARCH: '/api/settings/currencies/search',
            SYNC: '/api/settings/currencies/sync',
            DELETE: '/api/settings/currencies/destroy',
        };
    }


}

export default Currencies;
