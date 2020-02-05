import Api from './Api';

class PersonRequest extends Api {

    constructor() {
        super();
    }

    static prefix(){ return  '/api/persons'};



}

export default PersonRequest;
