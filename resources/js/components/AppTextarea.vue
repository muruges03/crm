<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  label: String,
  modelValue: String,
  placeholder: String,
});
const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <div>
      <label class="block text-gray-700 font-medium">{{ label }}</label>
      <textarea
        :value="modelValue"
        @input="emit('update:modelValue', $event.target.value)"
        class="w-full mt-1  block text-gray-700 !font-medium px-4 py-2 border custom-placeholder rounded-lg focus:ring focus:ring-[#a3b5d3] md:text-xl "
        :placeholder="placeholder"
      ></textarea>
    </div>
  </template>

<style scoped>
.custom-placeholder::placeholder {
  font-size: 13px;
  color: #a0aec0;
}
</style>
