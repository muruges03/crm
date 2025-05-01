<template>
    <div>
        <div class="px-4 py-4">
            <h2 class="text-lg font-semibold flex">Monthly Report</h2>
        </div>
        <form @submit.prevent="validateForm">
            <div class="grid grid-cols-7 gap-4 items-end">
                <div class="col-span-2">
                    <DatePicker
                        multiple
                        v-model="form.date"
                        placeholder="Select Date"
                        label="Date"
                        :customClass="errors.date ? 'border-2 border-red-500 rounded' : ''"
                    />
                </div>
                <div class="col-span-2">
                    <SelectOptions
                        v-model="form.customer"
                        :options="patron"
                        show="legal_name"
                        placeholder="Select Customer"
                        label="Customer"
                        :customClass="errors.customer ? 'border-2 border-red-500 rounded' : ''"
                    />
                </div>
                <button
                    type="submit"
                    class="py-1.5 col-span-1 px-3 min-w-40 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d628bbf] hover:bg-[#0d628bbf] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d628bbf]"
                >
                    Generate
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import DatePicker from '@/components/DatePicker.vue';
import SelectOptions from '@/components/SelectOptions.vue';
import { ref } from 'vue';
const form = ref({
    date: [], 
    customer: null
});

const errors = ref({
    date: '',
    customer: ''
});

defineProps({
    patron: Array
});

const validateForm = () => {
    errors.value.date = form.value.date.length ? '' : 'Date is required';
    errors.value.customer = form.value.customer ? '' : 'Customer is required';

    if (!errors.value.date && !errors.value.customer) {
        console.log('Submitting request:', form.value);

        const baseUrl = '/report/get-ticket-report';
        const params = new URLSearchParams();

        if (Array.isArray(form.value.date) && form.value.date.length === 2) {
            const startDate = new Date(form.value.date[0]).toISOString().split('T')[0];
            const endDate = new Date(form.value.date[1]).toISOString().split('T')[0];

            params.append('startDate', startDate);
            params.append('endDate', endDate);
        }

        params.append('customer', form.value.customer);

        const url = `${baseUrl}?${params.toString()}`;

        window.open(url, '_blank');
    }
};
</script>
