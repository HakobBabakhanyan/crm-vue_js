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
                                            :options="customers"
                                            @search="customerFind"
                                            label="name"
                                            placeholder="Select Customers"
                                        >
                                            <template  v-slot:option="option">
                                                <i class="fa"
                                                   v-bind:class="{
                                                    'fa-building':option.parent.type ==='App\\Models\\Company',
                                                    'fa-user':option.parent.type ==='App\\Models\\Person',
                                                   }"></i>
                                                {{ option.parent.name }}
                                            </template>
                                        </VueSelect>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="typo__label">Currencies</label>
                                        <VueSelect
                                            v-model="item.currency"
                                            :options="currencies"
                                            track-by="id"
                                            label="name"
                                            placeholder="Select Currencies"
                                        />

                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label class="typo__label">Invoice Date</label>
                                        <Datepicker
                                            v-model="date.Invoice"
                                            :lang="'en'"
                                        />
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label class="typo__label">Due Date</label>
                                        <Datepicker v-model="date.due"
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
                                            <th v-if="(item.currency && !item.currency.default)">Price</th>
                                            <th>Price Default</th>
                                            <th>Tax</th>
                                            <th v-if="(item.currency && !item.currency.default)">Total</th>
                                            <th>Total Default</th>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(v,k) in item.data">
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
                                                <td v-if="(item.currency && !item.currency.default)">
                                                    {{ $helpers.getSalePrice(v,item.currency) }}
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
                                                <td v-if="(item.currency && !item.currency.default)">
                                                    {{ $helpers.getSalePrice(v,item.currency,true) }}
                                                </td>
                                                <td>
                                                    {{ $helpers.getSalePrice(v,currencyDefault,'total') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="(item.currency && !item.currency.default)?8:6">
                                                    <button type="button" class="btn btn-link btn-success"
                                                            v-on:click="item.data.push(new Object)">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="(item.currency && !item.currency.default)?7:5">
                                                    Subtotal
                                                </td>
                                                <td>
                                                  {{ subTotal }}
                                                </td>
                                            </tr>
                                                <tr>
                                                    <td :colspan="(item.currency && !item.currency.default)?7:5">
                                                        tax
                                                    </td>
                                                    <td>
                                                        {{ tax }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td :colspan="(item.currency && !item.currency.default)?7:5">
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
                                            v-model="item.category"
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

    import Currencies from "../../../http/api/Currencies";
    import Customers from "../../../http/api/Customers";
    import Invoices from "../../../http/api/Invoices";
    import IncomesCategories from "../../../http/api/IncomesCategories";
    import Items from "../../../http/api/Items";
    import Tax from "../../../http/api/Tax";

    export default {
        name: "IncomesInvoice",
        props: {
            edit: {
                default: false
            },
        },
        data: () => {
            return {
                item: {
                    data: [new Object],
                    currency:Object
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
                invoice: {},
                customers: [],
                currencies: [],
                currencyDefault: {},
                date: {
                    Invoice: "2020-01-24",
                    due: "2020-01-26",
                }
            }
        },
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            Invoices.getNumber().then((response) => {
                self.invoice.invoice_number = response.number
            });
            Currencies.get().then((data) => {
                self.currencies = data.items;
                self.currencyDefault= self.currencies.find(function (item) {
                        return item.default === 1
                });
                self.item.currency = self.currencyDefault;
            });
            IncomesCategories.get().then((response) => {
                self.categories = response.items
            });
            Tax.search().then((data) => {
                self.taxes = data.taxes
            });
            if (self.edit) {

            }

        },
        methods: {
            update($event) {
                $event.preventDefault();
                let self = this;
                console.log(self.type);

            },
            customerFind(query){
                let self = this;
                Customers.search({
                    search: query
                }).then((data) => {
                    self.customers = data.customers;
                });
            },
            itemsFind(search,loading) {
                loading(true);
                Items.search({
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
                    this.item.items.splice(index,1)
                }else {
                    this.$toastr.w('last item')
                }
            },
            setSelectedItems(k,value){
                this.items = [ ...this.items];
                this.item.data[k] = { ...value };
                // v.item = { ...value };
            }
        },
        watch:{
            'item.items.item':{
                handler(val){
                    console.log(val)
                },
            }
        },
        computed:{
            subTotal(){
                let acc =  this.item.data.reduce((acc, data) => {
                        return acc + this.$helpers.getSalePrice(data,null,'subtotal')
                }, 0);

                return `${(acc * this.item.currency.rate)} ${this.item.currency.code}`
            },
            tax(){
                let acc = this.item.data.reduce((acc, data) => {
                    return acc + this.$helpers.getSalePrice(data,null,'tax')
                }, 0);
                return `${(acc * this.item.currency.rate)} ${this.item.currency.code}`
            },
            total(){
                let acc = this.item.data.reduce((acc, data) => {
                    return acc + this.$helpers.getSalePrice(data,null,'tax_total')
                }, 0);

                return `${(acc * this.item.currency.rate)} ${this.item.currency.code}`

            }
        }
    }
</script>

<style scoped>

</style>
