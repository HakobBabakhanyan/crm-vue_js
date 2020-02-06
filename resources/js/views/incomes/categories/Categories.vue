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
                            <router-link :to="{name:'incomes-categories-create'}">
                                <span class="text-white">Add</span>
                            </router-link>
                        </div>
                        <h4 class="card-title">Categories</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <VTable @remove="remove" :edit_route="'incomes-categories-edit'"
                                :thead="{'id':{name:'ID'},'name':{name:'Name'},'created_at':{name:'Date'}}" :items="items" />
                        <paginate
                            v-model="data.current_page"
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

    export default {
        name: "IncomesCategories",
        data: () => ({
            items: [],
            data: [],

        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            InvoiceCategoryRequest.index().then((data) => {
                self.data = data.items;
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
                        return  InvoiceCategoryRequest.delete(id,{
                            page:self.data.current_page
                        }).then((data) => {
                            self.$toastr.s(data.message);
                            self.data = data.items;
                            self.items = self.data.data;
                        })
                    },
                })

            },
            pagination(pageNum) {
                let self = this;
                InvoiceCategoryRequest.index({
                    page:pageNum
                }).then((response) => {
                    self.data = response.data.items;
                    self.items = self.data.data;
                });
            },
        }
    }
</script>

<style scoped>

</style>
