import CONST from './const';

export default {
    getUser() {
        axios.post('/api/user', {
            token: localStorage.getItem('jwt'),
        }).then((request) => {
            return request.data.user;
        }).catch((error) => {
            console.log(error);
            localStorage.removeItem('jwt')
        });
    },
    objectGetByKeys(ob, key) {
        let keys = new Array();
        ob.map(function (item) {
            if (item[key]) keys.push(item[key])
        });
        return keys;
    },
    getSalePrice(item, currency, quantity, tax) {
        let price;

        if(!item.sale_price){
            item.sale_price = 0;
        }
        if (tax && item[tax]) {
            if (item[tax] === CONST.TAX.NORMAL) {

            }
            ;
        }
        if (quantity) {
            if (typeof quantity === 'string') {
                quantity = item[quantity];
            }
        }
        if (!quantity) {
            quantity = 1;
        }

        price = quantity * item.sale_price;

        if (currency) {
            price = (price * currency.rate) + ' ' + currency.code
        }
        return price;

    },

};
