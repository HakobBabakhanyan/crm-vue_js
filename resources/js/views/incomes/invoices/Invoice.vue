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
                                        <Multiselect
                                            v-model="item.customers"
                                            :options="customers"
                                            :internal-search="false"
                                            :loading="isLoading"
                                            @search-change="asyncFind"
                                            track-by="id"
                                            label="name"
                                            group-label="type"
                                            group-values="items"
                                            placeholder="Select Customers"
                                        >
                                        </Multiselect>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="typo__label">Currencies</label>
                                        <Multiselect
                                            v-model="item.currency"
                                            :options="currencies"
                                            track-by="id"
                                            label="name"
                                            placeholder="Select Customers"
                                        >
                                        </Multiselect>
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
                                            <th>Price</th>
                                            <th>Tax</th>
                                            <th>Total</th>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,index) in item.items">
                                                <td>
                                                    <button type="button" v-on:click="removeList(index)">
                                                        remove {{ item.items }}
                                                    </button>
                                                </td>
                                                <td>
                                                    <Multiselect
                                                        v-model="item.item"
                                                        :options="items"
                                                        :internal-search="false"
                                                        :loading="isLoading"
                                                        @search-change="itemsFind"
                                                        track-by="id"
                                                        label="name"
                                                        placeholder="Select Customers"
                                                    >
                                                    </Multiselect>
                                                </td>
                                                <td>
                                                    <VInput
                                                        :label="'Quantity'"
                                                        v-model="item.quantity"
                                                    />
                                                </td>
                                                <td>
                                                    {{ item.item?((item.quantity || 1) * item.item.sale_price):'' }}
                                                </td>
                                                <td>
                                                    <Multiselect
                                                        v-model="item.taxe"
                                                        :options="taxes"
                                                        track-by="id"
                                                        label="name"
                                                        placeholder="Select tax"
                                                    >
                                                    </Multiselect>
                                                </td>
                                                <td>
                                                    {{ item.item?item.item.sale_price:'' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <button type="button" v-on:click="item.items.push({})">
                                                        add
                                                    </button>
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
                                        <Multiselect
                                            v-model="item.category"
                                            :options="categories"
                                            track-by="id"
                                            label="name"
                                            placeholder="Category"
                                        />
                                    </div>
                                    <div class="col-12 my-2">
                                        <div class="row">
                                            <div class="col">
                                                <Multiselect
                                                    v-model="item.recurring"
                                                    :options="recurring.data"
                                                    placeholder="Recurring"
                                                    label="Recurring"
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
                    items: [{}]
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
            Currencies.get().then((response) => {
                self.currencies = response.items;
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
                this.$http.post(this.$const.URL.INCOMES_CATEGORIES_SYNC, {
                    token: localStorage.getItem('jwt'),
                    'item': self.item,
                }).then((response) => {
                    self.$router.push({name: 'incomes-categories-index'});
                    self.$toastr.s(response.data.message);
                }).catch((error) => {
                    if (error.response) {
                        if (error.response.status === 422) {
                            Object.keys(error.response.data.errors).forEach(function (item) {
                                self.$toastr.e(error.response.data.errors[item])
                            });
                        }
                    }
                });
            },
            asyncFind(query) {
                let self = this;
                this.isLoading = true;

                Customers.search({
                    search: query
                }).then((request) => {
                    self.customers = [
                        {
                            type: 'Persons',
                            items: request.persons
                        },
                        {
                            type: 'Companies',
                            items: request.companies
                        }
                    ];
                    self.isLoading = false
                });
            },
            itemsFind(query) {
                let self = this;
                this.isLoading = true;
                Items.search({
                    search: query
                }).then((data) => {
                    self.items = data.items;
                    self.isLoading = false
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
                this.item.items.splice(index,1)
            }
        },
    }
</script>

<style scoped>

</style>
