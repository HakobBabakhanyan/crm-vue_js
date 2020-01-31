import Vue from "vue";
import VueToastr from "vue-toastr";
import VueSweetalert2 from 'vue-sweetalert2';


Vue.use(VueToastr, {
    defaultTimeout: 1500,
    defaultProgressBar: false
});
Vue.use(VueSweetalert2);


Vue.component('SideBarCollapse', require('./views/layout/SideBarCollapse').default);
Vue.component('NavBar', require('./views/layout/NavBar').default);
Vue.component('SideBar', require('./views/layout/SideBar').default);
Vue.component('VFooter', require('./views/layout/Footer').default);

Vue.component('Datepicker',require('vue-datepicker-ui').default);
Vue.component('VTable', require('./views/components/table/VTable').default);
Vue.component('VTextarea', require('./views/components/form/VTextarea').default);
Vue.component('VCheckbox', require('./views/components/form/VCheckbox').default);
Vue.component('VInput', require('./views/components/form/VInput').default);

Vue.component('IncomesCategories', require('./views/incomes/categories/Categories').default);
Vue.component('IncomesCategory', require('./views/incomes/categories/Category').default);
Vue.component('IncomesInvoices', require('./views/incomes/invoices/Invoices').default);
Vue.component('IncomesInvoice', require('./views/incomes/invoices/Invoice').default);


Vue.component('Dashboard', require('./views/Dashboard').default);
Vue.component('Profile', require('./views/Profile').default);
Vue.component('Companies', require('./views/companies/Companies').default);
Vue.component('Company', require('./views/companies/Company').default);
Vue.component('paginate', require('vuejs-paginate'));
Vue.component('VueDropify', require('./views/components/form/Dropify').default);

Vue.component('Login', require('./views/auth/Login').default);
Vue.component('App', require('./views/App.vue').default);
Vue.component('Persons', require('./views/persons/Persons').default);
Vue.component('Person', require('./views/persons/Person').default);
// Vue.component('Multiselect', require('vue-multiselect').default);
Vue.component('Customers', require('./views/customers/Customers').default);
Vue.component('Customer', require('./views/customers/Customer').default);
// item
Vue.component('Items', require('./views/items/Items').default);
Vue.component('Item', require('./views/items/Item').default);
Vue.component('ItemCategories', require('./views/items/Categories/ItemCategories').default);
Vue.component('ItemCategory', require('./views/items/Categories/ItemCategory').default);
// settings
Vue.component('Currencies', require('./views/settings/Currencies/Currencies').default);
Vue.component('Currency', require('./views/settings/Currencies/Currency').default);
Vue.component('Taxes', require('./views/settings/taxes/Taxes').default);
Vue.component('Tax', require('./views/settings/taxes/Tax').default);

Vue.component('VueSelect',require('vue-select').default);



