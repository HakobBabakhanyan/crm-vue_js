<template>
    <div class="sidebar" data-color="purple" data-background-color="white">
        <div class="logo">
            <router-link class="simple-text logo-normal" :to="{ name:'home' }">
                Crm
            </router-link>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <router-link tag="li" v-for="(data,name) in side_bar"
                             :to="{ name: name }"
                             v-bind:key="name"
                             v-if="!data.children"
                             class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">
                        <i :class="data.icon"></i>
                        <p>{{ data.name }}</p>
                    </a>
                </router-link>
                <SideBarCollapse v-else  :data="data"/>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        name: "side-bar",
        data:() => ({
            side_bar:{
                'dashboard':{
                    'icon':'fa fa-tachometer',
                     'name':'Dashboard'
                },'profile':{
                    'icon':'fa fa-user',
                     'name':'Profile'
                },'companies':{
                    'icon':'fa fa-building',
                     'name':'Companies'
                },'persons':{
                    'icon':'fa fa-user',
                     'name':'Persons'
                },'customers':{
                    'icon':'fa fa-users',
                     'name':'Customers'
                },'items':{
                    'name':'Items',
                    'icon':'fa fa-cubes',
                    'children':{
                        'item-index':{
                            'icon':'fa fa-angle-double-right',
                            'name':'Items'
                        },
                        'item-categories-index':{
                            'icon':'fa fa-angle-double-right',
                            'name':'Categories'
                        }
                    }
                },'incomes':{
                    'name':'Incomes',
                    'icon':'fa fa-dollar',
                    'children':{
                        'incomes-invoices-index':{
                            'icon':'fa fa-angle-double-right',
                            'name':'Invoices'
                        },'incomes-categories-index':{
                            'icon':'fa fa-angle-double-right',
                            'name':'Categories'
                        }
                    }
                },'settings':{
                    'name':'Settings',
                    'icon':'fa fa-cogs',
                    'children':{
                        'settings-currencies':{
                            'icon':'fa fa-angle-double-right',
                            'name':'Currencies'
                        },'settings-taxes':{
                            'icon':'fa fa-angle-double-right',
                            'name':'Taxes'
                        },
                    },

                }
            }
        }),
        mounted() {
        },
        methods:{
             collapse(index) {
                this.collapse_data.index = !this.collapse_data.index;
                return this.collapse_data.index
            }
        }

    }
</script>

<style scoped>
    .collapsed {
        position: relative;
    }
</style>
