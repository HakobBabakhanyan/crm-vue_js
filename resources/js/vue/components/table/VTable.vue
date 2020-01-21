<template>
    <table class="table table-hover">
        <thead class="">
        <th v-for="(item,index) in thead">
            {{ item }}
        </th>
        <th class="text-right   ">action</th>
        </thead>
        <tbody>
        <tr v-for="(item, index) in items">
            <td v-for="(i,index) in thead">
                {{ item[index] }}
            </td>
            <td class="td-actions text-right">
                <router-link v-if="edit_route" class="btn btn-success btn-link"
                             :to="{name:edit_route,params:{id:item.id} }">
                    <i class="material-icons">edit</i>
                </router-link>
                <button v-on:click="$emit('remove',$event,item[delete_item])"
                        type="button" class="btn btn-danger btn-link">
                    <i class="material-icons">delete</i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "VTable",
        props:{'items':{
            default:[]
            },'thead':{
                default:[]
            },'edit_route':{
                default:false
            },'delete_item':{
                default:'id'
            }
            },
        data:() => ({

        })
    }
</script>

<style scoped>

</style>
