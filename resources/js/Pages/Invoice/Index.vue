
<template>
<app-menu />
    <div class="lg:pl-64 flex flex-col bg-white ">
        <div class="px-4 py-4 sm:px-6 lg:px-8">
            <div class="mt-4 sm:mt-0 flex  md:px-3 justify-between">
                <h2 class="text-lg font-semibold flex">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg> -->
                    <img src="/assets/invoice.png" width="25" height="10" class="mr-4 text-black">
                    INVOICE
                </h2>
                    <jet-button type="button" >
                        <inertia-link :href="route('invoice.create')">Create</inertia-link>
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
<!--                    <button @click="bulkMail" class="bg-gray-500 rounded border text-sm font-semibold px-2 py-2">Bulk</button>-->

                    <button @click="bulkgenerate" class="bg-gray-200 rounded border text-sm font-semibold px-2 py-2">Generate</button>
                    <button @click="bulkdownload" class="bg-blue-200 rounded border text-sm font-semibold px-2 py-2">Download</button>

                    <div class="inline-flex block flex pl-2">
                        <input
                            name="table_search"
                            v-model="term"
                            @keyup="search"
                            type="text"
                            autocomplete="off"
                            class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full  sm:text-sm border-gray-300 rounded-md"
                            placeholder="Search..."
                            title="Search Customer, amount, invoice No, prefix"
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
                                <th scope="col" class="w-0" style="padding:2px !important;"></th>
                                <!-- <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-6"> #</th> -->
                                <th scope="col" class="py-3.5 px-1 md:w-24 text-left text-sm font-semibold sm:pl-6" style="">Invoice #</th>
                                <th scope="col" class="hidden px-1 py-3.5 md:w-60 text-left text-sm font-semibold lg:table-cell">Customer</th>
                                <th scope="col" class="hidden px-1 py-3.5 md:w-28 text-left text-sm font-semibold lg:table-cell">Invoice Date</th>
                                <th scope="col" class="hidden px-1 md:w-28 py-3.5 text-left text-sm font-semibold lg:table-cell">Due Date</th>
                                <th scope="col" class="hidden px-1 py-3.5 md:w-28 text-left text-sm font-semibold sm:table-cell">Duration</th>
                                <th scope="col" class="hidden px-1 py-3.5 md:w-28 text-left text-sm font-semibold sm:table-cell">Amount + Tax</th>
                                <th scope="col" class="hidden px-1 py-3.5 md:w-28 text-left text-sm font-semibold sm:table-cell">Amount</th>
                                <th scope="col" class="px-1 py-3.5 md:w-28 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="relative md:w-40 py-2 pl-2 pr-2">
                                    <button type="button" class="inline-flex items-center px-2 py-2 bg-[#0d628bbf] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 disabled:opacity-25 transition" @click="onFilter(1)">
                                            <img src="/assets/export.png" class="mr-1 opacity-70  h-5 w-5" width="" title="Export the Excel Report" >
                                            <span class="mt-1">Export</span>
                                    </button>
                                </th>
                            </tr>
                        </template>
                        <template #body>
                            <tr v-for="(invoices,index ) in invoice.data" :key="invoices.id" v-bind:class="index % 2 === 0 ? 'transition ease-in-out delay-100 hover:-translate-y-2 duration-100 hover:bg-gray-100 bg-white' : 'transition ease-in-out delay-100 hover:-translate-y-2 duration-100 hover:bg-gray-50 bg-gray-100'">
                                <td class=" bg-red-600" style="padding:0px !important;"  v-if= "invoices.paid_status == '0' && invoices.cancel_status==0"></td>
                                <td class=" bg-green-500" style="padding:0px !important;" v-if= "invoices.paid_status == '1' && invoices.cancel_status==0"></td>
                                <!-- <td class="ml-5 mt-5 bg-manatee-50 flex flex-shrink-0 w-10 h-10 rounded-full text-center whitespace-nowrap">
                                    <div class="text-center w-full py-2 font-normal text-manatee-200 text-lg">
                                        {{ index+1 }}
                                    </div>
                                </td> -->
                                <td class="w-full max-w-0 md:w-24 py-4 px-1 text-sm font-medium sm:w-auto sm:max-w-none sm:pl-2">
                                     <inertia-link v-bind:href="route('invoice.edit', invoices.id)" >{{invoices.prefix}}{{invoices.invoice_number}}</inertia-link>
                                    <dl class="font-normal lg:hidden">
                                        <dt class="sr-only">Title</dt>
                                        <dd class="mt-1 truncate text-gray-700 whitespace-normal">
                                             <inertia-link v-bind:href="route('invoice.edit', invoices.id)" >{{invoices.legal_name}}</inertia-link>
                                        </dd>
                                        <dt class="sr-only sm:hidden">Email</dt>
                                        <dd class="mt-1 truncate text-gray-500 sm:hidden">
                                             <inertia-link v-bind:href="route('invoice.edit', invoices.id)" >₹ {{formatNumber(invoices.total_amount)}}</inertia-link>
                                        </dd>
                                    </dl>
                                </td>
                                <td class="hidden px-1 py-4 text-sm font-semibold whitespace-normal truncate lg:table-cell">
                                    <inertia-link v-bind:href="route('invoice.edit', invoices.id)" >{{invoices.legal_name}}</inertia-link>
                                </td>
                                <td class="hidden px-1 py-4 text-sm text-gray-500 whitespace-normal lg:table-cell">
                                    <inertia-link v-bind:href="route('invoice.edit', invoices.id)" >{{invoices.invoiced_at}}</inertia-link>
                                </td>
                                <td class="hidden px-1 py-4 text-sm text-gray-500 lg:table-cell">
                                     <inertia-link v-bind:href="route('invoice.edit', invoices.id)" >{{invoices.due_at}}</inertia-link>
                                </td>
                                <!-- <td v-if="!invoices.end_date" class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{invoices.start_date}}</td> -->
                                <td  class="hidden px-1 py-4 text-sm text-gray-500 sm:table-cell">
                                     <inertia-link v-bind:href="route('invoice.edit', invoices.id)" >{{invoices.start_date}}<span v-if="invoices.end_date"> to {{invoices.end_date}} </span></inertia-link>
                                </td>
                                <td class="hidden px-1 py-4 text-sm text-gray-500 sm:table-cell">
                                     <inertia-link v-bind:href="route('invoice.edit', invoices.id)" >₹ {{formatNumber(invoices.total_amount)}}</inertia-link>
                                </td>
                                <td class="hidden px-1 py-4 text-sm text-gray-500 sm:table-cell">
                                     <inertia-link v-bind:href="route('invoice.edit', invoices.id)" >₹ {{formatNumber(invoices.untaxed_amount)}}</inertia-link>
                                </td>
                                <td>
                                    <Switch @click="cancelStatus(invoices)" :class="[invoices.cancel_status ? 'bg-red-500' : 'bg-gray-200', 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">
                                        <span class="sr-only">Use setting</span>
                                        <span  :class="[invoices.cancel_status ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']">
                                        <span :class="[invoices.cancel_status ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 h-full w-full flex items-center justify-center transition-opacity']" aria-hidden="true">
                                            <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                                <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span :class="[invoices.cancel_status ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 h-full w-full flex items-center justify-center transition-opacity']" aria-hidden="true">
                                            <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                                <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                                            </svg>
                                        </span>
                                        </span>
                                    </Switch>
                                </td>
                                <td class="py-4 pl-2 pr-2 text-right text-sm font-medium sm:pr-2 flex justify-between ">
                                    <inertia-link v-if="invoices.paid_status !='1' && invoices.cancel_status==0" v-bind:href="route('invoice.edit', invoices.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:25px;">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </inertia-link>
                                   <a v-if="invoices.paid_status !='1' && invoices.cancel_status==0" class="btn btn-danger btn-sm" @click="destroy(invoices.id)" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
