<template>
    <!--is-focused-->
    <div class="form-check my-2">
        <label class="form-check-label">
            <input class="form-check-input"
                   :id="id"
                   :type="type"
                   :required="required"
                   :value="value"
                   v-on:input="updateValue($event.target.checked)"
                   v-bind:checked="value"
            >
            <span class="form-check-sign">
               <span class="check"></span>
            </span>
            {{ label }}
        </label>
    </div>
</template>

<script>
    export default {
        name: "VCheckbox",
        props: {
            id: {
                type: String
            },
            label: {
                type: String,
                required: true
            },
            value: {
                type: [String,Boolean,Number]
            },
            type:{
              type: String,
              default:'checkbox'
            },
            required: {
                type: Boolean,
                default: false
            },
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
