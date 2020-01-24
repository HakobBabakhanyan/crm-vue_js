<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div v-bind:class="{'card-header-success':!edit,'card-header-warning':edit}" class="card-header ">
                            <h4 v-if="!edit" class="card-title">Create Profile</h4>
                            <h4 v-else class="card-title">Edit Profile</h4>
                        </div>
                        <div class="card-body mt-5">
                            <form v-on:submit="update($event)" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <VInput v-model="company.name" ref="name" :label="'Name'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="company.type" ref="type" :label="'Type'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="company.info.address" ref="address" :label="'Address'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="company.info.site" ref="site" :label="'Site'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="company.info.contacts" ref="contacts" :label="'Contacts'"/>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-2 my-2">
                                                <img class="img-fluid" :src="'/images/'+company.logo" alt="">
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

    import Companies from "../../http/api/Companies";

    export default {
        name: "CompanyAdd",
        props:{
            edit:{
                default:false
            }
        },
        data: () => {
            return {
                company: {
                    info:{}
                },
                errors: {},
                files: null
            }
        },
        mounted() {
            this.$parent.auth = this.$store.state.jwt;

            if(this.edit){
                let self = this;
                Companies.get({
                    id:self.$route.params.id
                }).then( (response) => {
                    self.company = response.companies.shift();
                    if(!self.company.info){
                        self.company.info = {}
                    }
                });

            }
        },
        methods: {
            update($event) {
                $event.preventDefault();
                if (!this.validate()) return false;
                self = this;
                const fd = new FormData();
                if(this.files){
                    fd.append('image', this.files[0]);
                }
                if(this.company.id){
                    fd.append('id', this.company.id??null);
                }
                if(this.company.name){
                    fd.append('name', this.company.name??null);
                }
                if(this.company.type){
                    fd.append('type', this.company.type??null);
                }
                if(this.company.info.address){
                    fd.append('address', this.company.info.address??null);
                }
                if(this.company.info.site){
                    fd.append('site', this.company.info.site??null);
                }
                if(this.company.info.contacts){
                    fd.append('contacts', this.company.info.contacts??null);
                }
                Companies.sync(fd).then((response) => {
                    self.$router.push({name:'companies'});
                    self.$toastr.s(response.message);
                });
            },
            uploadFile($event) {
                this.files = $event
            },
            validate() {
                let error = false;
                if (!this.company.name) {
                    this.$refs.name.error = 'name is required';
                    this.$toastr.e('name in required');
                    error = true;
                }
                if (!this.company.type) {
                    this.$refs.type.error = 'type is required';
                    this.$toastr.e('type in required');
                    error = true;
                }
                return !error;
            }
        },
    }
</script>

<style scoped>

</style>
