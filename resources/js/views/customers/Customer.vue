<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Create Customer</h4>
                        </div>
                        <div class="card-body mt-5">
                            <form v-on:submit="update($event)" action="">
                                <div class="row">
                                    <div class="col-12 my-2">
                                        <label class="typo__label">Simple</label>
                                        <Multiselect
                                            v-model="person.customer"
                                            :options="options"
                                            @input="updateSelect"
                                            track-by="id"
                                            label="name"
                                            placeholder="Select"
                                        >
                                        </Multiselect>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <span>Create Customers</span>
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

    import Customers from "../../http/api/Customers";

    export default {
        name: "Customer",
        props:{
            type: {
                default:'COMPANY'
            },
        },
        data: () => {
            return {
                person: {
                    info: {}
                },
                selected: null,
                options: [],
            }
        },
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
                Customers.selects( {
                        type: self.type
                }).then((response) => {
                    self.options = response.items;
                });
        },
        methods: {
            update($event) {
                $event.preventDefault();
                let self = this;
                console.log(self.type);
                Customers.create({
                    'selected': self.selected,
                    'type': self.type,
                }).then((response) => {
                    self.$router.push({name: 'customers'});
                    self.$toastr.s(response.message);
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
            updateSelect(item) {
                this.selected = item.id;
            },
        },
    }
</script>

<style scoped>

</style>
