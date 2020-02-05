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
                            </router-link>
                        </div>
                        <h4 class="card-title">Persons</h4>

                    </div>
                    <div class="card-body table-responsive">
                        <VTable @remove="remove"
                                :edit_route="'person-edit'"
                                :thead="{'id':{name:'ID'},
                                'name':{name:'Name'},
                                'created_at':{name:'Date'}}"
                                :items="persons" />
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

    import PersonRequest from "../../http/api/PersonRequest";

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
            PersonRequest.index().then((response) => {
                self.data = response.persons;
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
                        PersonRequest.delete(id,{
                            page:self.data.current_page
                        }).then( (response)=>{
                            self.$toastr.s(response.message);
                            self.data = response.persons;
                            self.persons = self.data.data;
                        } );
                    },
                });
            },
            clickCallback(pageNum) {
                let self= this;
                PersonRequest.index({
                    page:pageNum
                }).then((response) => {
                    self.data = response.persons;
                    self.persons = self.data.data;
                });
            }
        }
    }
</script>

<style scoped>

</style>
