<template>
    <div class="wrapper" v-bind:class="{'nav-open':nav_open}">
        <side-bar v-if="auth"/>
        <div v-bind:class="{'main-panel':auth}">
            <nav-bar v-if="auth"/>
            <div class="content">
                <router-view/>
            </div>
            <v-footer v-if="auth"/>
            <div v-if="nav_open" v-on:click="nav_open = !nav_open" class="close-layer visible"></div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "App",
        computed: {
            ...mapGetters([
                'jwt',
            ])
        },
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
