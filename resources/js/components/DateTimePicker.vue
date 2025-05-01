<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  modelValue: String,
  label: String,
  error:String
});

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
  <div class="flex flex-col">
    <label v-if="label" class="">{{ label }}</label>
    <input
      type="datetime-local"
      :value="modelValue"
      @input="emit('update:modelValue', $event.target.value)"
        class="w-full px-4 py-2 border border-gray-300 bg-white h-8 !text-sm rounded-md  !text-gray-500 shadow-sm focus:ring focus:ring-[#a3b5d3]"
    />
    <span v-if="error" class="text-red-500 text-sm">{{ error }}</span>
</div>
</template>