<!--                                   <inertia-link v-if="invoices.paid_status =='0'"  v-bind:href="route('invoice.mail', invoices.id)">-->
<!--                                        <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">-->
<!--                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />-->
<!--                                        </svg>-->
<!--                                    </inertia-link>-->
                                    <a class=""  v-bind:href="route('invoice.invoicePdf', invoices.id)" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </template>
                    </Table>
                </div>
<!-- filter popup -->
            <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"  v-if="isFilter">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <form class="border-2 p-2" @submit.prevent="filter" autocomplete="off" >
                            <div class="grid grid-cols-6 gap-4">
                                <div class="col-span-6 sm:col-span-3">
                                        <label for="purchase_date" class="block text-sm font-medium text-gray-700"> From Date</label>
                                        <input  v-model="form.from_date"  name="from_date" id="from_date" type="date" class=" focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full shadow-sm text-sm border-gray-300 rounded-md"  />
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="purchase_date" class="block text-sm font-medium text-gray-700"> To Date</label>
                                        <input  v-model="form.to_date" name="to_date" id="to_date" type="date" class=" focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full shadow-sm text-sm border-gray-300 rounded-md"  />
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                    <label for="paid" class="block text-sm font-medium text-gray-700 mb-2">Padi Status</label>
                                       <Switch v-model="form.paid_status"  :class="[form.paid_status ? 'bg-green-500' : 'bg-gray-200', 'mt-2 relative inline-flex flex-shrink-0  h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">
                                            <span class="sr-only">Use setting</span>
                                            <span :class="[form.paid_status ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']">
                                            <span :class="[form.paid_status ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 h-full w-full flex items-center justify-center transition-opacity']" aria-hidden="true">
                                                <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                                <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <span :class="[form.paid_status ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 h-full w-full flex items-center justify-center transition-opacity']" aria-hidden="true">
                                                <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                                <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                                                </svg>
                                            </span>
                                            </span>
                                        </Switch>
                                    </div>
                                </div>
                                    <div class="mt-5 sm:mt-6 flex justify-between">
                                        <button type="button" @click="isFilter= false" class=" bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                               Cancel
                                        </button>
                                        <jet-button type="button" v-show="form.value=='1'">
                                            <a v-bind:href="route('invoice.export',form)">Export</a>
                                        </jet-button>
                                        <jet-button type="submit" v-show="form.value=='0'">
                                               Search
                                        </jet-button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
