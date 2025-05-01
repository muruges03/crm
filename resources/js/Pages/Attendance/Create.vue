<template>
  <app-menu />
    <div class="lg:pl-64 flex flex-col ">

<!--        v-if="$page.props.auth.user.can['employee_attendance']==true"-->
        <div class="px-4 py-4 "  v-if="$page.props.auth.user.can['create_attendance']==true" >
            <div class="shadow-lg rounded-md">
                <h2 class="text-lg font-semibold flex px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('attendance.index')">
                       Put Attendance
                    </inertia-link>
                </h2>
                <div class="px-4 py-4">
                    <form  @submit.prevent="store" >

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500">Employee</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2 flex">
                                    <Multiselect :value="this.employee.id" class="!block"  :multiple="false" v-model="form.employee_id" select-label="" deselect-label="" track-by="id" label="first_name"
                                                 placeholder="Select Employee" ref="customer_name" :options="this.employee" :searchable="true" :allow-empty="true">

                                    </Multiselect>
                                </div>
<!--                                <div v-if="errors.employee_id" class="text-xs text-red-500">The Employee field is required.</div>-->
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500"> Date</label>
                                <div class="sm:col-span-2">
                                    <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="date" name="date"
                                                v-if="$page.props.auth.user.can['create_attendance']==true"  v-model="form.date" autoApply :enableTimePicker="false"
                                                id="date"  autocomplete="" placeholder=" Date" />
                                </div>
<!--                                <div v-if="errors.date" class="text-xs text-red-500">The  date is required.</div>-->
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500"> Check In</label>
                                <div class="sm:col-span-2">
                                    <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="check_in" name="check_in" v-model="form.check_in"
                                                v-if="$page.props.auth.user.can['create_attendance']==true"  :enable-minutes="true" text-input autoApply :enableTimePicker="true"
                                                id="check_in"  autocomplete="off" placeholder="" />
                                </div>
<!--                                <div v-if="errors.check_in" class="text-xs text-red-500">The  check_in is required.</div>-->
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500"> Check Out</label>
                                <div class="sm:col-span-2">
                                    <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="check_out" name="check_out"
                                                v-if="$page.props.auth.user.can['create_attendance']==true"  :enable-minutes="true" text-input v-model="form.check_out" autoApply :enableTimePicker="true"
                                                id="check_out"  autocomplete="off" placeholder="" />
                                </div>
<!--                                <div v-if="errors.check_out" class="text-xs text-red-500">The  check_out is required.</div>-->
                            </div>
                        </div>
                        <div class="p-2 flex justify-end" >
                            <jet-button type="submit">
                                CREATE
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
],
  data() {
    return {
        message: '',
        messageType: '', // 'success' or 'error'
        form: this.$inertia.form({
            employee_id : null,
            date        : null,
            check_in    : null,
            check_out   : null,
        }),
    }
},
    methods: {

        // store() {
        //     // alert();
        // this.form.post(this.route('attendance.store'))
        // },

        async store() {
            axios.post(this.route('attendance.store',this.form))
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

