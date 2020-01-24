import Api from './Api';

class Persons extends Api {

    constructor() {
        super();
    }

   static getUrl(){
        const  URL = {
            INDEX:'/api/persons/index',
            GET:'/api/persons/get',
            SYNC:'/api/persons/sync',
            DELETE:'/api/persons/destroy/',
        };
        return URL;
    }


}

export default Persons;
