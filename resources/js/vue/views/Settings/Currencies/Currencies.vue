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
                            <router-link :to="{name:'settings-currencies-create'}">
                                <span class="text-white">Add</span>
                            </router-link>
                        </div>
                        <h4 class="card-title"> Currencies </h4>
                    </div>
                    <div class="card-body table-responsive">
                        <VTable @remove="remove" :edit_route="'settings-currencies-edit'"
                                :thead="{'id':'ID','name':'Name','code':'Code','rate':'Rate'}" :items="items" />
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
    export default {
        name: "Currencies",
        data: () => ({
            items: [],
            data: [],

        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            self.$http.get(self.$const.URL.SETTINGS_CURRENCIES_INDEX, {
                params: {
                    token: self.$store.state.jwt
                }
            }).then((response) => {
                self.data = response.data.items;
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
                        return self.$http.delete(self.$const.URL.SETTINGS_CURRENCIES_DESTROY + id, {
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
                self.$http.get(self.$const.URL.ITEM_CATEGORIES_INDEX + '?page=' + pageNum, {
                    params: {
                        token: self.$store.state.jwt
                    }
                }).then((response) => {
                    self.data = response.data.categories;
                    self.items = self.data.data;
                });
            },
        }
    }
</script>

<style scoped>

</style>
