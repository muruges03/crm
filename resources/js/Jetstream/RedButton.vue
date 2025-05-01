<template>
    <button :type="type" class=" md:inline-flex justify-center py-1 px-4 text-md font-medium rounded-md text-red-800 hover:bg-red-50">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    })
</script>
<style>
button{
    /* background:linear-gradient(to bottom,rgb(214, 127, 127),#ff6565) repeat-x #fefefe; */
    border:.11em solid #ccc
}

</style>
