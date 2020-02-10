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
                        <p>
                            <FontAwesomeIcon :icon="data.icon" />
                            {{ data.name }}</p>
                    </a>
                </router-link>
                <SideBarCollapse v-else :data="data"/>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        name: "side-bar",
        data: () => ({
            side_bar: {
                'dashboard': {
                    'icon': 'tachometer-alt',
                    'name': 'Dashboard'
                }, 'companies': {
                    'icon': 'building',
                    'name': 'Companies'
                }, 'persons': {
                    'icon': 'user',
                    'name': 'Persons'
                }, 'items': {
                    'name': 'Items',
                    'icon': 'cubes',
                    'children': {
                        'item-index': {
                            'icon': 'angle-double-right',
                            'name': 'Items'
                        },
                        'item-categories-index': {
                            'icon': 'angle-double-right',
                            'name': 'categories'
                        }
                    }
                }, 'incomes': {
                    'name': 'Incomes',
                    'icon': 'dollar-sign',
                    'children': {
                        'incomes-invoices-index': {
                            'icon': 'angle-double-right',
                            'name': 'Invoices'
                        }, 'incomes-categories-index': {
                            'icon': 'angle-double-right',
                            'name': 'categories'
                        }, 'customers': {
                            'icon': 'users',
                            'name': 'Customers'
                        }
                    }
                },
                'banking': {
                    'name': 'Banking',
                    'icon': 'piggy-bank',
                    'children': {
                        'banking-accounts': {
                            'icon': 'angle-double-right',
                            'name': 'Accounts'
                        },
                    },
                },
                'settings': {
                    'name': 'Settings',
                    'icon': 'cogs',
                    'children': {
                        'profile': {
                            'icon': 'user',
                            'name': 'Profile'
                        },
                        'settings-currencies': {
                            'icon': 'angle-double-right',
                            'name': 'Currencies'
                        }, 'settings-taxes': {
                            'icon': 'angle-double-right',
                            'name': 'Taxes'
                        },
                    },

                }
            }
        }),
        mounted() {
        },
        methods: {
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
