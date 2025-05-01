<template>
    <button :type="type" class="button-green md:inline-flex justify-center py-1 px-4 font-medium rounded-md text-gray-800 hover:bg-green-50">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'

    import AppLayout from '@/Layouts/AppLayout.vue'

    export default defineComponent({
        components: {
        AppLayout,
    },
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    })
</script>
<style>
.button-green{
    background:linear-gradient(to bottom,#49749c,#49749c) repeat-x #fefefe;
    border:.11em solid rgb(172, 172, 172);
    color:white;
}

</style>
