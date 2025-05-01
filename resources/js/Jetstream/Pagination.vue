<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, k) in links" v-bind:key="k">
        <div v-if="link.url === null"  class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
        <a v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-blue-600 hover:text-white focus:bg-blue-600" :class="{ 'bg-blue-700 text-white': link.active }" v-bind:href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    links: Array,
  },
}
</script>
<style>
.bg-blue-700{
    background-color:rgb(21, 118, 165);
}

.hover\:bg-blue-600:hover.bg-blue-600{
    background-color:#75a9fc;
}


</style>
