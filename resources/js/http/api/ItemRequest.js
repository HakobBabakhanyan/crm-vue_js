import Api from './Api';
import request from "../request";

class  ItemRequest extends Api {

    static prefix(){ return  '/api/items'};

    static search(query) {
        return request({
            url: '/api/items/search',
            method: 'get',
            params: query
        })
    }


}

export default ItemRequest;
