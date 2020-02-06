<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div v-bind:class="{'card-header-success':!edit,'card-header-warning':edit}"
                             class="card-header">
                            <h4 v-if="!edit" class="card-title">Create </h4>
                            <h4 v-else class="card-title">Edit </h4>
                        </div>
                        <div class="card-body mt-5">
                            <form v-on:submit="update($event)" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="typo__label">Customers</label>
                                        <VueSelect
                                            v-model="invoice.customer"
                                            :options="customers"
                                            @search="customerFind"
                                            label="name"
                                            placeholder="Select Customers"
                                        >
                                            <template  v-slot:option="option">
                                                <i class="fa"
                                                   v-bind:class="{
                                                    'fa-building':option.parent_type ==='App\\Models\\Company',
                                                    'fa-user':option.parent_type ==='App\\Models\\Person',
                                                   }"></i>
                                                {{ option.parent.name }}
                                            </template>
                                        </VueSelect>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="typo__label">Currencies</label>
                                        <VueSelect
                                            v-model="invoice.currency"
                                            :options="currencies"
                                            track-by="id"
                                            label="name"
                                            placeholder="Select Currencies"
                                        />

                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label class="typo__label">Invoice Date</label>
                                        <Datepicker
                                            v-model="form.invoice_date"
                                            :lang="'en'"
                                        />
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label class="typo__label">Due Date</label>
                                        <Datepicker v-model="form.due_date"
                                                    :lang="'en'"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="invoice.invoice_number"
                                                ref="number"
                                                :label="'Invoice Number'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="invoice.order_number"
                                                ref="number"
                                                :label="'Order Number'"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-hover">
                                            <thead class="text-warning">
                                            <th>Actions</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th v-if="(invoice.currency && !invoice.currency.default)">Price</th>
                                            <th>Price Default</th>
                                            <th>Tax</th>
                                            <th v-if="(invoice.currency && !invoice.currency.default)">Total</th>
                                            <th>Total Default</th>
                                            </thead>
                                            <tbody>
                                                <tr v-if="invoice.items.lengthphp" v-for="(v,k) in invoice.items">
                                                <td >
                                                    <button  type="button" class="btn btn-link btn-danger p-1"
                                                            v-on:click="removeList(k)">
                                                        <i class="fa fa-minus"> </i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <div>
                                                        <VueSelect
                                                            v-model="v.item"
                                                            :options="items"
                                                            :clearable="false"
                                                            :filterable="false"
                                                            @search="itemsFind"
                                                            label="name"
                                                            placeholder="Select Customers"
                                                        />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="width: 100px">
                                                        <VInput
                                                            :label="'Quantity'"
                                                            v-model="v.quantity"
                                                        />
                                                    </div>
                                                </td>
                                                <td v-if="(invoice.currency && !invoice.currency.default)">
                                                    {{ $helpers.getSalePrice(v,invoice.currency) }}
                                                </td>
                                                    <td>
                                                        {{ $helpers.getSalePrice(v,currencyDefault) }}
                                                    </td>
                                                <td>
                                                    <VueSelect
                                                        v-model="v.taxes"
                                                        :options="taxes"
                                                        multiple
                                                        label="name"
                                                        @input="RecurringSelect"
                                                    />
                                                </td>
                                                <td v-if="(invoice.currency && !invoice.currency.default)">
                                                    {{ $helpers.getSalePrice(v,invoice.currency,true) }}
                                                </td>
                                                <td>
                                                    {{ $helpers.getSalePrice(v,currencyDefault,'total') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="(invoice.currency && !invoice.currency.default)?8:6">
                                                    <button type="button" class="btn btn-link btn-success"
                                                            v-on:click="invoice.items.push(new Object)">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="(invoice.currency && !invoice.currency.default)?7:5">
                                                    Subtotal
                                                </td>
                                                <td>
                                                  {{ subTotal }}
                                                </td>
                                            </tr>
                                                <tr>
                                                    <td :colspan="(invoice.currency && !invoice.currency.default)?7:5">
                                                        tax
                                                    </td>
                                                    <td>
                                                        {{ tax }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td :colspan="(invoice.currency && !invoice.currency.default)?7:5">
                                                        total
                                                    </td>
                                                    <td>
                                                        {{ total }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-12">
                                        <VTextarea
                                            v-model="invoice.description"
                                            ref="number"
                                            :label="'Description'"
                                        />
                                    </div>
                                    <div class="col-12 my-2">
                                        <VueSelect
                                            v-model="invoice.category"
                                            :options="categories"
                                            label="name"
                                            placeholder="Category"
                                        />
                                    </div>
                                    <div class="col-12 my-2">
                                        <div class="row">
                                            <div class="col">
                                                <VueSelect
                                                    :options="recurring.data"
                                                    @input="RecurringSelect"
                                                />
                                            </div>
                                            <div class="col"
                                                 v-if="( typeof recurring.times !== 'boolean'  )">
                                                <VInput
                                                    v-model="recurring.times"
                                                    ref="times"
                                                    :label="'Times'"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <span v-if="!edit">Create</span>
                                    <span v-else>Update</span>
                                </button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import CurrencyRequest from "../../../http/api/CurrencyRequest";
    import CustomerRequest from "../../../http/api/CustomerRequest";
    import InvoiceRequest from "../../../http/api/InvoiceRequest";
    import InvoiceCategoryRequest from "../../../http/api/InvoiceCategoryRequest";
    import ItemRequest from "../../../http/api/ItemRequest";
    import TaxRequest from "../../../http/api/TaxRequest";

    export default {
        name: "IncomesInvoice",
        props: {
            edit: {
                default: false
            },
        },
        data: () => {
            return {
                invoice: {
                    items: [new Object],
                    currency:{},
                },
                form:{
                    invoice_date: new Date(),
                    due_date: new Date(),
                },
                items: [],
                categories: [],
                taxes: [],
                recurring: {
                    data: [
                        'No', 'Daily', 'Weekly', 'Monthly', 'Yearly', 'Custom'
                    ],
                    times: false
                },
                isLoading: false,
                customers: [],
                currencies: [],
                currencyDefault: null,
            }
        },
        mounted() {
            let self = this;
            InvoiceRequest.getNumber().then((response) => {
                self.invoice.invoice_number = response.number
            });
            CurrencyRequest.get().then((data) => {
                self.currencies = data.currencies;
                let currencyDefault = self.currencies.find(function (item) {
                        return item.default === 1
                });
                self.currencyDefault = currencyDefault;
                self.invoice.currency = currencyDefault;
            });
            InvoiceCategoryRequest.get().then((response) => {
                self.categories = response.categories
            });
            TaxRequest.get().then((data) => {
                self.taxes = data.taxes
            });
            if (self.edit) {
                InvoiceRequest.show(self.$route.params.id).then( data =>{
                    self.invoice = data.invoice;
                    data.invoice.items = data.invoice.invoice_items.map(function ($item) {
                        return {item:$item.item,quantity: $item.quantity,taxes:$item.taxes}
                    })
                } )
            }

        },
        methods: {
            update($event) {
                $event.preventDefault();
                let self = this;
                self.form.currency_id = self.invoice.currency.id;
                self.form.customer_id = self.invoice.customer.id;
                self.form.invoice_number = self.invoice.invoice_number;
                self.form.order_number = self.invoice.order_number;
                self.form.data = self.invoice.items.map(function (item) {
                     return  {
                         item_id:item.item.id,
                         quantity:(item.quantity || 1),
                         tax:Array.isArray(item.taxes)?(item.taxes.map(function (item) {
                                return item.id
                         })):null
                     }
                });
                self.form.description = self.invoice.description;
                self.form.category_id = self.invoice.category.id;
                InvoiceRequest.create({
                    invoice:self.form
                }).then( data => {
                    self.$router.push({name: 'item-index'});
                    self.$toastr.s(data.message);
                });
            },
            customerFind(query,loading){
                let self = this;
                loading(true);
                CustomerRequest.search({
                    search: query
                }).then((data) => {
                    self.customers = data.customers;
                    loading(false);
                });
            },
            itemsFind(search,loading) {
                loading(true);
                ItemRequest.search({
                    search: search  ,
                }).then((data) => {
                    this.items = data.items;
                    loading(false);
                });
            },
            RecurringSelect(select) {
                let times = [
                    'Daily', 'Weekly', 'Monthly', 'Yearly'
                ];
                if (times.indexOf(select) >= 0) {
                    this.recurring.times = null;
                } else {
                    this.recurring.times = false;
                }
            },
            removeList(index){
                if(index){
                    this.invoice.items.splice(index,1)
                }else {
                    this.$toastr.w('last item')
                }
            },
            setSelectedItems(k,value){
                this.items = [ ...this.items];
                this.invoice.items[k] = { ...value };
                // v.item = { ...value };
            }
        },
        computed:{
            subTotal(){
                let acc =  this.invoice.items.reduce((acc, data) => {
                        return acc + this.$helpers.getSalePrice(data,null,'subtotal')
                }, 0);

                return `${(acc * this.invoice.currency.rate).toFixed(2)} ${this.invoice.currency.code}`
            },
            tax(){
                let acc = this.invoice.items.reduce((acc, data) => {
                    return acc + this.$helpers.getSalePrice(data,null,'tax')
                }, 0);
                return `${(acc * this.invoice.currency.rate).toFixed(2)} ${this.invoice.currency.code}`
            },
            total(){
                let acc = this.invoice.items.reduce((acc, data) => {
                    return acc + this.$helpers.getSalePrice(data,null,'total_tax')
                }, 0);

                return `${(acc * this.invoice.currency.rate).toFixed(2)} ${this.invoice.currency.code}`
            }
        }
    }
</script>

<style scoped>

</style>
