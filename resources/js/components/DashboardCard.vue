<script setup>
import { computed } from 'vue'


defineProps({
  id: Number,
  title: String,
  value: String,
  icon: String,
})

const emit = defineEmits(['engineerData'])

  const colors = {
    blue: 'border-blue-500 bg-gradient-to-br from-blue-50 to-white',
    green: 'border-red-500 bg-gradient-to-br from-red-50 to-white',
    purple: 'border-purple-500 bg-gradient-to-br from-purple-50 to-white',
    orange: 'border-gray-500 bg-gradient-to-br from-gray-50 to-white'
  }
const getRandomColor = computed(() => {
  const colorKeys = Object.keys(colors)
  return colors[colorKeys[Math.floor(Math.random() * colorKeys.length)]]
})

</script>

<template>
  <div

    class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:-translate-y-1 border-l-4"
    :class="getRandomColor"
    @click="emit('engineerData', id)"
  >
    <div class="flex items-center justify-between">
      <div>
        <h3 class="text-lg font-medium text-gray-700 mb-1">{{ title }}</h3>
        <p class="text-3xl font-bold text-gray-900 tracking-tight">{{ value }}</p>
      </div>
    </div>
  </div>
</template>
