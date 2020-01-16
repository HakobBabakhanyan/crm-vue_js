<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12   ">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Edit Profile</h4>
                            <p class="card-category">Complete your profile</p>
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
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
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

    import VInput from '../../components/form/VInput'
    import VueDropify from '../../components/form/Dropify';

    export default {
        name: "CompanyAdd",
        components: {VInput, VueDropify},
        props:{
            edit:{
                default:false
            }
        },
        data: () => {
            return {
                company: {},
                errors: {},
                files: null
            }
        },
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            if(this.edit){
                let self = this;
                this.$http.get(self.$store.state.url.getCompany+self.$route.params.id,{
                    params: {
                        token: self.$store.state.jwt
                    }
                }).then((response)=>{
                    self.company = response.data.company
                } )
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
                fd.append('token', localStorage.getItem('jwt'));
                if(this.company.id){
                    fd.append('id', this.company.id??null);
                }
                if(this.company.name){
                    fd.append('name', this.company.name??null);
                }
                if(this.company.type){
                    fd.append('type', this.company.type??null);
                }
                this.$http.post(this.$store.state.url.addCompany, fd,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
            }

            }).
                then((response) => {
                    self.$router.push({name:'companies'});
                    self.$toastr.s(response.data.message);
                }).catch((error) => {
                    if (error.response) {
                        if (error.response.status === 422) {
                            Object.keys(error.response.data.errors).forEach(function (item) {
                                self.$toastr.e(error.response.data.errors[item])
                            });
                        }
                    }
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
                return !error;
            }
        },
    }
</script>

<style scoped>
</style>
