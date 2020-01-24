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
                            <router-link :to="{name:'company-add'}">
                                <span class="text-white">Add</span>
                            </router-link>
                        </div>
                        <h4 class="card-title">Companies</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <VTable @remove="remove" :edit_route="'company-edit'"
                                :thead="{'id':{name:'ID'},'name':{name:'Name'},'created_at':{name:'Date'}}" :items="companies" />
                        <paginate
                            :page-count="data.last_page?data.last_page:0"
                            v-model="data.current_page"
                            :page-range="3"
                            :margin-pages="2"
                            :click-handler="clickCallback"
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

    import Companies from '../../http/api/Companies'

    export default {
        name: "Companies",
        data: () => ({
            name: '',
            password: '',
            companies: [],
            data: [],

        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;

            let self = this;
            Companies.index().then((response) => {
                self.data = response.companies;
                self.companies = self.data.data;
            });

        },
        methods: {
            remove($event,id) {
                let self = this;
                self.$swal.fire({
                    icon:'warning',
                    title:'Delete this Company',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        Companies.delete({
                            id:id,
                            page:self.data.current_page
                        }).then( (response) => {
                            self.$toastr.s(response.message);
                            self.companies = response.companies.data;
                            self.data = response.companies;
                        } )
                    },
                })

            },
            clickCallback(pageNum) {
                let self= this;
                Companies.index({
                    page: pageNum
                }).then((response) => {
                    console.log(response)
                    self.companies = response.companies.data;
                });
            }
        }
    }
</script>

<style scoped>

</style>
