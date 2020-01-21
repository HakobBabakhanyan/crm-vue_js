<template>
    <!--is-focused-->
    <div  v-bind:class="{'is-filled':value,'has-danger':error}"  class="form-group  bmd-form-group">
        <label class="bmd-label-floating" :for="id" >{{ label }}</label>
        <textarea :id="id"
                  :required="required"
                  v-bind:class="{'is-invalid':error}"
                  v-on:input="updateValue($event.target.value)"
                  class="form-control"  rows="3">{{ value }}</textarea>
        <div class="invalid-feedback">
            {{ error }}
        </div>
    </div>
</template>

<script>
    export default {
        name: "VInput",
        props: {
            id: {
                type: String
            },
            label: {
                type: String,
                required: true
            },
            value: {
                type: [Number,String]
            },
            type:{
              type: String,
              default:'text'
            },
            required: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                error:false
            };
        },
        methods: {
            updateValue: function (value) {
                this.error = false;
                this.$emit('input', value)
            },
        }
    }
</script>

<style scoped>

</style>
