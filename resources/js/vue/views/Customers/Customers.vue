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
                            <router-link :to="{name:'customers-companies-add'}">
                                <span class="text-white">Add</span>
                                <!--                                    <i class="material-icons text-white">add</i>-->
                            </router-link>
                        </div>
                        <h4 class="card-title">Customers Company</h4>

                    </div>
                    <div class="card-body table-responsive">
                        <VTable @remove="remove" :delete_item="'customers'" :thead="{'id':'ID','name':'Name','created_at':'Date'}" :items="companies" />
                        <paginate
                            :page-count="dataCompanies.last_page?dataCompanies.last_page:0"
                            :page-range="3"
                            :margin-pages="2"
                            :click-handler="paginationCompanies"
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <div class="card-icon float-right ">
                            <router-link :to="{name:'customers-persons-add'}">
                                <span class="text-white">Add</span>
                                <!--                                    <i class="material-icons text-white">add</i>-->
                            </router-link>
                        </div>
                        <h4 class="card-title">Customers Persons</h4>

                    </div>
                    <div class="card-body table-responsive">
                        <VTable @remove="remove" :delete_item="'customers'"
                                :thead="{'id':'ID','name':'Name','created_at':'Date'}" :items="persons" />
                        <paginate
                            :page-count="dataPersons.last_page?dataPersons.last_page:0"
                            :page-range="3"
                            :margin-pages="2"
                            :click-handler="paginationPersons"
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
        name: "Customers",
        data: () => ({
            name: '',
            password: '',
            companies: [],
            persons: [],
            dataCompanies: [],
            dataPersons: [],
        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;

            let self = this;
            self.$http.get(this.$store.state.url.getCustomers, {
                params: {
                    token: self.$store.state.jwt
                }
            }).then((response) => {
                self.dataCompanies = response.data.companies;
                self.companies = self.dataCompanies.data;
                self.dataPersons = response.data.persons;
                self.persons = self.dataPersons.data;
            });

        },
        methods: {
            remove($event, customers) {
                let self = this;
                let id = customers.shift().id;
                self.$swal.fire({
                    icon: 'warning',
                    title: 'Delete this Person',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return self.$http.delete(self.$store.state.url.destroyCustomers + id, {
                            data: {token: self.$store.state.jwt}
                        }).then((response) => {
                            self.$toastr.s(response.data.message);
                            self.dataCompanies = response.data.companies;
                            self.companies = self.dataCompanies.data;
                            self.dataPersons = response.data.persons;
                            self.persons = self.dataPersons.data;
                        })
                    },
                }).then((result) => {
                    if (result.value) {
                        console.log(result.value)
                    }
                });


            },
            paginationCompanies(pageNum) {
                let self = this;
                self.$http.get(self.$store.state.url.getCustomersCompanies + '?page=' + pageNum, {
                    params: {
                        token: self.$store.state.jwt
                    }
                }).then((response) => {
                    self.dataCompanies = response.data.companies;
                    self.companies = self.dataCompanies.data;
                });
            },
            paginationPersons(pageNum) {
                let self = this;
                self.$http.get(self.$store.state.url.getCustomersPersons + '?page=' + pageNum, {
                    params: {
                        token: self.$store.state.jwt
                    }
                }).then((response) => {
                    self.dataPersons = response.data.persons;
                    self.persons = self.dataPersons.data;
                });
            }
        }
    }
</script>

<style scoped>

</style>
