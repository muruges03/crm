
<template>
 <app-menu />
   <div class="lg:pl-64 flex flex-col ">
       <div class="px-4 pt-5">
               <h2 class="text-lg font-semibold flex">LEAVE</h2>
       </div>
        <div class="px-4 py-1 ">
            <p v-if="message" :style="{ color: messageType === 'success' ? 'green' : 'red' }">{{ message }}</p>
            <form  @submit.prevent="store" >
                <div class="grid grid-cols-12 gap-4">

                    <div class="col-span-12 sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500">Employee</label>
                        <Multiselect :value="this.employee.id"  :multiple="false" v-model="form.employee_id" select-label="" deselect-label="" track-by="id" label="first_name" class="!block"
                                         placeholder="Select Employee" ref="customer_name" :options="this.employee" :searchable="true" :allow-empty="true">

                            </Multiselect>
                        <div v-if="errors.employee_id" class="text-xs text-red-500">The Employee field is required.</div>
                    </div>
                    <div class="col-span-12 sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500">Leave Type</label>
                        <div class="mt-1 sm:mt-0">
                            <Multiselect  :value="this.leaveType.id" :multiple="false" v-model="form.leave_type_id" select-label="" deselect-label="" track-by="id" label="name" class="!block"
                                          placeholder="Select " ref="" :options="this.leaveType" :searchable="true" :allow-empty="false">

                            </Multiselect>
                        </div>
                        <div v-if="errors.leave_type_id" class="text-xs text-red-500">The Leave Type field is required.</div>
                    </div>
                    <div class="col-span-12 sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500">Reason</label>
                        <textarea v-model="form.reason" class="w-full border-gray-300 rounded-md"/>
                    </div>
                    <div class="col-span-12 sm:col-span-2">
                        <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500">Start Date</label>
                       <Datepicker required class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="start_date" name="start_date"
                                        v-model="form.start_date" text-input  autoApply :enableTimePicker="false"
                                        id="start_date"  autocomplete="" placeholder=" Date" />
                        <div v-if="errors.start_date" class="text-xs text-red-500">The Start Date field is required.</div>

                    </div>
                    <div class="col-span-12 sm:col-span-2">
                        <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500"> End Date</label>
                        <Datepicker required class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                        ref="end_date" name="end_date" v-model="form.end_date"
                                        text-input autoApply :enableTimePicker="false"
                                        id="end_date"  autocomplete="off" placeholder="" />
                        <div v-if="errors.end_date" class="text-xs text-red-500">The End Date field is required.</div>
                    </div>

                </div>
<!--                    v-if="$page.props.auth.user.can['create_leaves']==true"-->
                <div class="p-2" >
                    <div class="flex justify-center ">
                        <jet-button type="submit">
                            CREATE
                        </jet-button>
                    </div>
                </div>
            </form>
        </div>


            <div class="shadow-lg rounded-md">
                <div class=" px-4">
                    <div class="mt-2 sm:mt-0 flex  md:px-6 justify-between">
                        <h2 class="text-lg font-semibold flex"> LIST</h2>

                    </div>
                </div>
                <div class=" px-4 py-1 flex sm:items-center justify-between sm:px-6 ">
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
                    <div class="py-1 align-middle inline-block min-w-full sm:px-6 lg:px-4">
                        <div class=" overflow-hidden  border-gray-200 ">
                            <Table
                                :on-update="setQueryBuilder"
                                :meta="leave"
                                class="min-w-full divide-y divide-gray-200"
                            >
                                <template #head>
                                <tr>
                                    <th class=" px-3 py-1.5 text-left text-sm font-semibold text-gray-900" >#</th>
                                    <th class=" px-3 py-1.5 text-left text-sm font-semibold text-gray-900" @click.prevent="sortBy('leave_type')">Leave Type</th>
                                    <th class="hidden px-1 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell" @click.prevent="sortBy('first_name')">Employee Name</th>
                                    <th class="hidden px-1 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell" @click.prevent="sortBy('start_date')">Start Date</th>
                                    <th class="hidden px-1 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell" @click.prevent="sortBy('end_date')">End Date</th>
                                    <th class="hidden px-1 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">Leave Status</th>
