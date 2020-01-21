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
                            <router-link :to="{name:'person-add'}">
                                <span class="text-white">Add</span>
<!--                                    <i class="material-icons text-white">add</i>-->
                            </router-link>
                        </div>
                        <h4 class="card-title">Persons</h4>

                    </div>
                    <div class="card-body table-responsive">
                        <VTable @remove="remove" :edit_route="'person-edit'" :thead="{'id':'ID','name':'Name','created_at':'Date'}" :items="persons" />
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
        name: "Persons",
        data: () => ({
            name: '',
            password: '',
            persons: [],
            data: [],

        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;

            let self = this;
            self.$http.get(this.$store.state.url.getPersons, {
                params: {
                    token: self.$store.state.jwt
                }
            }).then((response) => {
                self.data = response.data.persons;
                self.persons = self.data.data;
            });

        },
        methods: {
            remove($event,id) {
                let self = this;
                self.$swal.fire({
                    icon:'warning',
                    title:'Delete this Person',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return self.$http.delete(self.$store.state.url.destroyPerson+id,{
                            data: { token: self.$store.state.jwt }
                        }).then( (response)=>{
                            self.$toastr.s(response.data.message);
                            self.data = response.data.persons;
                            self.persons = self.data.data;
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
