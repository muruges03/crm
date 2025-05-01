<template>
    <div>
        <div class="px-4 py-4">
            <h2 class="text-lg font-semibold flex"> Day Report</h2>
        </div>
        <form>
            <div class="grid grid-cols-7 gap-4  items-end ">
                <div class="col-span-2">
                    <DatePicker multiple  v-model="form.date" placeholder="Select Date" label="Date" />
                </div>
                <div class="col-span-2">
                    <SelectOptions
                      class="col-span-2"
                        v-model="form.customer"
                        :options="patron"
                        show="legal_name"
                        placeholder="Select Customer"
                        label="Customer" />
                </div>
                <button  class="py-1.5 px-3 min-w-40 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d628bbf] hover:bg-[#0d628bbf] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d628bbf]">
                    <a :href="route('report.get-customer-report', form)"
                       >
                        Generate
                    </a>
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
    customer:''
}
)
const props = defineProps({
    patron:Array
})


</script>
