<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <div class="card-icon float-right ">
                            <router-link :to="{name:'incomes-invoices-create'}">
                                <span class="text-white">Add</span>
                            </router-link>
                        </div>
                        <h4 class="card-title">Invoices</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <VTable @remove="remove" :edit_route="'incomes-invoices-edit'"
                                :thead="{'id':{name:'ID'},
                                'invoice_number':{name:'Number'},
                                'invoice_date':{name:'Invoice Date'},
                                'due_date':{name:'Due Date '}}"
                                :items="items" >
                            <template   v-slot:action="{item}" >
                                <router-link class="btn btn-success btn-link"
                                             :to="{name:'incomes-invoices-show',
                                             params:{id:item.id} }">
                                    <i class="fa fa-eye"></i>
                                </router-link>
                            </template>

                        </VTable>
                        <paginate
                            :page-count="data.last_page?data.last_page:0"
                            :page-range="3"
                            :margin-pages="2"
                            :click-handler="pagination"
                            :prev-text="'Prev'"
                            :next-text="'Next'"
                            :container-class="'pagination'"
                            :page-class="'page-item'"
                            :page-link-class="'page-link'"
                            :prevClass="'page-item'"
                            :nextClass="'page-item'"
                            :prevLinkClass="'page-link'"
                            :nextLinkClass="'page-link'"
                        >
                        </paginate>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import InvoiceCategoryRequest from "../../../http/api/InvoiceCategoryRequest";
    import InvoiceRequest from "../../../http/api/InvoiceRequest";

    export default {
        name: "IncomesInvoices",
        data: () => ({
            items: [],
            data: [],

        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            InvoiceRequest.index().then((data) => {
                self.data = data.invoices;
                self.items = self.data.data;
            });

        },
        methods: {
            remove($event, id) {
                let self = this;
                self.$swal.fire({
                    icon: 'warning',
                    title: 'Delete this Item !',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    preConfirm: (item) => {
                        return self.$http.delete(self.$const.URL.INCOMES_CATEGORIES_DESTROY + id, {
                            data: {token: self.$store.state.jwt}
                        }).then((response) => {
                            self.$toastr.s(response.data.message);
                            self.data = response.data.items;
                            self.items = self.data.data;
                        })
                    },
                })

            },
            pagination(pageNum) {
                let self = this;
               console.log(pageNumzz)
            },
        }
    }
</script>

<style scoped>

</style>
