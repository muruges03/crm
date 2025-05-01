
<template>
 <app-menu />

   <div class="lg:pl-64 flex flex-col ">
       <div class="bg-blue-600 p-3" v-if="$page.props.auth.user.can['employee_attendance']==true">
           <form   class="flex justify-between">
               <h3 class="font-bold p-2">Attendance</h3>
               <div class="col-span-12 sm:col-span-3">
                   <Switch @click="paidstatus(form)" :class="[form.attendance_status ? 'bg-green-500' : 'bg-gray-200', 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">
                       <span class="sr-only">Use setting</span>
                       <span  :class="[form.attendance_status ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']">
                            <span :class="[form.attendance_status ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200', 'absolute inset-0 h-full w-full flex items-center justify-center transition-opacity']" aria-hidden="true">
                                <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                    <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span :class="[form.attendance_status ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100', 'absolute inset-0 h-full w-full flex items-center justify-center transition-opacity']" aria-hidden="true">
                                <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                    <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                                </svg>
                            </span>
                       </span>
                   </Switch>
               </div>
           </form>
       </div>
        <div class="px-4 py-4 " v-if="$page.props.auth.user.can['create_attendance']==true" >
            <div class="shadow-lg rounded-md">
                <p v-if="this.message" :style="{ color: this.messageType === 'success' ? 'green' : 'red' }">{{ this.message }}</p>
                <div class="py-4 px-4 md:px-6">
                    <div class="mt-4 sm:mt-0 flex  md:px-6 justify-between">
                        <h2 class="text-lg font-semibold flex"><img src="/assets/add-product.png" class="w-6 h-6 mr-3">ATTENDANCE LIST</h2>
                        <jet-button type="button" >
                            <inertia-link :href="route('attendance.create')" v-if="$page.props.auth.user.can['create_attendance']==true">Create</inertia-link>
                        </jet-button>
                    </div>
                </div>
                <div class=" px-4 py-2 flex sm:items-center justify-between sm:px-6 ">
                    <div class="block flex">

                        <select id="" style="height:40px !important;" v-model="length" @change="resetPagination(length)" name="" autocomplete="country-name" class=" block focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <input
                            name="table_search"
                            v-model="term"
                            @keyup="search"
                            type="text"
                            autocomplete="off"
                            class=" focus:ring-indigo-500 focus:border-indigo-500 ml-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            placeholder="Search Product ..."
                        />
                    </div>
                </div>
                <div class=" overflow-x-auto px-4">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-4">
                        <div class=" overflow-hidden  border-gray-200 ">
                            <Table
                                :on-update="setQueryBuilder"
                                :meta="attendance"
                                class="min-w-full divide-y divide-gray-200"
                            >
                                <template #head>
                                <tr>
                                    <th class=" px-3 py-3.5 text-left text-sm font-semibold text-gray-900" >#</th>
                                    <th class=" px-3 py-3.5 text-left text-sm font-semibold text-gray-900" @click.prevent="sortBy('emp_name')">Employee Name</th>
                                    <th class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell" @click.prevent="sortBy('check_in')">Check In</th>
                                    <th class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell" @click.prevent="sortBy('check_out')">Check Out</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </template>
                                <template #body>
                                    <tr v-for="(attendances,index ) in attendance.data" :key="attendances.id" v-bind:class="index % 2 === 0 ? 'transition ease-in-out delay-100 hover:-translate-y-2 duration-100 hover:bg-gray-100 bg-white' : 'transition ease-in-out delay-100 hover:-translate-y-2 duration-100 hover:bg-gray-50 bg-gray-100'">
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{index+1}}</td>
                                        <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                                            <inertia-link   >{{ attendances.first_name }} {{ attendances.last_name }}</inertia-link>
                                            <dl class="font-normal lg:hidden">
                                                <dt class="sr-only sm:hidden">Check In</dt>
                                                <dd class="mt-1 truncate text-gray-500 sm:hidden"><inertia-link  >{{ attendances.check_in }}</inertia-link></dd>
                                                <dt class="sr-only sm:hidden">Check Out</dt>
                                                <dd class="mt-1 truncate text-gray-500 sm:hidden"><inertia-link  >{{ attendances.check_out }}</inertia-link></dd>
                                            </dl>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"><inertia-link  >{{ attendances.check_in }}</inertia-link></td>
                                        <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"><inertia-link  >{{ attendances.check_out }}</inertia-link></td>
                                        <td class="py-4 pl-3 pr-4 flex justify-center text-sm font-medium sm:pr-6">
                                            <inertia-link class="" v-if="$page.props.auth.user.can['delete_attendance']==true" @click="destroy(attendances.id)" >
                                                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:29px;">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </inertia-link>
                                        </td>
                                    </tr>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
            </div>
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
   import { Switch } from '@headlessui/vue'
    import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';
        import Swal from 'sweetalert2'
    export default ({
        mixins: [InteractsWithQueryBuilder],
        components: {
            AppLayout,
            AppMenu,Switch,
            Welcome,
            Pagination,
            TrashIcon,
            GrayButton,
            JetButton,
            Table: Tailwind2.Table
        },
       props: [
            "attendance","status"
        ],
    data() {
        return {
            keyword: null,
            length:10,
            term:null,
            message: '',
            messageType: '',
            form: this.$inertia.form({
                employee_id : null,
                date        : null,
                check_in    : null,
                check_out   : null,
                attendance_status   : this.status==0 ? 0 : 1,
            }),
        }
    },

    methods: {
        async destroy(id) {
            axios.delete(this.route('attendance.destroy',{id}))
                .then(response => {
                    console.log(response.data.message);
                    this.message = response.data.message;
                    this.messageType = 'success';
                    if(this.messageType == 'success'){
                        this.$inertia.get('/attendance')
                    }
                })
                .catch(error => {
                    if (error.response && error.response.data.message) {
                        this.message = error.response.data.message;
                    } else {
                        this.message = 'An unexpected error occurred.';
                    }
                    this.messageType = 'error';
                });
            },

        async store() {

        },

        paidstatus(form) {
            console.log(this.form.attendance_status);
            if(this.form.attendance_status==0) {
                this.form.attendance_status = 1;
                axios.post(this.route('attendance.employeeLoginToCheckIn',this.form))
                    .then(response => {
                        // console.log(response.data.message);
                        this.message = response.data.message;
                        this.messageType = 'success';
                        if(this.messageType == 'success'){
                            this.$inertia.get('/attendance')
                        }
                    })
                    .catch(error => {
                        if (error.response && error.response.data.message) {
                            this.message = error.response.data.message;
                        } else {
                            this.message = 'An unexpected error occurred.';
                        }
                        this.messageType = 'error';
                    });
            }else{
                this.form.attendance_status = 0;
                axios.post(this.route('attendance.employeeLoginToCheckOut',this.form))
                    .then(response => {
                        // console.log(response.data.message);
                        this.message = response.data.message;
                        this.messageType = 'success';
                        if(this.messageType == 'success'){
                            this.$inertia.get('/attendance')
                        }
                    })
                    .catch(error => {
                        if (error.response && error.response.data.message) {
                            this.message = error.response.data.message;
                        } else {
                            this.message = 'An unexpected error occurred.';
                        }
                        this.messageType = 'error';
                    });
            }

        },
        },
    })
</script>
