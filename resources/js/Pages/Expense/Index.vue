
<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col bg-white ">
        <div class="px-4 py-4 sm:px-6 lg:px-8">
            <div class="mt-4 sm:mt-0 flex  md:px-3 justify-between">
                <h2 class="text-lg font-semibold flex">
                    Expense
                </h2>
                <jet-button type="button" >
                    <inertia-link :href="route('expense.create')">Create</inertia-link>
                </jet-button>
            </div>
            <div class="px-2 py-2 flex sm:items-center justify-between">
                <div class="block flex">
                    <label for="paginate" class="hidden md:table-cell sm:text-xs md:text-sm font-medium  text-gray-700 sm:mt-px sm:pt-2 pr-3">
                        <b> Per Page</b>
                    </label>
                    <select id="" v-model="length" @change="resetPagination(length)" name="" autocomplete="country-name" class="hidden md:table-cell block focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="inline-flex block flex pl-2">
                    <input
                        name="table_search"
                        v-model="term"
                        @keyup="search"
                        type="text"
                        autocomplete="off"
                        class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full  sm:text-sm border-gray-300 rounded-md"
                        placeholder="Search ..."
                    />
                    <svg @click="onFilter(0)" xmlns="http://www.w3.org/2000/svg" class="h-8 w-20 text-gray-400  md:ml-2 md:mt-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>
            </div>
            <div class="-mx-4 mt-4 overflow-hidden ring-1 ring-black ring-opacity-5 sm:-mx-2 md:mx-0 md:rounded">
                <Table
                    :on-update="setQueryBuilder"
                    :meta="invoice">
                    <template #head>
                        <tr>
<!--                            <th scope="col" class="w-0" style="padding:2px !important;"></th>-->
                            <!-- <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-6"> #</th> -->
                            <th scope="col" class="py-3.5 px-1 md:w-24 text-left text-sm font-semibold sm:pl-6" style="">Ref No</th>
                            <th scope="col" class="hidden px-1 py-3.5 md:w-60 text-left text-sm font-semibold lg:table-cell">Customer</th>
                            <th scope="col" class="hidden px-1 py-3.5 md:w-28 text-left text-sm font-semibold lg:table-cell"> Date</th>
                            <th scope="col" class="hidden px-1 md:w-28 py-3.5 text-left text-sm font-semibold lg:table-cell">Expense Name</th>
                            <th scope="col" class="hidden px-1 py-3.5 md:w-28 text-left text-sm font-semibold sm:table-cell">Made By</th>
                            <th scope="col" class="hidden px-1 py-3.5 md:w-28 text-left text-sm font-semibold sm:table-cell">Amount</th>

                        </tr>
                    </template>

                    <template #body>
                        <tr v-for="(expenses,index ) in expense.data" :key="expenses.id" v-bind:class="index % 2 === 0 ? 'transition ease-in-out delay-100 hover:-translate-y-2 duration-100 hover:bg-gray-100 bg-white' : 'transition ease-in-out delay-100 hover:-translate-y-2 duration-100 hover:bg-gray-50 bg-gray-100'">

                            <td class="w-full max-w-0 md:w-24 py-4 px-1 text-sm font-medium sm:w-auto sm:max-w-none sm:pl-2">
                                <inertia-link v-bind:href="route('expense.edit', expenses.id)" >{{expenses.prefix}}{{expenses.ref_no}}</inertia-link>

                            </td>
                            <td class="hidden px-1 py-4 text-sm font-semibold whitespace-normal truncate lg:table-cell">
                                <inertia-link v-bind:href="route('expense.edit', expenses.id)" >{{expenses.date}}</inertia-link>
                            </td>
                            <td class="hidden px-1 py-4 text-sm text-gray-500 whitespace-normal lg:table-cell">
                                <inertia-link v-bind:href="route('expense.edit', expenses.id)" >{{expenses.expense_type}}</inertia-link>
                            </td>
                            <td class="hidden px-1 py-4 text-sm text-gray-500 lg:table-cell">
                                <inertia-link v-bind:href="route('expense.edit', expenses.id)" >{{expenses.made_by}}</inertia-link>
                            </td>

                            <td class="hidden px-1 py-4 text-sm text-gray-500 sm:table-cell">
                                <inertia-link v-bind:href="route('expense.edit', expenses.id)" >₹ {{formatNumber(expenses.amount)}}</inertia-link>
                            </td>

                            <td class="py-4 pl-2 pr-2 text-right text-sm font-medium sm:pr-2 flex justify-between ">
                                <svg xmlns="http://www.w3.org/2000/svg" @click="destroy(expenses.id)" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                    <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>

                            </td>
                        </tr>
                    </template>
                </Table>
            </div>


        </div>
    </div>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import AppMenu from '@/Layouts/Appmenu.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import JetButton from '@/Jetstream/Button.vue'
import GrayButton from '@/Jetstream/GrayButton.vue'
import JetInput from '@/Jetstream/Input.vue'
import moment from "moment";
import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';
import { Switch } from '@headlessui/vue'
import Multiselect from '@suadelabs/vue3-multiselect'
import Swal from 'sweetalert2'

export default ( {
    components: {
        AppLayout,
        AppMenu,
        Welcome,
        JetButton,
        GrayButton,
        Table: Tailwind2.Table,JetInput,Switch,Multiselect
    },
    props: {
        expense   : Object,
    },


    data() {

    },
    methods: {
        search() {
            this.$inertia.replace(this.route('expense.index', {term: this.term}))
        },

        formatNumber(num) {
            var n1, n2;
            num = num + '' || '';
            n1 = num.split('.');
            n2 = n1[1] || null;
            n1 = n1[0].replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
            num = n2 ? n1 + '.' + n2 : n1;

            return num;
        },
        destroy(id) {
            Swal.fire({
                title: 'Are you sure?',
                //text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(this.route('expense.destroy', id))
                        .then(response => {
                            var response = response.data
                            if(response=='1') this.$inertia.get('/expense');
                            if(response=='failed') Swal.fire('This expense Not Able to Delete ')
                        })
                        .catch(error => {
                            console.log(error);
                        })
                }
            })
        },
    },
})
</script>


