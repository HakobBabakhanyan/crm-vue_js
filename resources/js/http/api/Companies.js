import Api from './Api';
class Companies extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            INDEX:'/api/companies/index',
            GET:'/api/companies/get',
            SYNC:'/api/companies/sync',
            DELETE:'/api/companies/destroy',
        };
        return URL;
    }


}

export default Companies;
