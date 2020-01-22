<template>
    <div>
        <div class="wrapper wrapper-full-page">
            <div class=" page-header login-page header-filter" filter-color="black"
                 style="background-image: url('/img/login.jpg'); background-size: cover; background-position: top center;">
                <div class="container-fluid mt-5 " style="z-index: 100">
                    <div class="row mt-5">
                        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                            <form class="form" v-on:submit="login($event)" method="" action="">
                                <div class="card card-login card-hidden">
                                    <div class="card-header card-header-rose text-center">
                                        <h4 class="card-title">Login</h4>
                                    </div>
                                    <div class="card-body ">
                                        <p class="card-description text-center">Or Be Classical</p>
                                        <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">face</i>
                        </span>
                      </div>
                      <input v-model="name" type="text" class="form-control" placeholder="First Name...">
                    </div>
                  </span>
                                        <span class="bmd-form-group">
                  </span>
                                        <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" v-model="password" class="form-control" placeholder="Password...">
                    </div>
                  </span>
                                    </div>
                                    <div class="card-footer justify-content-center">
                                        <button type="submit" class="btn btn-rose btn-link btn-lg">Lets Go</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "Login",
        data: () => ({
            name: '',
            password: ''
        }),
        mounted() {
            this.$parent.auth = localStorage.getItem('jwt');
        },
        methods: {
            login(event) {
                event.preventDefault();
                let self = this;
                if (this.name !== "" && this.password !== "") {
                    this.$http.post('/api/login', {
                        name: this.name,
                        password: this.password
                    }).then(function (response) {
                        localStorage.setItem('jwt', response.data.token);
                        self.$store.state.jwt = response.data.token;
                        return self.$router.push({name: 'dashboard'});
                    }).catch(function (error) {
                        console.log(error);
                    });

                } else {
                    console.log("A email and password must be present");
                }
            }
        }
    }
</script>

<style scoped>

</style>
