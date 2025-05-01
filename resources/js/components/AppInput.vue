<script setup>
import { defineProps } from "vue";

const props = defineProps({
  label: String,
  modelValue: [String, Number],
  type: {
    type: String,
    default: "text",
  },
  placeholder: String,
  error:String
});
const emit = defineEmits(["update:modelValue"]);
</script>

<template>
  <div>
    <label class="block text-gray-700 font-medium">{{ label }}</label>
    <input
      :type="type"
      :value="modelValue"
      @input="emit('update:modelValue', $event.target.value)"
      class="w-full mt-1 px-4 py-2 border rounded-md focus:ring text-sm focus:ring-[#a3b5d3]  h-8 border-gray-300 text-gray-700 font-medium"
      :placeholder="placeholder"
    />
    <span v-if="error" class="text-red-500 text-sm">{{ error }}</span>

  </div>
</template>
