<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div v-bind:class="{'card-header-success':!edit,'card-header-warning':edit}" class="card-header ">
                            <h4 v-if="!edit" class="card-title">Create Person</h4>
                            <h4 v-else class="card-title">Edit Person</h4>
                        </div>
                        <div class="card-body mt-5">
                            <form v-on:submit="update($event)" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <VInput v-model="person.name" ref="name" :label="'Name'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="person.info.address" ref="address" :label="'Address'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="person.info.contacts" ref="contacts" :label="'Contacts'"/>
                                    </div>
                                    <div class="col-12">
                                        <label class="typo__label">Simple Companies</label>
                                        <VueSelect
                                            v-model="person.companies"
                                            :options="options"
                                            :multiple="true"
                                            label="name"
                                            placeholder="Select Companies"
                                        >
                                        </VueSelect>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-2 my-2">
                                                <img class="img-fluid" :src="'/images/'+person.image" alt="">
                                            </div>
                                        </div>
                                        <VueDropify  v-on:upload="uploadFile($event)"  ref="file"/>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <span v-if="!edit" >Create Profile</span>
                                    <span v-else >Update Profile</span>
                                </button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</template>

<script>

    import CompanyRequest from "../../http/api/CompanyRequest";
    import PersonRequest from "../../http/api/PersonRequest";

    export default {
        name: "Person",
        props:{
            edit:{
                default:false
            }
        },
        data: () => {
            return {
                person: {
                    info:{}
                },
                selected:null,
                options: [],
                errors: {},
                files: null
            }
        },
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            if(this.edit){
                PersonRequest.show(self.$route.params.id).then((data)=>{
                    self.person = data.person;
                    if(!self.person.info){
                        self.person.info = {}
                    }
                    this.selected = self.person.companies;
                } );
            }
            CompanyRequest.get().then((response)=>{
                self.options = response.companies;
            } )
        },
        methods: {
            update($event) {
                $event.preventDefault();
                let selected = [];
                this.person.companies.map(function (item) {
                    selected.push(item.id)
                });
                this.selected = selected;
                if (!this.validate()) return false;
                self = this;
                const fd = new FormData();
                if(this.files){
                    fd.append('image', this.files[0]);
                }
                fd.append('token', localStorage.getItem('jwt'));
                if(this.person.id){
                    fd.append('id', this.person.id??null);
                }
                if(this.person.name){
                    fd.append('name', this.person.name??null);
                }
                if(Array.isArray(this.selected)){
                    this.selected.map(function (item) {
                        fd.append('selected[]', item??null);
                    });
                }
                if(this.person.selected){
                    fd.append('selected', this.selected??null);
                }
                if(this.person.type){
                    fd.append('type', this.person.type??null);
                }
                if(this.person.info.address){
                    fd.append('address', this.person.info.address??null);
                }
                if(this.person.info.site){
                    fd.append('site', this.person.info.site??null);
                }
                if(this.person.info.contacts){
                    fd.append('contacts', this.person.info.contacts??null);
                }
                if(this.edit)
                    PersonRequest.update(this.$route.params.id,fd).then((data) => {
                        self.$router.push({name:'persons'});
                        self.$toastr.s(data.message);
                    });
                else
                PersonRequest.create(fd).then((data) => {
                    self.$router.push({name:'persons'});
                    self.$toastr.s(data.message);
                });
            },
            uploadFile($event) {
                this.files = $event
            },
            validate() {
                let error = false;
                if (!this.person.name) {
                    this.$refs.name.error = 'name is required';
                    this.$toastr.e('name in required');
                    error = true;
                }
                return !error;
            }
        },
    }
</script>

<style scoped>

</style>
