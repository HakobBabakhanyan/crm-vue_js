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
                            <router-link :to="{name:'item-categories-create'}">
                                <span class="text-white">Add</span>
                            </router-link>
                        </div>
                        <h4 class="card-title">Customers Company</h4>

                    </div>
                    <div class="card-body table-responsive">
                        <VTable @remove="remove" :edit_route="'item-categories-edit'"
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
    import ItemCategoryRequest from "../../../http/api/ItemCategoryRequest";

    export default {
        name: "ItemCategories",
        data: () => ({
            items: [],
            data: [],

        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            ItemCategoryRequest.index().then((data) => {
                console.log(data)
                self.data = data.categories;
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
                        return  ItemCategoryRequest.delete(id,{
                            page:self.data.current_page
                        }).then((data) => {
                            self.$toastr.s(data.message);
                            self.data = data.categories;
                            self.items = self.data.data;
                        })
                    },
                })

            },
            pagination(pageNum) {
                let self = this;
                ItemCategoryRequest.index({
                    page:pageNum
                }).then((data) => {
                    self.data = data.categories;
                    self.items = self.data.data;
                });
            },
        }
    }
</script>

<style scoped>

</style>
