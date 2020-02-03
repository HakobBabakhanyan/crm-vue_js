<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div  v-bind:class="{'card-header-success':!edit,'card-header-warning':edit}" class="card-header">
                            <h4 v-if="!edit" class="card-title">Create </h4>
                            <h4 v-else class="card-title">Edit </h4>
                        </div>
                        <div class="card-body mt-5">
                            <form v-on:submit="update($event)" action="">
                                <div class="col-md-6">
                                    <VInput v-model="category.name" ref="name" :label="'Name'"/>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <span v-if="!edit" >Create</span>
                                    <span v-else >Update</span>
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

    import ItemCategory from "../../../http/api/ItemCategory";

    export default {
        name: "ItemCategory",
        props:{
            edit: {
                default:false
            },
        },
        data: () => {
            return {
                category:{},
            }
        },
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            if(self.edit){
                ItemCategory.get({
                    id:self.$route.params.id
                }).then((data) => {
                    self.category = data.category;
                });
            }

        },
        methods: {
            update($event) {
                $event.preventDefault();
                let self = this;
                console.log(self.type);
                ItemCategory.sync({
                    category: self.category
                }).then((data) => {
                    self.$router.push({name: 'item-categories-index'});
                    self.$toastr.s(data.message);
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
        },
    }
</script>

<style scoped>

</style>
