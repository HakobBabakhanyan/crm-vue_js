<template>
    <div id="page_404" class="page-header error-page header-filter" style="background-image: url('/img/404.jpg')">
    <div class="content-center">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title">404</h1>
                <h2>Page not found :(</h2>
                <h4>Ooooups! Looks like you got lost.</h4>
                <router-link class="btn btn-default" :to="{name:'dashboard'}">
                    <span class="text-white">Dashboard</span>
                </router-link>
            </div>
        </div>
    </div>
    </div>
</template>

<script>

    export default {
        name: "error_404",
        mounted() {

        },
        methods: {
        }
    }
</script>

<style scoped>
    #page_404{
        position: fixed;
        z-index: 999999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100vh;
    }
</style>
