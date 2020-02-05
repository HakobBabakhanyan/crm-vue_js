import Api from './Api';
import request from "../request";

class ItemCategoryRequest extends Api {

    static prefix(){ return  '/api/items/categories'};

    static search(query){
        return request({
            url: this.prefix()+'/search',
            method: 'get',
            params: query
        })
    }
}

export default ItemCategoryRequest;
