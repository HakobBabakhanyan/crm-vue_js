import request from '../http/request'
import CONST from './const';
import store from "../store";
import VueToastr from "vue-toastr";
import Vue from 'vue'

Vue.use(VueToastr);

export default {

    test() {
        let vue = new Vue();
        vue.$toastr.Add({
            name: "test", // this is give you ability to use removeByName method
            msg: "test", // Toast Message
            type: "error" // Toast type,
        });
    },
    log_out() {
        localStorage.removeItem('jwt');
        store.commit('reset')
    },
    getUser() {
        return request({
                url: '/api/user',
                method: 'post',
            }
        )
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
        let self = this,
            item = data.item,
            price = item.sale_price,
            taxes,
            quantity = 1,
            inclusive_tax_price=0,
            normal_tax_price=0,
            compound_tax_price=0,
            tax_price=0,
            normal_tax = [], inclusive_tax = [], compound_tax = [];

        if (type) {
            quantity = data.quantity || 1;
            price = quantity * price;
            if (type) {
                taxes = data.taxes;
                if (taxes) {
                    taxes.map(function (tax) {
                        if (tax.type === CONST.TAX.NORMAL) {
                            normal_tax.push(tax);
                        } else if (tax.type === CONST.TAX.INCLUSIVE) {
                            inclusive_tax.push(tax);
                        }else if (tax.type === CONST.TAX.COMPOUND){
                            compound_tax.push(tax);
                        }
                    });
                }

            }
            inclusive_tax.map(function (item) {
                   inclusive_tax_price += self.percent(price,item.rate,true)
            });
            normal_tax.map(function (item) {
                normal_tax_price += self.percent(price,item.rate)
            });
            compound_tax.map(function (item) {
                tax_price = price + normal_tax_price + compound_tax_price;
                compound_tax_price += self.percent(tax_price,item.rate)
            });

            switch (type) {
                case 'subtotal':
                    price = price - inclusive_tax_price;
                    break;
                case 'total':
                    price = price - inclusive_tax_price;
                    break;
                case 'total_tax':
                    price = price + normal_tax_price + compound_tax_price;
                    break;
                case 'tax':
                    price = inclusive_tax_price + normal_tax_price + compound_tax_price;
                    break;
                default:
            }
        }
        if (currency) {
            price = (price * currency.rate).toFixed(2) + ' ' + currency.code
        }

        return price;

    },
    percent(num, per, reverse) {
        if (reverse) {
            return (num - (num * 100) / (100 + per));
        } else
            return (num / 100) * per;
    }

};
