<template>
 <app-menu />
   <div class="lg:pl-64 flex flex-col bg-white divide-x divide-gray-200 border-2 shadow-md">

        <div class="flex flex-col p-4">
            <div class="border-b border-gray-200 px-2 py-2 flex sm:items-center justify-between sm:px-2 lg:px-8">

                <h2 class=" text-3xl min-w-0">
                        Permissions List
                </h2>
                <div class=" sm:mt-0 sm:ml-4 ">

                    <button type="button" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-md  rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-1 sm:ml-3">
                    <inertia-link :href="route('permissions.create')">Create</inertia-link>
                    </button>
                </div>
            </div>
            <div class="border-b border-gray-200 px-4 py-4 flex sm:items-center justify-between sm:px-6 lg:px-8">
                <div class="block flex">
                    <label for="paginate" class="sm:text-xs md:text-sm font-medium md:ml-5 text-gray-700 sm:mt-px sm:pt-2 pr-3">
                        <b> Per Page</b>
                    </label>
                    <select id="" v-model="length" @change="resetPagination(length)" name="" autocomplete="" class=" block focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
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
                        type="text"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Search..."
                    />
                </div>

            </div>

            <div class="-my-2 overflow-x-auto sm:-mx-4 lg:-mx-4">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th class="px-3 py-3 text-md text-center" >Id</th>
                                    <th scope="col" class="px-3 py-3 text-md text-cente">
                                        <inertia-link v-bind:href="this.route('roles', {sort: 'name',order:'desc'})"
                                            >Name</inertia-link
                                        >

                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-center">
                                        <inertia-link v-bind:href="this.route('roles', {sort: 'guard_name',order:'desc'})"
                                            >Guard Name</inertia-link
                                        >
                                    </th>
                                    <!-- <th class="px-3 py-3 text-md text-center">Image</th> -->
                                    <th class="px-3 py-3 text-md text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(permission, index) in permissions.data" :key="permission.id" v-bind:class="index % 2 === 0 ? 'bg-white-100 hover:bg-blue-100' : 'bg-gray-200 hover:bg-blue-100'">                            
                                    <td  class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-900">                       
                                        <inertia-link v-bind:href="route('roles.edit', permission.id)" >{{ ++index}}</inertia-link>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><a  v-bind:href="route('permissions.edit', permission.id)" >{{ permission.name }}</a></td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><a  v-bind:href="route('permissions.edit', permission.id)" >{{ permission.guard_name }}</a></td>                                  
                                   <td class="px-3 py-3 flex text-sm justify-center text-gray-500">
                                        <inertia-link class="btn btn-danger btn-sm" v-bind:href="route('permissions.destroy', permission.id)" >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </inertia-link>
                                        <inertia-link class="" v-bind:href="route('permissions.edit', permission.id)">
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
          <pagination class="mt-6" :links="permissions.links" />
        </div>
    </div>
</template>

<script>
   // import { ref } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Pagination from '@/Jetstream/Pagination'
    import {TrashIcon} from '@heroicons/vue/outline'
    export default ({
        components: {
            AppLayout,
            AppMenu,
            Welcome,
            Pagination,
            TrashIcon,
        },
        props: {
        permissions: Object,
        },
        data() {
        return {
            keyword: null,
            length:10,
        }
    },

    methods: {
         search() {
            this.$inertia.replace(this.route('permissions', {term: this.term}))
          },
          resetPagination(length){
            //console.log(length);
            this.$inertia.replace(this.route('permissions', {length: this.length}))
          },
          destroy() {
                if (confirm('Are you sure you want to delete this Permission?')) {
                  this.$inertia.delete(this.route('permissions.destroy', this.permission.id))
                }
           },
    },
    })
</script>

<style>
h2{
    color:#37577c;
    font-family: 'Roboto Condensed', sans-serif;
    font-weight: 700;
}
th{
    color:#5380b4;
    font-family: 'Roboto Condensed', sans-serif;
    font-weight: 700;
}
</style>
