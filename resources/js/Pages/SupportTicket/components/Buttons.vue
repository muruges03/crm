<script setup>
import { defineProps, defineEmits } from "vue";

const emit = defineEmits([ "back", "submit"]);
</script>

<template>
    <div class="flex flex-row-reverse justify-between mt-4">

        <button  type="submit"
            class="bg-indigo-900 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
            Submit
        </button>

        <button  type="button" @click="emit('back')"
            class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">
            Back
        </button>
    </div>
</template>
