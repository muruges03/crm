<template>
 <app-menu />
   <div class="lg:pl-64 flex flex-col">
        <div class=" p-4">
            <div class="px-4  flex sm:items-center justify-between">
                <h2 class="font-semibold text-lg flex">
                    <img src="/assets/customer.png" class="w-6 h-6 mr-3">
                    USER LIST
                </h2>
                <div class="">
                    <jet-button type="button" >
                        <inertia-link :href="route('user.create')">CREATE NEW</inertia-link>
                    </jet-button>
                </div>
            </div>
            <div class="border-b border-gray-200 px-4 py-2 flex sm:items-center justify-between ">
                <div class="block flex">
                    <label for="paginate" class="sm:text-xs md:text-sm font-medium  text-gray-700 sm:mt-px sm:pt-2 pr-3">
                        <b> Per Page</b>
                    </label>
                    <select id="" v-model="length" @change="resetPagination(length)" name="" autocomplete="" class=" block focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="block flex">
                    <input
                        name="table_search"
                        v-model="term"
                        @keyup="search"
                        type="text" class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Search Name ..."/>
                </div>
            </div>
            <div class="-my-2 overflow-x-auto sm:-mx-4 lg:-mx-4">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="">
                                <tr>
                                    <th class="px-3 py-3 text-md text-center" >#</th>
                                    <th scope="col" class="px-3 py-3 text-md text-center">
                                        <inertia-link v-bind:href="this.route('user', {sort: 'first_name',order:'desc'})">Name</inertia-link>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-cente">
                                        <inertia-link v-bind:href="this.route('user', {sort: 'email',order:'desc'})">Email</inertia-link>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-center">
                                        <inertia-link>Company</inertia-link>
                                    </th>
                                    <th class="px-3 py-3 text-md text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- v-bind:class="index % 2 === 0 ? 'bg-white-100 hover:bg-blue-100' : 'tr-bg-color hover:bg-blue-100'" -->
                                <tr v-for="(user, index) in user.data" :key="user.id" class="odd:bg-white hover:bg-blue-100 even:bg-blue-100">
                                    <td  class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-900">
                                        <inertia-link v-bind:href="route('users.edit', user.user_id)" >{{ firstItem+index}}</inertia-link>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><inertia-link  v-bind:href="route('users.edit', user.user_id)" >{{ user.first_name }} {{ user.last_name }}</inertia-link></td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><inertia-link  v-bind:href="route('users.edit', user.user_id)" >{{ user.email }}</inertia-link></td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><inertia-link  v-bind:href="route('users.edit', user.user_id)" > {{ user.legal_name }}</inertia-link></td>
                                   <td class="px-3 py-3 flex text-sm justify-center text-gray-500">
                                        <a class="btn btn-danger btn-sm" @click="destroy(user.id)" >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                        <inertia-link class=""  v-bind:href="route('users.edit', user.user_id)">
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
            <pagination class="" :links="user.links" />
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
            TrashIcon,
            GrayButton,
            JetButton
        },
        props: [
            "user",
            "filters",
            "firstItem",
            "lastItem",
            "total",
        ],
        data() {
        return {
            keyword: null,
            length:10,
            term:null,
        }
    },
    methods: {
        search() {
            this.$inertia.replace(this.route('user', {term: this.term}))
        },
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
                this.$inertia.get(this.route('user.destroy', id))
            }
            })
        },




        resetPagination(length){
            //console.log(length);
            this.$inertia.replace(this.route('user', {length: this.length}))
        },
        showImage() {
                return "../storage/public/";
        },
    },
 })
</script>
