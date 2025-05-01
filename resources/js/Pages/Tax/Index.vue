<template>
 <app-menu />
    <div class="lg:pl-64 flex flex-col">
        <div class="p-5 ">
            <div class="divide-y-2">
                <div class="mt-4 sm:mt-0 md:px-6 flex justify-between  ">
                    <h2 class="text-xl font-semibold flex">
                        <img src="/assets/tax.png" class='h-6 w-6 mr-3'>
                        Tax
                    </h2>
                     <inertia-link class="ml-2 text-white shadow-lg rounded-full bg-[#4989a8]" :href="route('tax.create')">
                        <button type="button" class="px-2 py-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </inertia-link>
                </div>
            </div>

            <div class="  px-4 bg-white sm:px-6 lg:px-8">
                <div class="mt-10 space-y-12 lg:space-y-0  md:grid md:grid-cols-3 gap-6">
                    <div v-for="(taxs, index) in tax.data" :key="taxs.id" class="relative p-4 bg-white border border-gray-200 rounded shadow-md flex flex-col hover:bg-indigo-100">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900"><a  @click="openEditTax(taxs)">{{ taxs.tax_name }}</a></h3>
                            <div class="flex justify-between">
                                <p v-if="taxs.parent_id == null" class="absolute top-0 py-1 px-2 bg-[#4989a8] rounded-md text-sm  uppercase tracking-wide text-white transform -translate-y-1/2">Parent Tax</p>
                              <inertia-link class="absolute top-0 right-0 py-1 px-2 bg-[#4989a8] rounded-md text-sm  mr-2 uppercase tracking-wide text-white transform -translate-y-1/2 hover:bg-blue-500" :href="route('tax.edit', taxs.id)" >
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                    </svg>
                                </inertia-link>
                            </div>

                            <p class="mt-2 flex justify-between items-baseline text-gray-900">
                                <span class="text-md font-medium tracking-tight"><a  @click="openEditTax(taxs)">{{taxs.tax_amount}}</a> %</span>
                                <span class=" text-sm py-1 px-2 bg-green-100 rounded-full font-medium"><a  @click="openEditTax(taxs)">{{taxs.tax_type}}</a></span>
                            </p>
                        </div>
                        <!-- <div class="lg:flex">


                        </div> -->
                    </div>
                </div>
            </div>

        </div>
        <pagination class="py-4 px-2" :links="tax.links" />
    </div>

</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Pagination from '@/Jetstream/Pagination'
    import {TrashIcon} from '@heroicons/vue/outline'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import Swal from 'sweetalert2'
    import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';
    import axios from 'axios'
    import Multiselect from '@suadelabs/vue3-multiselect'
    import { CheckIcon } from '@heroicons/vue/outline'



    export default ({
          mixins: [InteractsWithQueryBuilder],
        components: {
            AppLayout,CheckIcon,
            AppMenu,
            Welcome,
            Pagination,
            TrashIcon,
            JetButton,
            GrayButton,
            Table: Tailwind2.Table,Multiselect,axios
        },
        remember: 'form',
        props: [
            'tax',
            // "filters",
            // "firstItem",
            // "lastItem",
            // "total",
        ],
        data() {
        return {
        }
    },
    methods: {
        destroy(id) {
            this.taxid=id;
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

            if (result.isConfirmed) {
                this.$inertia.get(this.route('tax.destroy', this.taxid))
            }
            })
        },
    },
    mounted() {
    },
 })
</script>
