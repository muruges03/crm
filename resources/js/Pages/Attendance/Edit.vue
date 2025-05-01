<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <h2 class="text-lg font-semibold flex px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('attendance.index')">
                        Put Attendance
                    </inertia-link>
                </h2>
                <div class="px-4 py-4">
                    <form  @submit.prevent="destroy" >

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500">Employee</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2 flex">
                                    <Multiselect :value="this.employee.id" class="!block" :multiple="false" v-model="form.employee_id" select-label="" deselect-label="" track-by="id" label="first_name"
                                                 placeholder="Select Employee" ref="customer_name" :options="this.employee" :searchable="true" :allow-empty="true">

                                    </Multiselect>
                                </div>
                                <!--                                <div v-if="errors.employee_id" class="text-xs text-red-500">The Employee field is required.</div>-->
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500"> Date</label>
                                <div class="sm:col-span-2">
                                    <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="date" name="date"
                                                v-model="form.date" autoApply :enableTimePicker="false"
                                                id="date"  autocomplete="" placeholder=" Date" />
                                </div>
                                <!--                                <div v-if="errors.date" class="text-xs text-red-500">The  date is required.</div>-->
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500"> Check In</label>
                                <div class="sm:col-span-2">
                                    <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="check_in" name="check_in" v-model="form.check_in"
                                                :enable-minutes="true" text-input autoApply :enableTimePicker="true"
                                                id="check_in"  autocomplete="off" placeholder="" />
                                </div>
                                <!--                                <div v-if="errors.check_in" class="text-xs text-red-500">The  check_in is required.</div>-->
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500"> Check Out</label>
                                <div class="sm:col-span-2">
                                    <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="check_out" name="check_out"
                                                :enable-minutes="true" text-input v-model="form.check_out" autoApply :enableTimePicker="true"
                                                id="check_out"  autocomplete="off" placeholder="" />
                                </div>
                                <!--                                <div v-if="errors.check_out" class="text-xs text-red-500">The  check_out is required.</div>-->
                            </div>
                        </div>
                        <div class="p-2 flex justify-end" >
                            <jet-button type="submit" class="bg-red-500 hover:bg-red-700 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="size-2 w-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>

                                Delete
                            </jet-button>
                        </div>
                        <p v-if="message" :style="{ color: messageType === 'success' ? 'green' : 'red' }">{{ message }}</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import AppMenu from '@/Layouts/Appmenu.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import Pagination from '@/Jetstream/Pagination'
import GrayButton from '@/Jetstream/GrayButton.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import Multiselect from '@suadelabs/vue3-multiselect'
export default {
    metaInfo: { title: 'Attendance' },
    remember: 'form',
    components: {
        AppLayout,
        AppMenu,Datepicker,Multiselect,
        Welcome,
        Pagination,
        GrayButton,
        JetButton,
        JetInput
    },
    props:[
        'employee',
        'attendance'
    ],
    data() {
        return {
            message: '',
            messageType: '', // 'success' or 'error'
            form: this.$inertia.form({
                id :this.attendance.id,
                employee_id : this.attendance.employee_id[0],
                date        : this.attendance.date,
                check_in    : this.attendance.check_in,
                check_out   : this.attendance.check_out,
            }),
        }
    },
    methods: {

        // store() {
        //     // alert();
        // this.form.post(this.route('attendance.store'))
        // },

        async destroy() {
            axios.delete(this.route('attendance.destroy',this.form.id))
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
}


</script>

