import request from '../request';
import axios from 'axios';
const  url = {};


class Api {

   constructor() {
       console.log('API')
   }

   static getUrl(){
       return {};
   }

   static index(query) {
        return request({
            url: this.getUrl().INDEX,
            method: 'get',
            params: query
        })
    }

    static get(query){
       return request({
          url:this.getUrl().GET,
          method:'get',
          params:query
       });
    }


    static sync(query){

        return request({
            url:this.getUrl().SYNC,
            method:'post',
            data:query,

        });
    }

    static delete(query){
        return request({
            url: this.getUrl().DELETE,
            method: 'delete',
            params: query
        })
    }


}

export default Api;
