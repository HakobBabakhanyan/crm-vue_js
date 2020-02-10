<template>
    <div class="container">
        <div v-bind:class="{'row':vertical,'card':!vertical}" class="">
            <div v-bind:class="{'col-3 m-0':vertical}" class="card-header card-header-tabs card-header-primary">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <span v-if="title" class="nav-tabs-title">{{  title  }}</span>
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li v-bind:class="{'w-100 my-2':vertical,}" class="nav-item" v-for="steep in steppers">
                                <a class="nav-link" href="javascript:void(0)"
                                   v-bind:class="{'active':(tabs === steep)}"
                                   v-on:click="tabs = steep"
                                   data-toggle="tab">
                                    {{ steep.label }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div v-bind:class="{'col-9 m-0':vertical}" class="card-body">
                <div class="tab-content">
                    <div v-for="steep in steppers" class="tab-pane" v-bind:class="{'active':(tabs === steep)}" >
                       <slot :name="steep.id">
                       </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Stepper",
        props:{
            vertical:{
                default:false,
                type:Boolean
            },
            title:{
                default:'',
                type:String
            },
            steppers:{
                default:[],
                type:Array
            }
        },
        data: ()=>({
            tabs:null
        }),
        mounted(){
            this.tabs = this.steppers[0]
        }
    }
</script>

<style scoped>

</style>
