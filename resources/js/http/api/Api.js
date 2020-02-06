import request from '../request';
import axios from 'axios';
const  url = {};


class Api {

   constructor() {
       console.log('API')
   }

   static prefix() { return 'api'};

    static getUrl(){
        return {
            INDEX: this.prefix() + '/index',
            HISTORY: this.prefix() + '/history',
            SHOW: this.prefix() + '/show/:id',
            GET: this.prefix() + '/get',
            CREATE: this.prefix() + '/create',
            UPDATE: this.prefix() + '/update/:id',
            DELETE: this.prefix() + '/destroy/:id',
        };
    }

   static index(query) {
        return request({
            url: this.getUrl().INDEX,
            method: 'get',
            params: query
        })
    }

   static show(id,query){
       return request({
           url:this.getUrl().SHOW.replace(':id', id),
           method:'get',
           params:query
       });
   }

    static create(query){
        return request({
            url:this.getUrl().CREATE,
            method:'post',
            data:query,
        });
    }

    static update(id,query){
       if(query instanceof FormData)
       query.append('_method','put');
       else Object.assign( query,{'_method':'put'});

       return request({
           url:this.getUrl().UPDATE.replace(':id', id),
           method:'post',
           data:query,
       });
    }


    static delete(id,query){
        return request({
            url: this.getUrl().DELETE.replace(':id', id),
            method: 'delete',
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


    static history(query) {
        return request({
            url: this.getUrl().HISTORY,
            method: 'get',
            params: query
        })
    }
}

export default Api;
