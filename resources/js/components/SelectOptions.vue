<script setup>
import { defineProps, defineEmits, computed } from "vue";
import Multiselect from "@suadelabs/vue3-multiselect";

const props = defineProps({
  label: String,
  modelValue: [String, Number, Object],
  options: Array,
  show: String,
  error: String,
  placeholder: String,
  customClass: String,
});

const emit = defineEmits(["update:modelValue"]);

const selectedOption = computed(() => {
  return props.options.find((opt) => opt.id === props.modelValue) || null;
});
const computedClass = computed(() => {
  if (typeof props.customClass === "string") return props.customClass;
});
</script>

<template>
  <div>
    <label class="block text-gray-700 font-medium">{{ label }}</label>
    <div   :class="computedClass">
        <Multiselect
      v-model="selectedOption"
      :options="options"
      track-by="id"
      :label="show"
      :placeholder="placeholder"
      :searchable="true"
      :allow-empty="true"
      :multiple="false"

      @update:modelValue="emit('update:modelValue', $event?.id || null)"
      class="mt-1 border !block rounded-lg focus:ring focus:ring-red-700"
    >
    </Multiselect>
    </div>


    <p v-if="error" class="text-red-500 text-sm">{{ error }}</p>
  </div>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>
