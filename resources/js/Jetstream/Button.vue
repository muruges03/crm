<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-[#084BB8] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#629BF8] active:bg-[#629BF8] focus:outline-none  focus:ring focus:ring-[#3B82F6] disabled:opacity-25 transition">
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
