<template>
<app-menu />

    <div class="lg:pl-64 flex flex-col ">
        <div class="py-4 px-4 md:px-6">
            <div class="mt-4 sm:mt-0 md:flex justify-between md:px-5">
                <h2 class="text-lg flex font-semibold ">
                    <img src="/assets/customer.png" class="h-6 w-6 mr-3">
                    CUSTOMER LIST
                </h2>
                <div class="block flex ">
                    <jet-input
                        name="table_search"
                        v-model="term"
                        @keyup="search"
                        type="text"
                        autocomplete="off"

                        placeholder="Search Legal Name ..."
                    />
                    <inertia-link class="ml-2 text-white shadow-lg rounded-full bg-[#4989a8]" :href="route('patron.create')" v-if="$page.props.auth.user.can['create_patroncontact']==true">
                        <button type="button" class="px-2 py-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </inertia-link>
                </div>
            </div>
        </div>

        <ul role="list" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4 p-5">
            <li v-for="patron in patrons.data" :key="patron.patron_id" class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200 border hover:bg-indigo-50" style="hover:border:5px inset">
                <div class="w-full flex items-center justify-between px-2 py-2 space-x-6">
                    <div class="flex-1 truncate">
                    <div class="flex items-center space-x-3">
                        <h3 class="text-gray-900 text-sm font-medium truncate"><inertia-link  v-bind:href="route('patron.edit', patron.patron_id)" >{{ patron.legal_name }}</inertia-link></h3>

                    </div>
                    <p class="mt-1 text-gray-500 text-sm truncate"><inertia-link  v-bind:href="route('patron.edit', patron.patron_id)" >{{ patron.gstin }}</inertia-link></p>
                    <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full"><inertia-link  v-bind:href="route('patron.edit', patron.patron_id)" >{{ patron.patron_type }}</inertia-link></span>
                    </div>
                    <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" src="/assets/avatar_customer.svg" alt="" />
                </div>
                <div>
                    <div class="-mt-px flex divide-x divide-gray-200">
                        <div class="w-0 flex-1 flex">
                            <a :href="`mailto:${patron.email}`" :title="patron.email" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-2 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500 hover:bg-indigo-100">
                            <MailIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                            </a>
                        </div>
                        <div class="-ml-px w-0 flex-1 flex">
                            <a :href="`tel:${patron.mobile}`" :title="patron.mobile" class="relative w-0 flex-1 inline-flex items-center justify-center py-2 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500 hover:bg-indigo-100">
                            <PhoneIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                            </a>
                        </div>
                        <div class="-ml-px w-0 flex-1 flex">
                            <inertia-link class="relative w-0 flex-1 inline-flex items-center justify-center py-2 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500 hover:bg-indigo-100" v-bind:href="route('patron.edit', patron.patron_id)" v-if="$page.props.auth.user.can['edit_patroncontact']==true">
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:29px;">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="md:flex justify-between md:px-5">
            <div class="">
                <p> Showing {{firstItem}} to {{lastItem}} of {{total}} Results</p>
            </div>
            <Pagination :links="patrons.links"  />
        </div>

    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Pagination from '@/Jetstream/Pagination'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';
    import Swal from 'sweetalert2'
    import { MailIcon, PhoneIcon } from '@heroicons/vue/solid'

//     const people = [
//   {
//     name: 'Jane Cooper',
//     title: 'Regional Paradigm Technician',
//     role: 'Admin',
//     email: 'janecooper@example.com',
//     telephone: '+1-202-555-0170',
//     imageUrl:
//       'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
//   },
//   // More people...
// ];

    export default ({
           mixins: [InteractsWithQueryBuilder],
        components: {
            AppLayout,
            JetInput,
            AppMenu,
            Welcome,
            Pagination,
            Link,
            GrayButton,
            JetButton,
            Table: Tailwind2.Table,
            MailIcon, PhoneIcon
        },
        props: {
            patrons     : Object,
            total       : Number,
            firstItem   : Number,
            lastItem    : Number,
        },
        data() {
            return {
                keyword: null,
                length:10,
                term:null,
            }
        },
        methods: {
            destroy(id) {
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
                    this.$inertia.get(this.route('patron.destroy', id))
                }
                })
            },
            search() {
                this.$inertia.replace(this.route('patron', {term: this.term}))
            },
            resetPagination(length){
                //console.log(length);
                this.$inertia.replace(this.route('patrons', {length: this.length}))
            },
        },
    })
</script>
<style>
table nav{
    border:none !important;


}
</style>
