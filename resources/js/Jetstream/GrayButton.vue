<template>
    <button :type="type" class="graybutton md:inline-flex justify-center py-1 px-4 text-md font-medium rounded-md text-gray-800 hover:bg-gray-50">
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
.graybutton{
    background:linear-gradient(to bottom,#eee,#fefefe) repeat-x #fefefe;
    border:.11em solid #ccc
}
</style>
