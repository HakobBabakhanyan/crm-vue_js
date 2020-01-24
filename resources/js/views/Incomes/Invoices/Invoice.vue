<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div  v-bind:class="{'card-header-success':!edit,'card-header-warning':edit}" class="card-header">
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
                                           @input="selectItem"
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
                                   <div class="col-md-6 mt-2">
                                       <label class="typo__label">Invoice Date</label>
                                       <Datepicker
                                           v-model="date.Invoice"
                                           :lang="'en'"
                                       />
                                   </div>
                                   <div class="col-md-6 mt-2">
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
                                               :label="'Invoice Number'"/>
                                   </div>
                               </div>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <span v-if="!edit" >Create</span>
                                    <span v-else >Update</span>
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

    export default {
        name: "IncomesInvoice",
        props:{
            edit: {
                default:false
            },
        },
        data: () => {
            return {
                item:{},
                isLoading:false,
                invoice:{},
                customers: [],
                currencies:[],
                date:{
                    Invoice: "2020-01-24",
                    due: "2020-01-26",
                }
            }
        },
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            this.$http.get(this.$const.URL.SETTINGS_CURRENCIES_GET_ALL, {
                params: {
                    token: self.$store.state.jwt,
                }
            }).then((response) => {
                self.currencies = response.data.items;
            });
            if(self.edit){

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
            asyncFind (query) {
                let self = this;
                this.isLoading = true;
                this.$http.all([
                    this.$http.get(self.$const.URL.CUSTOMERS_PERSONS_SEARCH,{
                        params: {
                            token: self.$store.state.jwt,
                            search: query,
                        }
                    }),
                    this.$http.get(self.$const.URL.CUSTOMERS_COMPANIES_SEARCH,{
                        params: {
                            token: self.$store.state.jwt,
                            search: query,
                        }
                    }),
                ]).then(this.$http.spread((requestPersons,requestCompanies) => {
                        self.customers = [
                            {
                                type: 'Persons',
                                items: requestPersons.data.items
                            },
                            {
                                type: 'Companies',
                                items: requestPersons.data.items
                            }
                        ];
                        self.isLoading = false
                    }));
            },
            selectItem(t){
                console.log(t)
            }
        },
    }
</script>

<style scoped>

</style>