<!--                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">-->
<!--                                        Action-->
<!--                                    </th>-->
                                </tr>
                                </template>
                                <template #body>
                                <tr v-for="(leaves,index ) in leave.data" :key="leaves.id" v-bind:class="index % 2 === 0 ? 'transition ease-in-out delay-100  duration-100 hover:bg-gray-100 bg-white' : 'transition ease-in-out delay-100 hover:-translate-y-2 duration-100 hover:bg-gray-50 bg-gray-100'">
                                    <td class="hidden px-3 py-1 text-sm text-gray-500 sm:table-cell">{{ index+1 }}</td>
                                    <td class="w-full max-w-0 py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                                        <inertia-link  v-bind:href="route('product.edit', leaves.id)" >{{ leaves.leave_type }}</inertia-link>
                                        <dl class="font-normal lg:hidden">
                                            <dt class="sr-only sm:hidden">Name</dt>
                                            <dd class="mt-1 truncate text-gray-500 sm:hidden"><inertia-link v-bind:hef="route('leave.edit', leaves.id)" >{{ leaves.first_name }} {{ leaves.last_name }}</inertia-link></dd>
                                            <dt class="sr-only sm:hidden">Start Date</dt>
                                            <dd class="mt-1 truncate text-gray-500 sm:hidden"><inertia-link v-bind:hef="route('leave.edit', leaves.id)" >{{ leaves.start_date }}</inertia-link></dd>
                                            <dt class="sr-only sm:hidden">End Date</dt>
                                            <dd class="mt-1 truncate text-gray-500 sm:hidden"><inertia-link v-bind:hef="route('leave.edit', leaves.id)" >{{ leaves.end_date }}</inertia-link></dd>
                                        </dl>
                                    </td>
                                    <td class="hidden px-3 py-1 text-sm text-gray-500 sm:table-cell"><inertia-link  >{{ leaves.first_name }} {{ leaves.last_name }}</inertia-link></td>
                                    <td class="hidden px-3 py-1 text-sm text-gray-500 sm:table-cell"><inertia-link  >{{ leaves.start_date }}</inertia-link></td>
                                    <td class="hidden px-3 py-1 text-sm text-gray-500 sm:table-cell"><inertia-link  >{{ leaves.end_date }}</inertia-link></td>
                                    <td v-show="leaves.leave_status=='Pending'" class="hidden blinking-text px-3 py-1 text-sm text-gray-500 sm:table-cell"><inertia-link @click="updateStatus(leaves.id)" :title="leaves.leave_status" class="bg-yellow-500 p-1 w-7 rounded-lg text-white">{{ leaves.leave_status.substring(0,1) }}</inertia-link></td>
                                    <td v-show="leaves.leave_status=='Approved'" disabled class="hidden blinking-text px-3 py-1 text-sm text-gray-500 sm:table-cell" ><div  :title="leaves.leave_status" class="bg-green-500 p-1 rounded-lg w-7 text-white">{{ leaves.leave_status.substring(0,1) }}</div></td>
                                    <td v-show="leaves.leave_status=='Reject'" disabled class="hidden blinking-text px-3 py-1 text-sm text-gray-500 sm:table-cell"><div  :title="leaves.leave_status" class="bg-red-500 p-1 rounded-lg  w-7 text-white">{{ leaves.leave_status.substring(0,1) }}</div></td>
<!--                                    <td class="py-1 pl-3 pr-4 flex justify-center text-sm font-medium sm:pr-6">-->

<!--                                        <inertia-link class=""  v-if="$page.props.auth.user.can['edit_products']==true">-->
<!--                                            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:29px;color:#27679b;font-weight: 600">-->
<!--                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />-->
<!--                                            </svg>-->
<!--                                        </inertia-link>-->
<!--                                    </td>-->
                                </tr>
                                </template>
                            </Table>
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
    import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';
        import Swal from 'sweetalert2'
   import Datepicker from '@vuepic/vue-datepicker';
   import '@vuepic/vue-datepicker/dist/main.css';
   import JetInput from '@/Jetstream/Input.vue'
   import Multiselect from '@suadelabs/vue3-multiselect'
    export default ({
        mixins: [InteractsWithQueryBuilder],
        components: {
            AppLayout,JetInput,Datepicker,Multiselect,
            AppMenu,
            Welcome,
            Pagination,
            TrashIcon,
            GrayButton,
            JetButton,
            Table: Tailwind2.Table
        },
       props: [
            "leaveType",'employee','leave'
        ],
    data() {
        return {
            keyword: null,
            length:10,
            term:null,
            form: this.$inertia.form({
                leave_type_id: null,
                employee_id : null,
                reason: null,
                start_date: null,
                end_date: null,
            }),
            errors: {
                leave_type_id: false,
                employee_id : false,
                reason: false,
                start_date: false,
                end_date: false,
            },
            message : '',
            messageType : '',
        }
    },

    methods: {
        updateStatus(id){
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Approved",
                denyButtonText: `Reject`,
                confirmButtonColor: '#05b309',
                cancelButtonColor: '#555',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post(this.route('leaves.updateStatus',{'id':id,'type':'Approved'}))
                        .then(response => {
                            console.log(response);
                                if(response.data==1)
                                    Swal.fire("Saved!", "", "success");
                                else
                                    Swal.fire("Already Approved!", "", "danger");
                        }).catch(error => {
                    })
                    // Swal.fire("Saved!", "", "success");
                } else if (result.isDenied) {
                    axios.post(this.route('leaves.updateStatus',{'id':id,'type':'Reject'}))
                        .then(response => {
                            if(response.data==1)
                                Swal.fire("Saved!", "", "success");
                            else
                                Swal.fire("Already Reject!", "", "danger");
                        }).catch(error => {
                    })
                }
            });

            // Swal.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Yes, delete it!'
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         this.$inertia.post(this.route('leaves.updateStatus'))
            //     }
            // })
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



        async store() {
                if(this.form.employee_id==null)  return [this.errors.employee_id=true];
                else this.errors.employee_id=false;
                if(this.form.leave_type_id==null)  return [this.errors.leave_type_id=true];
                else this.errors.leave_type_id=false;
                if(this.form.start_date==null)  return [this.errors.start_date=true];
                else this.errors.start_date=false;
                if(this.form.end_date==null)  return [this.errors.end_date=true];
                else this.errors.end_date=false;
            axios.post(this.route('leave.store',this.form))
                .then(response => {
                    // console.log(response.data.message);
                    this.message = response.data.message;
                    this.messageType = 'success';
                    if(this.messageType == 'success'){
                        this.$inertia.get('/leave')
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

         search() {
            this.$inertia.replace(this.route('leave', {term: this.term}))
          },
          resetPagination(length){
            //console.log(length);
            this.$inertia.replace(this.route('product', {length: this.length}))
          },
    },
    })
</script>
<style>
table  td {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
}

@keyframes blink {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.blinking-text {
    text-align: center;
    margin-top: 20%;
    font-size: 24px;
    color: green;
    animation: blink 1s infinite;
}
</style>
