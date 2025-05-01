<template>
    <app-menu />
     <div class="lg:pl-64 flex flex-col bg-white divide-x divide-gray-200 border-2 shadow-md ">

        <div class="flex flex-col p-4">
            <div class="border-b border-gray-200 px-2 py-2 flex sm:items-center justify-between sm:px-4 lg:px-8">
                <h2 class=" text-2xl font-bold min-w-0">
                        Entity List
                </h2>
                <div class=" sm:mt-0 sm:ml-4 " >
                    <jet-button type="button" >
                        <inertia-link v-bind:href="route('entities.create')">Create</inertia-link>
                    </jet-button>
                </div>
            </div>
           <div class="border-b border-gray-200 px-4 py-4 flex sm:items-center justify-between sm:px-6 lg:px-8">
                <div class="block flex">
                    <label for="paginate" class="sm:text-xs md:text-sm font-medium md:ml-5 text-gray-700 sm:mt-px sm:pt-2 pr-3">
                        <b> Per Page</b>
                    </label>
                    <select id=""  v-model="length" @change="resetPagination()" name="" autocomplete="" class=" block focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="block flex pl-2">
                    <input
                        name="table_search"
                        v-model="term"
                        @keyup="search"
                        type="text" autocomplete="off"
                        class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Search Legal Name ..."
                    />
                </div>
            </div>
            <div class="-my-2 overflow-x-auto sm:-mx-4 lg:-mx-4">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="">
                                <tr>
                                    <th class="px-3 py-3 text-md text-center  " >#</th>
                                    <th scope="col" class="px-3 py-3 text-md text-center  ">
                                        <inertia-link v-bind:href="this.route('entities', {sort: 'entity_type',order:'desc'})"
                                        >Entity Type</inertia-link>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-center   ">
                                        <inertia-link v-bind:href="this.route('entities', {sort: 'legal_name',order:'desc'})">Legal Name</inertia-link>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-center  ">
                                       <inertia-link v-bind:href="this.route('entities', {sort: 'alias',order:'desc'})">Alias</inertia-link>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-center  ">
                                      <inertia-link v-bind:href="this.route('entities', {sort: 'url',order:'desc'})">URL</inertia-link>
                                    </th>
                                     <th scope="col" class="px-3 py-3 text-md text-center  ">
                                       <inertia-link v-bind:href="this.route('entities', {sort: 'status',order:'desc'})">Status</inertia-link>
                                    </th>
                                    <th class="px-3 py-3 text-md text-center  ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(entity, index) in entitys.data" :key="entity.id" v-bind:class="index % 2 === 0 ? 'bg-white-100 hover:bg-blue-100' : 'tr-bg-color hover:bg-blue-100'">
                                    <td  class="px-3 py-3 text-sm text-center text-gray-900">
                                        <!-- <input
                                            type="checkbox"
                                            :value="entity.id"
                                            v-model="checked"
                                        /> -->
                                        <inertia-link v-bind:href="route('entities.edit', entity.id)" >{{ firstItem+index }}</inertia-link>
                                    </td>
                                    <td class="px-3 py-3 text-sm text-center text-gray-500"><inertia-link  v-bind:href="route('entities.edit', entity.id)" >{{ entity.entity_type }}</inertia-link></td>
                                    <td class="px-3 py-3 text-sm text-center text-gray-500"><inertia-link  v-bind:href="route('entities.edit', entity.id)" >{{ entity.legal_name }}</inertia-link></td>
                                    <td class="px-3 py-3 text-sm text-center text-gray-500"><inertia-link  v-bind:href="route('entities.edit', entity.id)" >{{ entity.alias }}</inertia-link></td>
                                    <td class="px-3 py-3 text-sm text-center text-gray-500"><inertia-link  v-bind:href="route('entities.edit', entity.id)" >{{ entity.url }}</inertia-link></td>
                                    <td class="px-3 text-center py-3  " v-if= "entity.status == '1'"><inertia-link  v-bind:href="route('entities.edit', entity.id)" ><span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-green-500 rounded">Active  </span></inertia-link></td>
                                    <td class="px-3 text-center py-3 " v-if= "entity.status == '0'"><inertia-link  v-bind:href="route('entities.edit', entity.id)" ><span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-red-600 rounded">InActive</span></inertia-link></td>
                                    <td class="px-3 py-3 flex text-between text-sm justify-center text-gray-500">
                                        <a class="btn btn-danger btn-sm"  @click="destroy(entity.id)" >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                        <inertia-link class="" v-bind:href="route('entities.edit', entity.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:29px;">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </inertia-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
             <div class="p-3 text-gray-500">Showing <b>{{firstItem}}</b> to <b>{{lastItem}}</b> of <b>{{total}}</b> Items </div>
           <pagination class="" :links="entitys.links" />
        </div>
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
    export default ({
        components: {
            AppLayout,
            AppMenu,
            Welcome,
            Pagination,
            GrayButton,
            TrashIcon,
            JetButton,
        },
        props: [
            "entitys",
            "filters",
            "firstItem",
            "lastItem",
            "total",
        ],
        data() {
            return {
                keyword: null,
                term:null,
                length:10,
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
                    this.$inertia.get(this.route('entities.destroy', id))
                }
            })
        },

            search() {
                    this.$inertia.replace(this.route('entities', {term: this.term}))
                },
            resetPagination(length){
                    this.$inertia.replace(this.route('entities', {length: this.length}))
            },
        },
    })
</script>
