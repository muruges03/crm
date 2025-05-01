
<template>
  <app-menu />
     <div class="lg:pl-64 flex flex-col bg-white divide-x divide-gray-200 border-2 shadow-md ">

        <div class="flex flex-col p-4">
            <div class="border-b border-gray-200 px-2 py-2 flex sm:items-center justify-between sm:px-4 lg:px-8">
                <h2 class=" text-2xl font-bold min-w-0">
                        Account List <span v-if="$page.props.auth.user.roles=='super-admin'"
                                            class="text-sm bg-gray-400 text-white p-1 rounded-full">{{totalRevenue(accounts.data)}}</span>
                </h2>
                <!-- <div class=" sm:mt-0 sm:ml-4 " >
                    <jet-button type="button" >
                        <inertia-link v-bind:href="route('entities.create')">Create</inertia-link>
                    </jet-button>
                </div> -->
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
                                        <inertia-link
                                        >INVOICE #</inertia-link>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-center   ">
                                        <inertia-link >CUSTOMER</inertia-link>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-center   ">
                                        <inertia-link >Paid Date</inertia-link>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-center  ">
                                       <inertia-link>Sub Total</inertia-link>
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-md text-center  ">
                                      <inertia-link >Total</inertia-link>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(account, index) in accounts.data" :key="account.id" v-bind:class="index % 2 === 0 ? 'bg-white-100 hover:bg-blue-100' : 'tr-bg-color hover:bg-blue-100'">
                                    <td  class="px-3 py-3 text-sm text-center text-gray-900">
                                        <inertia-link  >{{ firstItem+index }}</inertia-link>
                                    </td>
                                    <td class="px-3 py-3 text-sm text-center text-gray-500"><inertia-link   >{{ account.invoice_id.prefix }} - {{ account.invoice_id.invoice_number }}</inertia-link></td>
                                    <td class="px-3 py-3 text-sm text-center text-gray-500"><inertia-link   >{{ account.patron_id.legal_name }}</inertia-link></td>
                                    <td class="px-3 py-3 text-sm text-center text-gray-500"><inertia-link   >{{ account.paid_date }}</inertia-link></td>
                                    <td class="px-3 py-3 text-sm text-center text-gray-500"><inertia-link   >{{ account.untaxed_amount }}</inertia-link></td>
                                    <td class="px-3 py-3 text-sm text-center text-gray-500"><inertia-link   >{{ account.total_amount }}</inertia-link></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
             <div class="p-3 text-gray-500">Showing <b>{{firstItem}}</b> to <b>{{lastItem}}</b> of <b>{{total}}</b> Items </div>
           <pagination class="" :links="accounts.links" />
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
            JetButton,
        },
       props: [
            "accounts","firstItem","lastItem","total"
        ],
    data() {
        return {
            keyword: null,
            length:10,
            term:null,
        }
    },

    methods: {
        totalRevenue: function (values) {
            return values.reduce((acc, val) => {
                return acc + parseInt(val.total_amount);
            }, 0);
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
                    this.$inertia.get(this.route('product.destroy', id))
                }
            })
        },
        search() {
            this.$inertia.replace(this.route('product', {term: this.term}))
        },
        resetPagination(length){
            //console.log(length);
            this.$inertia.replace(this.route('product', {length: this.length}))
        },
    },
    })
</script>
