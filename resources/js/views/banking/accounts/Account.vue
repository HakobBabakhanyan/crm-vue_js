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
                                        <VInput v-model="item.number" ref="number"
                                                :type="'number'"
                                                :label="'Number'"/>
                                    </div>
                                    <div class="col-6 my-3">
                                        <VueSelect
                                            v-model="selected"
                                            :options="options"
                                            :allow-empty="false"
                                            label="name"
                                            placeholder="Select currency"
                                        >
                                        </VueSelect>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="item.balance" ref="balance"
                                                :type="'number'"
                                                :label="'Opening Balance'"/>
                                    </div>

                                    <div class="col-md-6">
                                        <VInput v-model="item.bank_name" ref="name" :label="'Bank Name'"/>
                                    </div>
                                    <div class="col-md-6">
                                        <VInput v-model="item.bank_phone" ref="name" :label="'Bank Phone'"/>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <VTextarea v-model="item.bank_address" ref="rate" :label="'Status'" />
                                    </div>
                                    <div class="col-12 mt-2">
                                        <VCheckbox v-model="item.status" ref="rate" :label="'Status'"/>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <VCheckbox v-model="item.default" ref="rate" :label="'Default'"/>
                                    </div>

                                </div>
                                <div class="container text-right">
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <span v-if="!edit">Create</span>
                                        <span v-else>Update</span>
                                    </button>
                                </div>

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
    import BankingAccountRequest from "../../../http/api/BankingAccountRequest";

    export default {
        name: "BankingAccount",
        props: {
            edit: {
                default: false
            },
        },
        data: () => ({
            item: {},
            selected: null,
            options: []
        }),
        mounted() {
            let self = this;
            CurrencyRequest.get().then( r=>{
                self.options = r.data
            } );
            if (self.edit) {
                BankingAccountRequest.show(self.$route.params.id).then((r) => {
                    self.item = r.data;
                    self.selected = r.data.currency;
                });
            }
        },
        methods: {
            update($event) {
                $event.preventDefault();
                let self = this;
                self.item.currency = self.selected.id;
                if (self.edit)
                    BankingAccountRequest.update(self.item.id, {
                        item: self.item
                    }).then((data) => {
                        self.$router.push({name: 'banking-accounts'});
                        self.$toastr.s(data.message);
                    });
                else BankingAccountRequest.create({
                    item: self.item
                }).then((data) => {
                    self.$router.push({name: 'banking-accounts'});
                    self.$toastr.s(data.message);
                });
            },
        },
    }
</script>

<style scoped>

</style>