<!--End filter popup -->

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
export default ({
    mixins: [InteractsWithQueryBuilder],
    components: {
            AppLayout,
            AppMenu,
            Welcome,
            JetButton,
            GrayButton,
            Table: Tailwind2.Table,JetInput,Switch,Multiselect
        },
    props: ["invoice",'patron'],
    data() {
        return {
            form: this.$inertia.form({
                customer_name   : null,
                from_date       : null,
                to_date         : null,
                paid_status     : false,
                value           : null,
                cancel_status   : false,
            }),
            keyword     : null,
            length      : 10,
            term        : null,
            isFilter    : false,
        }
    },
    methods: {

        bulkMail()
        {
            Swal.fire({
                title: 'Do you want to send mail ?',
                showCancelButton: true,
                confirmButtonText: 'Send',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.get(this.route('invoice.bulkmailsend'))
                }
            })
        },
        bulkdownload() {
            Swal.fire({
                title: 'Do you want to Download?',
                showCancelButton: true,
                confirmButtonColor: '#4e8c54',
                cancelButtonColor: '#bababa',
                confirmButtonText: 'Download',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Use window.location to download the PDF
                    window.location.href = this.route('invoice.downloadInvoices');

                    // Show toast message after initiating the download
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'Download started successfully'
                    });
                }
            });
        },


        bulkgenerate() {
            Swal.fire({
                title: 'Do you want to Generate?',
                showCancelButton: true,
                confirmButtonColor: '#751aa2',
                cancelButtonColor: '#cdcbcb',
                confirmButtonText: 'Generate',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.get(this.route('invoice.generate'), {}, {
                        onSuccess: () => {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer);
                                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                                }
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Records Generated Successfully'
                            });
                        },
                        onError: () => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    });
                }
            });
        },

        totalRevenue: function (values) {
            return values.reduce((acc, val) => {
                return acc + parseInt(val.total_amount);
            }, 0);
        },
        formatNumber(num) {
            // input = num;
            var n1, n2;
            num = num + '' || '';
            // works for integer and floating as well
            n1 = num.split('.');
            n2 = n1[1] || null;
            n1 = n1[0].replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
            num = n2 ? n1 + '.' + n2 : n1;
            //console.log("Input:",num)
            // console.log("Output:", 9 );

            return num;
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
                    this.$inertia.get(this.route('invoice.destroy', id))
                }
            })
        },
        cancelStatus(id) {
            Swal.fire({
            title: 'Do you want to Cancel the Invoice?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#00aa00',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.post(this.route('invoice.cancelStatus', id));
                }
            })
        },
        search() {
            this.$inertia.replace(this.route('invoice', {invoice_number:this.term}))
        },
        resetPagination(length){
            this.$inertia.replace(this.route('invoice', {length: this.length}))
        },
        filter(){
           this.form.get(this.route('invoice'));
        },
        onFilter(value){
            this.form.value = value;
            this.isFilter   = true;
        },
        export(){
            this.form.get(this.route('invoice'))
        },
        moment() {
            return moment();
        },
    },

})
</script>
<style>
table[data-v-2edd6bbd] th, td {
    padding:  0.5rem  !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: normal !important;
}
table[data-v-2edd6bbd] th {
    padding-top:  0.80rem  !important;
    padding-bottom:  0.80rem  !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: normal !important;
}

.w-48{
    width:10rem !important;
}
.w-28{
    width:6.7rem !important;
}
</style>
