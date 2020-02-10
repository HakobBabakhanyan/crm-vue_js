<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div v-bind:class="{'card-header-success':!edit,'card-header-warning':edit}"
                             class="card-header">
                            <h4 v-if="!edit" class="card-title">Create </h4>
                            <h4 v-else class="card-title">Edit </h4>
                        </div>
                        <div class="card-body mt-5">
                            <form v-on:submit="update($event)" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <VInput v-model="item.name" ref="name" :label="'Name'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="item.code" ref="code" :label="'Code'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="item.rate" ref="rate" :label="'Rate'"/>
                                    </div>
                                    <div class="col-12">
                                        <VCheckbox v-model="item.status" ref="rate" :label="'Status'"/>
                                    </div>
                                    <div class="col-12">
                                        <VCheckbox v-model="item.default" ref="rate" :label="'Default'"/>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <span v-if="!edit">Create</span>
                                    <span v-else>Update</span>
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

    import CurrencyRequest from "../../../http/api/CurrencyRequest";

    export default {
        name: "Currency",
        props: {
            edit: {
                default: false
            },
        },
        data: () => ({
            item: {},
        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            if (self.edit) {
                CurrencyRequest.show(self.$route.params.id).then((data) => {
                    self.item = data.data;
                });
            }

        },
        methods: {
            update($event) {
                $event.preventDefault();
                let self = this;
                if (self.edit)  CurrencyRequest.update(self.item.id,{
                    item:self.item
                }).then((data) => {
                    self.$router.push({name: 'settings-currencies'});
                    self.$toastr.s(data.message);
                }); else
                CurrencyRequest.create({
                    item:self.item
                }).then((data) => {
                    self.$router.push({name: 'settings-currencies'});
                    self.$toastr.s(data.message);
                });
            },
        },
    }
</script>

<style scoped>

</style>
