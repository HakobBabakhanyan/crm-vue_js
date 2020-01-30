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
                                        <VInput v-model="item.rate" ref="rate" :label="'Rate'"/>
                                    </div>
                                     <div class="col-12 my-2">
                                            <label class="typo__label">Simple</label>
                                            <Multiselect
                                                v-model="selected"
                                                :options="options"
                                                :allow-empty="false"
                                                track-by="type"
                                                label="name"
                                                placeholder="Select Type"
                                            >
                                            </Multiselect>
                                        </div>
                                    <div class="col-12 mt-2">
                                        <VCheckbox v-model="item.status" ref="rate" :label="'Status'"/>
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
    import Tax from '../../../http/api/Tax'
    export default {
        name: "Currency",
        props: {
            edit: {
                default: false
            },
        },
        data: () => ({
            item: {},
            selected: null,
            options:[
                {
                    type: 1,
                    name:'Normal'
                },
                {
                    type: 2,
                    name:'Inclusive'
                },
                {
                    type: 3,
                    name:'Compound'
                }
            ]
        }),
        mounted() {
            this.$parent.auth = this.$store.state.jwt;
            let self = this;
            if (self.edit) {
                Tax.get({
                    id:self.$route.params.id
                }).then((data) => {
                    self.item = data.taxes.shift();
                    self.options.map(function (item) {
                        if(item.name === self.item.type){
                            self.selected = item;
                        }
                    });
                });
            }

        },
        methods: {
            update($event) {
                $event.preventDefault();
                let self = this;
                self.item.type = self.selected.type;
                Tax.sync({
                    item:self.item
                }).then((data) => {
                    self.$router.push({name: 'settings-taxes'});
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
