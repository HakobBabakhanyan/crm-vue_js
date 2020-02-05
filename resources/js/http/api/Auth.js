import Api from './Api';
import request from '../request'

class Companies extends Api {

    constructor() {
        super();
    }

    static getUrl() {
        return {
            LOGIN: '/api/login',
            LOGOUT: '/api/logout',
        };
    }

    static login(query) {
        return request({
            url: this.getUrl().LOGIN,
            method: 'post',
            data: query
        })
    }

    static logout(query) {
        return request({
                url: this.getUrl().LOGOUT,
                method: 'post',
                data: query
            }
        )
    }


}

export default Companies;
