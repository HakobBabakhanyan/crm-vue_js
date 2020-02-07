<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Edit Profile</h4>
                            <p class="card-category">Complete your profile</p>
                        </div>
                        <div class="card-body mt-5">
                            <form v-on:submit="update($event)" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <VInput v-model="user.name" ref="name" :label="'Name'"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <VInput v-model="user.old_password" :type="'password'" :label="'Old Password'"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <VInput v-model="user.password" :type="'password'" :label="'New Password'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="user.password_confirmation" :type="'password'"
                                                :label="'Confirmed Password'"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <VueDropify v-on:upload="uploadFile($event)"  ref="file"/>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="#pablo">
                                <img class="img" :src="'/images/'+user.image"/>
                            </a>
                        </div>
                        <div class="card-body">
<!--                            <h6 class="card-category text-gray">CEO / Co-Founder</h6>-->
                            <h4 class="card-title">{{ name }}</h4>
<!--                            <p class="card-description">-->
<!--                                Don't be scared of the truth because we need to restart the human foundation in truth-->
<!--                                And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...-->
<!--                            </p>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "Profile",
        data: () => {
            return {
                user: {},
                errors: {},
                name: '',
                files: null
            }
        },
        mounted() {
            let self = this;
            if(!self.$store.state.user){
                self.$helpers.getUser().then((data) => {
                    self.$store.state.user = data.user;
                    self.user = self.$store.state.user;
                    self.name = self.user.name
                });
            } else {
                self.user = self.$store.state.user;
                self.name = self.user.name
            }
        },
        methods: {
            update($event) {
                $event.preventDefault();
                if (!this.validate()) return false;
                let self = this;
                const fd = new FormData();
                fd.append('token', localStorage.getItem('jwt'));

                if(this.files){
                    fd.append('image', this.files[0]);
                }
                if(this.user.name){
                    fd.append('name', this.user.name??null);
                }
                if(this.user.old_password){
                    fd.append('old_password',this.user.old_password??null);
                }
                if(this.user.password){
                    fd.append('password',this.user.password??null);
                }
                if(this.user.password_confirmation){
                    fd.append('password_confirmation',this.user.password_confirmation??null);
                }
                this.$http.post('/api/user/update', fd,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'autorizacion': localStorage.getItem('jwt'),

            }

            }).
                then((request) => {
                    self.$toastr.s(request.data.message);
                    self.user = request.data.user;
                    self.name = self.user.name;
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
                if (!this.user.name) {
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
