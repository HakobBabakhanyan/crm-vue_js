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
                               <div class="row">
                                   <div class="col-6">
                                       <VInput v-model="item.name" ref="name" :label="'Name'"/>
                                   </div>
                                   <div class="col-12">
                                       <VTextarea v-model="item.description" ref="description" :label="'Description'"/>
                                   </div>
                               </div>
                                <div class="row">
                                    <div class="col-6">
                                        <VInput v-model="item.sale_price" :type="'number'" ref="sale_price" :label="'Sale price'"/>
                                    </div>
                                    <div class="col-6">
                                        <VInput v-model="item.purchase_price" :type="'number'" ref="sale_price" :label="'Purchase Price'"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <Multiselect
                                            v-model="item.category"
                                            :options="options"
                                            :internal-search="false"
                                            :loading="isLoading"
                                            @input="updateSelect"
                                            @search-change="asyncFind"
                                            track-by="id"
                                            label="name"
                                            placeholder="Select"
                                        >
                                        </Multiselect>
                                    </div>
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

    export default {
        name: "ItemCategory",
        props:{
            edit: {
                default:false
            },
        },
        data: () => {
            return {
                item:{},
                options:[],
                selected:[],
                isLoading:false,
            }
        },
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            if(self.edit){
                this.$http.get(this.$const.URL.ITEM_GET + self.$route.params.id, {
                    params: {
                        token: self.$store.state.jwt,
                    }
                }).then((response) => {
                    self.item = response.data.item;
                });
            }

        },
        methods: {
            update($event) {
                $event.preventDefault();
                let self = this;
                console.log(self.type);
                this.$http.post(this.$const.URL.ITEM_SYNC, {
                    token: localStorage.getItem('jwt'),
                    'item': self.item,
                }).then((response) => {
                    self.$router.push({name: 'item-index'});
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
            asyncFind (query) {
                let self = this;
                this.isLoading = true;
                this.$http.get(self.$const.URL.ITEM_CATEGORIES_SEARCH, {
                    params: {
                        token: self.$store.state.jwt,
                        name: query,
                    }
                }).then(response => {
                    self.options = response.data.categories
                    self.isLoading = false
                })
            },
            updateSelect(item) {
                this.item.categories_id = item.id;
            },
        },
    }
</script>

<style scoped>

</style>
