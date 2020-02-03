import Api from './Api';
import request from "../request";

class Currencies extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            INDEX:'/api/settings/currencies/index',
            GET:'/api/settings/currencies/get',
            SYNC:'/api/settings/currencies/sync',
            DELETE:'/api/settings/currencies/destroy',
        };
        return URL;
    }


}

export default Currencies;
