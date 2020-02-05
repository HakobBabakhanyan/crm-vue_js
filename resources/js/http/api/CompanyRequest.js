import Api from './Api';

class CompanyRequest extends Api {

    constructor() {
        super();
    }

    static prefix(){ return  '/api/companies'};



}

export default CompanyRequest;
