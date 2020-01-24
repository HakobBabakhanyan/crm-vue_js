<template>
    <li  class="nav-item" v-bind:class="{'active':collapse }">
        <a class="nav-link collapsed"
           data-toggle="collapse"
           v-on:click="collapse = !collapse" href="javascript:void(0)"
           :aria-expanded="collapse">

            <i :class="data.icon"></i>
            <p>
                {{ data.name }}
                <b class="caret"></b>
            </p>
        </a>
        <div class="collapse"  v-bind:class="{ 'show':collapse }" style="">
            <ul class="nav">
                <router-link tag="li" v-for="(item,index) in data.children"
                             v-if="!item.children"
                             :to="{ name: index }"
                             v-bind:key="index"
                             class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">
                        <i :class="item.icon"></i>
                        <p>{{ item.name }}</p>
                    </a>
                </router-link>
                <SideBarCollapse v-else  :data="item"/>
            </ul>
        </div>
    </li>
</template>
<script>
    export default {
        name: "SideBarCollapse",
        props:['data'],
        data:() => ({
            collapse:false
        }),
        mounted(){
            for(let key in this.data.children){
                if(key === this.$route.name) this.collapse = true;
            };
        }
    }
</script>

<style scoped>

</style>
