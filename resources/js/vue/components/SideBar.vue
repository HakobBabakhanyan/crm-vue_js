<template>
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="/img/sidebar-1.jpg">
        <div class="logo">
            <router-link class="simple-text logo-normal" :to="{ name:'home' }" >
                Crm
            </router-link>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <router-link tag="li" :to="{ name: 'dashboard' }" class="nav-item">
                    <a class="nav-link"  href="javascript:void(0)">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </router-link>
                <router-link tag="li" :to="{ name: 'profile' }" class="nav-item">
                    <a class="nav-link"  href="javascript:void(0)">
                        <i class="material-icons">person</i>
                        <p>Profile</p>
                    </a>
                </router-link>
                <router-link tag="li" :to="{ name: 'companies' }" class="nav-item">
                    <a class="nav-link"  href="javascript:void(0)">
                        <i class="material-icons">store_mall_directory</i>
                        <p>Companies</p>
                    </a>
                </router-link>
<!--                <li class="nav-item ">-->
<!--                    <a class="nav-link collapsed" v-on:click="collapse = !collapse" href="javascript:void(0)" :aria-expanded="collapse">-->
<!--                        <span class="sidebar-mini"> MLT </span>-->
<!--                        <span class="sidebar-normal"> Multi Level Collapse-->
<!--                      <b class="caret"></b>-->
<!--                    </span>-->
<!--                    </a>-->
<!--                    <div class="collapse" v-bind:class="{ 'show':collapse }" style="">-->
<!--                        <ul class="nav">-->
<!--                            <li class="nav-item ">-->
<!--                                <a class="nav-link" href="#0">-->
<!--                                    <span class="sidebar-mini"> E </span>-->
<!--                                    <span class="sidebar-normal"> Example </span>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </li>-->
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "side-bar",
        mounted() {

        },
        data(){
            return {
                collapse:false
            }
        }
    }
</script>

<style scoped>
    .collapsed {
       position: relative;
    }
</style>
