<template>
    <div>
        <div class="px-4 py-4">
            <h2 class="text-lg font-semibold flex"> Employee Report</h2>
        </div>
        <form @submit.prevent="validateForm">
            <div class="grid grid-cols-7 gap-4  items-end ">
                <div class="col-span-2">
                    <DatePicker multiple  v-model="form.date" placeholder="Select Date" label="Date" />
                </div>
                <div class="col-span-2">
                    <SelectOptions
                      class="col-span-2"
                        v-model="form.employee"
                        :options="Employee"
                        show="first_name"
                        placeholder="Select Service Engineer"
                        label="Service Engineer" />
                </div>
                <button  class="py-1.5 px-3 min-w-40 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d628bbf] hover:bg-[#0d628bbf] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d628bbf]">
                        Generate
                </button>
            </div>
        </form>
    </div>

</template>
<script setup>
import DatePicker from '@/components/DatePicker.vue';
import SelectOptions from '@/components/SelectOptions.vue'
import { ref } from 'vue';

const form = ref({
    date: '',
    employee:'',

}
)
const errors = ref({
    date: '',
    employee: ''
});
const props = defineProps({
    Employee:Array
})
const validateForm = () => {
    errors.value.date = form.value.date.length ? '' : 'Date is required';
    errors.value.employee = form.value.employee ? '' : 'employee is required';

    if (!errors.value.date && !errors.value.employee) {
        console.log('Submitting request:', form.value);

        const baseUrl = '/report/get-employee-report';
        const params = new URLSearchParams();

        if (Array.isArray(form.value.date) && form.value.date.length === 2) {
            const startDate = new Date(form.value.date[0]).toISOString().split('T')[0];
            const endDate = new Date(form.value.date[1]).toISOString().split('T')[0];

            params.append('startDate', startDate);
            params.append('endDate', endDate);
        }

        params.append('employee', form.value.employee);

        const url = `${baseUrl}?${params.toString()}`;

        window.open(url);
    }
};

</script>
