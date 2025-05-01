<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <div class="py-4 px-4 md:px-6">
                    <div class="mt-4 sm:mt-0 flex  md:px-6 justify-between">
                        <h2 class="text-lg font-semibold flex"><img src="/assets/add-user.png" class="w-6 h-6 mr-3">Personnel List</h2>
                        <jet-button type="button" >
                            <inertia-link :href="route('personnel.create')" >Create</inertia-link>
                        </jet-button>
                    </div>
                </div>
                <div class="px-4 py-2 flex sm:items-center justify-between">
                    <div class="block flex px-2">
                        <select v-model="length" style="height:40px !important" @change="resetPagination(length)"  class="mx-2 block focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <input
                            name="table_search"
                            v-model="term"
                            @keyup="search"
                            type="text" class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            placeholder="Search Name ..."/>
                    </div>
                </div>
                <div class="overflow-x-auto px-4">
                    <div class="p-2 align-middle inline-block min-w-full">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="">
                                    <tr>
                                        <th class="px-3 py-3 text-md text-center" >#</th>
                                        <th scope="col" class="px-3 py-3 text-md text-center">
                                            <inertia-link v-bind:href="this.route('personnel', {sort: 'first_name',order:'desc'})">Name</inertia-link>
                                        </th>
                                        <!-- <th scope="col" class="px-3 py-3 text-md text-center">
                                            <inertia-link >Department</inertia-link>
                                        </th> -->
                                        <th scope="col" class="px-3 py-3 text-md text-center">
                                            <inertia-link v-bind:href="this.route('personnel', {sort: 'mobile',order:'desc'})">Mobile</inertia-link>
                                        </th>
                                        <th scope="col" class="px-3 py-3 text-md text-center">
                                            <inertia-link v-bind:href="this.route('personnel', {sort: 'email',order:'desc'})">Email</inertia-link>
                                        </th>
                                        <th class="px-3 py-3 text-md text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(personnels, index) in personnel.data" :key="personnels.id" v-bind:class="index % 2 === 0 ? 'bg-white-100 hover:bg-blue-100' : 'tr-bg-color hover:bg-blue-100'">
                                        <td  class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-900">
                                            <a @click="edit(personnels)">{{ firstItem+index}}</a>
                                        </td>
                                        <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><a v-bind:href="route('personnel.edit', personnels.pid)">{{personnels.first_name }} {{personnels.last_name }}</a></td>
                                        <!-- <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><a @click="edit(personnels)">{{personnels.params.department }}-{{personnels.params.role }}</a></td> -->
                                        <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><a v-bind:href="route('personnel.edit', personnels.pid)">{{personnels.mobile }}</a></td>
                                        <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><a v-bind:href="route('personnel.edit', personnels.pid)">{{personnels.email }}</a></td>
                                        <td class="px-3 py-3 flex text-sm justify-center text-gray-500">
                                            <a v-bind:href="route('personnel.edit', personnels.pid)">
                                                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:29px;">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <pagination class="mt-6" :links="personnel.links" />
            </div>
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
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import moment from "moment";


    export default ({
        components: {
            AppLayout,
            AppMenu,
            Welcome,
            Pagination,
            TrashIcon,
            GrayButton,
            JetInput,
            JetInputError,
            moment,
            JetButton,
        },
        remember: 'form',
        props: [
            'personnel',
            "filters",
            "firstItem",
            "lastItem",
            "total",
        ],
        data(){
            return {
                length  : 10,
                term    : null,
            }
        },

    methods: {
        search() {
            this.$inertia.replace(this.route('personnel', {term: this.term}))
        },
        resetPagination(length){
            //console.log(length);
            this.$inertia.replace(this.route('personnel', {length: this.length}))
        },

    },
 })
</script>
