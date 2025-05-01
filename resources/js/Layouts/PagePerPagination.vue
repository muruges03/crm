<!-- This example requires Tailwind CSS v2.0+ -->
<template>

  <Listbox as="div" v-model="form.length">
    <div class="relative">
      <ListboxButton class="relative md:w-full w-20 bg-white border border-gray-300 rounded-md shadow-sm pl-2 pr-6  py-1 text-left cursor-default focus:outline-none">
        <span class="flex items-center">
          <!-- <span :aria-label="selected ? 'Online' : 'Offline'" :class="[selected ? 'bg-green-400' : 'bg-gray-200', 'flex-shrink-0 inline-block h-2 w-2 rounded-full']" /> -->
          <img src="/assets/list.png" class="opacity-50  h-4 w-4" >
          <span class="mx-1 md:ml-2 text-sm block truncate">{{ form.length }}</span>
        </span>
        <span class="absolute inset-y-0 right-0 flex items-center pr-1 pointer-events-none">
          <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </span>
      </ListboxButton>

      <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
          <ListboxOption as="template" v-for="person in people" :key="person.id" :value="person" v-slot="{ active, selected }">
            <li :class="[active ? 'text-white bg-cyan-500' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
              <div class="flex items-center">
                <!-- <span :class="[person ? 'bg-green-400' : 'bg-gray-200', 'flex-shrink-0 inline-block h-2 w-2 rounded-full']" aria-hidden="true" /> -->
                <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                  {{ person }}
                  <!-- <span class="sr-only"> is {{ person.online ? 'online' : 'offline' }}</span> -->
                </span>
              </div>

              <span v-if="selected" :class="[active ? 'text-white' : 'text-gray-900', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                <CheckIcon class="h-5 w-5" aria-hidden="true" />
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
   <div class="block flex md:px-2">
    <div class="relative w-full">
        <div class="flex absolute inset-y-0 left-0 items-center pl-2 pointer-events-none">
            <svg class="w-4 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
        </div>
        <input
            name="table_search"
            v-model="form.search"
            type="search"
            autocomplete="off"
            style="padding:2px 4px 2px 30px !important"
            class=" focus:ring-cyan-300 focus:border-cyan-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded"
            placeholder="Search ..."
        />
    </div>

    </div>
</template>

<script >
import { ref, defineComponent } from 'vue'
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'

const people = [
  "10", '25', '50'
]


export default defineComponent({
    components: {
        Listbox,
        ListboxButton,
        ListboxLabel,
        ListboxOption,
        ListboxOptions,
        CheckIcon,
        SelectorIcon,
    },

    props:{
        url: String,

    },

    data() {
        return {
            form:{
                length: 10,
                search: '',
            },
            people,
        }
    },
     watch: {
        form: {
            deep: true,
            handler: throttle(function() {
                this.$inertia.get(this.url, pickBy(this.term), { preserveState: true })
            }, 150),
        },
    },
});
</script>
