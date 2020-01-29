import Api from './Api';
import request from "../request";

class Currencies extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            GET:'/api/settings/currencies/get',
        };
        return URL;
    }


}

export default Currencies;
