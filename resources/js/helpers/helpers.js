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
    getSalePrice(data, currency, type) {
        if (!data.item) return 0;
        let item = data.item,
            price = item.sale_price,
            taxes,
            tax_price=0,
            quantity = 1;
        if (type ) {
            quantity = data.quantity || 1;
            price = quantity * price;
            if (type) {
                let self= this;
                taxes = data.taxes;
                if(taxes){
                    taxes.map(function (tax) {
                        if (tax.type === CONST.TAX.NORMAL) {
                            tax_price = (tax_price + self.percent(price,tax.rate))
                        }else if(tax.type === CONST.TAX.INCLUSIVE){
                            tax_price = (tax_price + self.percent(price,tax.rate,true))
                        }
                    });
                }

            }
            if(type === 'subtotal') {
                price = price + tax_price;
            }
            else if(type === 'total'){
                price = price + tax_price
            } else if(type === 'tax') { price = Math.abs(tax_price)};
        }
        if (currency) {
            price = (price * currency.rate).toFixed(2) + ' ' + currency.code
        }else {
            price = price.toFixed(2);
        }

        return price;

    },
    percent(num, per,reverse) {
        if(reverse){
            return -(num-(num*100)/(100+per));
        }else
            return (num / 100) * per;
    }

};
