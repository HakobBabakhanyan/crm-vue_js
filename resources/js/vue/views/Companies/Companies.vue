<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Companies</h4>
                        <router-link :to="{name:'company-add'}">
                            <button type="button" class="btn btn-raised btn-success py-2">
                                Add
                            </button>
                        </router-link>

                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>date</th>
                            <th class="text-center">action</th>
                            </thead>
                            <tbody>
                            <tr v-for="(company, index) in companies">
                                <td> {{ company.id }}</td>
                                <td> {{ company.name }}</td>
                                <td> {{ company.type }}</td>
                                <td> {{ company.created_at }}</td>
                                <td class="text-center">
                                   <span class="btn-group-sm">
                                        <router-link class="btn btn-success bmd-btn-fab py-1 px-1"
                                                     :to="{name:'company-edit',params:{id:company.id} }">
                                            <i class="material-icons">edit</i>
                                        </router-link>
                                    </span>
                                    <span class="btn-group-sm">
                                        <button v-on:click="remove($event,company.id)"
                                            type="button" class="btn btn-danger bmd-btn-fab py-1 px-1">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
            companies: []
        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;

            let self = this;
            self.$http.get(this.$store.state.url.getCompanies, {
                params: {
                    token: self.$store.state.jwt
                }
            }).then((response) => {
                self.companies = response.data.companies;
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


            }
        }
    }
</script>

<style scoped>

</style>
