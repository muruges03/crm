<template>
    <input class="appearance-none block w-full border border-gray-300 rounded shadow placeholder-gray-400 focus:outline-none focus:ring-cyan-300 focus:border-cyan-300 sm:text-xs" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['modelValue'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    })
</script>


<style>


[type='search'] {
       -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: #fff;
    /* border-color: #71717a; */
    /* border-width: 0px !important; */
    /* border-radius: 0px; */
    padding-top: 2px !important;
    padding-right: 4px !important;
    padding-bottom: 2px !important;
    padding-left: 4px !important;
    font-size: 12px !important;
    line-height: 1.5rem;
    /* padding: 2px 8px !important; */
    font-weight: 600;
    /* --tw-shadow: 0 0 #0000; */
}


[type='number'] {
       -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: #fff;
    /* border-color: #71717a; */
    /* border-width: 0px !important; */
    /* border-radius: 0px; */
    padding-top: 2px !important;
    padding-right: 0px !important;
    padding-bottom: 2px !important;
    padding-left: 5px !important;
    font-size: 12px !important;
    line-height: 1.5rem;
    /* padding: 2px 8px !important; */
    font-weight: 600;
    /* --tw-shadow: 0 0 #0000; */
}
.mixinputed{
    padding: 2px 8px !important;
    font-weight: 600 !important;
    font-size: 11px !important;
}
</style>
