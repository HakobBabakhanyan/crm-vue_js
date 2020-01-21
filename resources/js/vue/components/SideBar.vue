<template>
    <div class="sidebar" data-color="purple" data-background-color="white">
        <div class="logo">
            <router-link class="simple-text logo-normal" :to="{ name:'home' }">
                Crm
            </router-link>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <router-link tag="li" :to="{ name: 'dashboard' }" class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </router-link>
                <router-link tag="li" :to="{ name: 'profile' }" class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="material-icons">person_outline</i>
                        <p>Profile</p>
                    </a>
                </router-link>
                <li class="nav-item ">
                    <a class="nav-link collapsed"  v-on:click="collapse = !collapse" href="javascript:void(0)"
                       :aria-expanded="collapse">
                        <span class="sidebar-normal">
                      <b class="caret"></b>
                    </span>
                        <i class="material-icons">shopping_cart</i>
                        <p>Items</p>
                    </a>
                    <div class="collapse" v-bind:class="{ 'show':collapse }" style="">
                        <ul class="nav">
                            <router-link tag="li" :to="{ name: 'item-index' }" class="nav-item">
                                <a class="nav-link" href="javascript:void(0)">
                                    <i class="material-icons">view_module</i>
                                    <p>Items</p>
                                </a>
                            </router-link>
                            <router-link tag="li" :to="{ name: 'item-categories-index' }" class="nav-item">
                                <a class="nav-link" href="javascript:void(0)">
                                    <i class="material-icons">list</i>
                                    <p>Categories</p>
                                </a>
                            </router-link>
                        </ul>
                    </div>
                </li>
                <router-link tag="li" :to="{ name: 'companies' }" class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="material-icons">store_mall_directory</i>
                        <p>Companies</p>
                    </a>
                </router-link>
                <router-link tag="li" :to="{ name: 'persons' }" class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="material-icons">person</i>
                        <p>Persons</p>
                    </a>
                </router-link>

                <router-link tag="li" :to="{ name: 'customers' }" class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="material-icons">group</i>
                        <p>Customers</p>
                    </a>
                </router-link>

            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "side-bar",
        mounted() {

        },
        data() {
            return {
                collapse: false
            }
        }
    }
</script>

<style scoped>
    .collapsed {
        position: relative;
    }
</style>
