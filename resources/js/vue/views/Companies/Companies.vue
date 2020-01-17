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
<!--                                    <i class="material-icons text-white">add</i>-->
                            </router-link>
                        </div>
                        <h4 class="card-title">Companies</h4>

                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>date</th>
                            <th class="text-right   ">action</th>
                            </thead>
                            <tbody>
                            <tr v-for="(company, index) in companies">
                                <td> {{ company.id }}</td>
                                <td> {{ company.name }}</td>
                                <td> {{ company.type }}</td>
                                <td> {{ company.created_at }}</td>
                                <td class="td-actions text-right">
                                        <router-link class="btn btn-success btn-link"
                                                     :to="{name:'company-edit',params:{id:company.id} }">
                                            <i class="material-icons">edit</i>
                                        </router-link>
                                        <button v-on:click="remove($event,company.id)"
                                            type="button" class="btn btn-danger btn-link">
                                            <i class="material-icons">delete</i>
                                        </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <paginate
                            :page-count="data.last_page?data.last_page:0"
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
            self.$http.get(this.$store.state.url.getCompanies, {
                params: {
                    token: self.$store.state.jwt
                }
            }).then((response) => {
                console.log(response.data.companies)
                self.data = response.data.companies;
                self.companies = self.data.data;
            });

        },
        methods: {
            remove($event,id) {
                let self = this;
                self.$swal.fire({
                    icon:'warning',
                    title:'Delete this Compny',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return self.$http.delete(self.$store.state.url.destroyCompany+id,{
                            data: { token: self.$store.state.jwt }
                        }).then( (response)=>{
                            self.$toastr.s(response.data.message);
                            self.companies = response.data.companies;
                            return 1;
                        } )
                    },
                }).then((result) => {
                    if (result.value) {
                        console.log(result.value)
                    }
                });


            },
            clickCallback(pageNum) {
                let self= this;
                self.$http.get(self.$store.state.url.getCompanies+'?page='+pageNum, {
                    params: {
                        token: self.$store.state.jwt
                    }
                }).then((response) => {
                    console.log(response.data.companies)
                    self.companies = response.data.companies.data;
                });
            }
        }
    }
</script>

<style scoped>

</style>
