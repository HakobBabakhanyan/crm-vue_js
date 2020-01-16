<template>
    <div class="wrapper" v-bind:class="{'nav-open':nav_open}">
        <side-bar v-if="auth"/>
        <div v-bind:class="{'main-panel':auth}">
            <nav-bar v-if="auth"/>
            <div class="content">
                <router-view/>
            </div>
            <v-footer v-if="auth"/>
        </div>
    </div>
</template>

<script>
    import "../components/NavBar";
    import NavBar from "../components/NavBar";
    import SideBar from "../components/SideBar";
    import VFooter from "../components/Footer";
    import Login from "./auth/Login";
    import {mapGetters} from 'vuex';

    export default {
        name: "App",
        computed: {
            ...mapGetters([
                'jwt',
            ])
        }
        ,
        components: {Login, VFooter, SideBar, NavBar},
        data() {
            return {
                auth: this.$store.jwt,
                nav_open:false
            }
        },
    }
</script>

<style scoped>

</style>
