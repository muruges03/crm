<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  label: String,
  modelValue: [String, Number],
  options: Array,
});
const emit = defineEmits(["update:modelValue"]);
</script>

<template>
  <div>
    <label class=" !text-[16px] block text-gray-700 !font-medium">{{ label }}</label>
    <select
      :value="modelValue"
      @change="emit('update:modelValue', $event.target.value)"
      class="w-full mt-1 px-4 py-2 border !text-[16px] block text-gray-700 !font-medium rounded-lg focus:ring focus:ring-[#a3b5d3]"
    >
    <option value="" disabled selected hidden>{{ placeholder }}</option>
      <option v-for="option in options" :key="option.value" :value="option.value">
        {{ option.label }}
      </option>
    </select>
  </div>
</template>
