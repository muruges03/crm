<template>
  <app-menu />
    <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <h2 class="text-lg font-semibold flex px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('leave')">
                       Add Leave Request
                    </inertia-link>
                </h2>
                <div class="px-4 py-4">
                    <form  @submit.prevent="store" >
                        <div class="grid grid-cols-6 gap-4">
                            <div class="col-span-12 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500">Employee</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2 flex">
                                    <Multiselect :value="this.employee.id"  :multiple="false" v-model="form.employee_id" select-label="" deselect-label="" track-by="id" label="first_name" class="!block"
                                                 placeholder="Select Employee" ref="customer_name" :options="this.employee" :searchable="true" :allow-empty="true">

                                    </Multiselect>
                                </div>
    <!--                             <div v-if="errors.employee_id" class="text-xs text-red-500">The Employee field is required.</div>-->
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500">Start Date</label>
                                <div class="sm:col-span-2">
                                    <Datepicker required class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="start_date" name="start_date"
                                                v-model="form.start_date" text-input  autoApply :enableTimePicker="false"
                                                id="start_date"  autocomplete="" placeholder=" Date" />
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500"> End Date</label>
                                <div class="sm:col-span-2">
                                    <Datepicker required class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                                ref="end_date" name="end_date" v-model="form.end_date"
                                                text-input autoApply :enableTimePicker="false"
                                                id="end_date"  autocomplete="off" placeholder="" />
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500">Employee</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2 flex">
                                    <Multiselect   :multiple="false" v-model="form.leave_type_id" select-label="" deselect-label="" class="!block"
                                                 placeholder="Select " ref="" :options="this.LeaveType" :searchable="true" :allow-empty="false">

                                    </Multiselect>
                                </div>
                                <!--                             <div v-if="errors.employee_id" class="text-xs text-red-500">The Employee field is required.</div>-->
                            </div>
                        </div>
                        <div class="p-2" v-if="$page.props.auth.user.can['create_products']==true">
                            <div class="flex justify-end ">
                                <jet-button type="submit">
                                    CREATE
                                </jet-button>
                            </div>
                        </div>
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
export default {
    metaInfo: { title: 'Product' },
    remember: 'form',
    components: {
        AppLayout,
            AppMenu,
            Welcome,
            Pagination,
            GrayButton,
            JetButton,
            JetInput
    },

  data() {
    return {

    }
},
    methods: {

  },
}


</script>

