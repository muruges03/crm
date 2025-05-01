<template>
    <div class="mt-8 bg-white rounded-xl shadow-lg p-6 transition-shadow duration-300 hover:shadow-xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Activity Overview</h2>
            <div class="flex space-x-2 bg-gray-100 p-1 rounded-lg">
                <button>
                    {{ formattedDate }}
                </button>
            </div>
        </div>
        <div v-if="Activity.length === 0"
            class="h-80 flex items-center justify-center bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200">
            <p class="text-gray-500 text-lg">No Preview Data</p>
        </div>
        <div v-else>
            <div class="card bg-white shadow-lg rounded-xl p-6 border border-gray-200">


                <DataTable :value="Activity" tableStyle="min-width: 50rem" :pt="{ tbody: { class: 'space-y-4 p-4' } }" stripedRows responsiveLayout="scroll"  :rowClass="() => 'custom-row-spacing'">

                    <Column header="Customer Name">
                        <template #body="slotProps">
                            <span class="font-semibold text-gray-800">
                                {{ slotProps.data.customer?.legal_name || 'N/A' }}
                            </span>
                        </template>
                    </Column>

                    <Column header="Service Type">
                        <template #body="slotProps">
                            <span class="text-blue-600">
                                {{ slotProps.data.type?.type || 'N/A' }}
                            </span>
                        </template>
                    </Column>

                    <Column field="tat_level" header="Level">
                        <template #body="slotProps">
                            <span class="px-3 py-1 rounded-lg text-white text-xs font-semibold" :class="slotProps.data.tat_level === 'High' ? 'bg-red-500' :
                                slotProps.data.tat_level === 'Medium' ? 'bg-yellow-500' : 'bg-green-500'">
                                {{ slotProps.data.tat_level || 'N/A' }}
                            </span>
                        </template>
                    </Column>

                    <Column header="Description">
                        <template #body="slotProps">
                            <div class="text-gray-700 text-sm" v-html="slotProps.data.description"></div>
                        </template>
                    </Column>

                    <Column header="Status">
                        <template #body="slotProps">
                            <Tag :value="slotProps.data.status === 1 ? 'Completed' : 'Incomplete'"
                                :severity="slotProps.data.status === 1 ? 'success' : 'danger'" />
                        </template>
                    </Column>

                    <template #footer >
                        <div class="text-gray-600 text-lg border-none">
                            <span class="font-semibold text-gray-800">{{ Activity?.[0]?.personal?.first_name ?? 'N/A'
                                }}</span>
                            made <span class="text-red-500 font-bold">{{ Activity ? Activity.length : 0 }}</span> calls.
                        </div>
                    </template>

                </DataTable>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed } from 'vue';
import { defineProps } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';


const getSeverity = (status) => {
    console.log(status)
    switch (status) {
        case 0:
            return 'inactive';

        case 1:
            return 'active';

        default:
            return 'inactive';
    }
};


const props = defineProps({
    Activity: Array,
    Date: [String, Array]
})
const formattedDate = computed(() => {
    if (!props.Date || props.Date.length !== 2) {
        return new Date().toLocaleDateString();
    }

    const startDate = new Date(props.Date[0]).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: '2-digit' });
    const endDate = new Date(props.Date[1]).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: '2-digit' });

    return `${startDate} - ${endDate}`;
});
</script>
<style>
.p-datatable-footer {
    border: none !important;
}

</style>
