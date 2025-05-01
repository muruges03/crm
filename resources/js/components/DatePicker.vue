<script setup>
import { defineProps, defineEmits, computed } from "vue";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const props = defineProps({
  modelValue: [String, Array, Date],
  label: String,
  error: String,
  placeholder: {
    type: String,
    default: "Select Date",
  },
  multiple: {
    type: Boolean,
    default: false,
  },
  customClass: [String, Object], // Accept string or object
});

const emit = defineEmits(["update:modelValue"]);

const convertToDate = computed(() => {
  if (!props.modelValue) return null;
  if (!props.multiple) {
    return typeof props.modelValue === "string" ? new Date(props.modelValue) : props.modelValue;
  }
  return Array.isArray(props.modelValue)
    ? props.modelValue.map(date => (typeof date === "string" ? new Date(date) : date))
    : [];
});

const computedClass = computed(() => {
  if (typeof props.customClass === "string") return props.customClass;
  return props.customClass ? Object.keys(props.customClass).filter(key => props.customClass[key]).join(' ') : '';
});
</script>

<template>
  <div class="block text-sm font-medium text-gray-700">
    <label v-if="label">{{ label }}</label>
    <Datepicker
      :model-value="convertToDate"
      :placeholder="placeholder"
      autoApply
      :class="computedClass"
      :enableTimePicker="false"
      :range="multiple"
      @update:modelValue="emit('update:modelValue', $event)"
    />
    <span v-if="error" class="text-red-500 text-sm">{{ error }}</span>
  </div>
</template>
