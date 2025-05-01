<template>
    <div v-if="uniqueServiceTypes.length  != 0" class="py-6">
        <h2 class="text-xl font-semibold mb-4">Service Types Summary</h2>

        <DataTable  :value="uniqueServiceTypes" stripedRows responsiveLayout="scroll" class="custom-datatable"
            @rowClick="selectServiceType">
            <Column field="name">
                <template #header>
                    <span class="header-text">SERVICE NAME & COUNT</span>
                </template>
                <template #body="slotProps" >
                    <span class="service-name"  v-tooltip="'Click to view details: ' + slotProps.data.name">{{ slotProps.data.name }}</span>
                </template>
            </Column>

            <Column field="count">
                <template #header>
                    <span class="header-text"></span>
                </template>
                <template #body="slotProps">
                    <span class="count-badge" v-tooltip="'Count are: ' + slotProps.data.count">{{ slotProps.data.count }}</span>
                </template>
            </Column>
        </DataTable>



        <div v-if="selectedServiceType" class="mt-6">
            <h3 class="text-lg font-semibold mb-3">
                Details for Service Type: {{ selectedServiceType.name }}
            </h3>

            <Accordion multiple>
                <AccordionTab v-for="(group, key) in groupedData" :key="key"
                    :header="`Customer: ${group.customer_name} | Service By: ${group.service_by}`">
                    <DataTable :value="group.details" stripedRows responsiveLayout="scroll">
                        <Column field="id" header="Ticket ID"></Column>
                        <Column field="date" header="Date"></Column>
                        <Column field="tat_level" header="TAT Level"></Column>
                        <Column field="description" header="Description">
                            <template #body="slotProps">
                                <span v-html="slotProps.data.description"></span>
                            </template>
                        </Column>
                    </DataTable>
                </AccordionTab>
            </Accordion>
        </div>
    </div>
</template>
<script setup>
import { computed, ref } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from 'primevue/card';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import { Tab } from 'primevue';

const props = defineProps({
  data: Array
});
const table = ref(false)
const selectedServiceType = ref(null);

const uniqueServiceTypes = computed(() => {
  if (!Array.isArray(props.data) || props.data.length === 0) {
    return [];
  }

  const serviceTypeCounts = {};

  props.data.forEach(item => {
    table.value  = true
    if (item.service_type && item.type?.type) {
      const key = item.service_type;
      if (!serviceTypeCounts[key]) {
        serviceTypeCounts[key] = { service_type: item.service_type, name: item.type.type, count: 0 };
      }
      serviceTypeCounts[key].count += 1;
    }
  });

  return Object.values(serviceTypeCounts);
});

const groupedData = computed(() => {
  if (!selectedServiceType.value || !Array.isArray(props.data) || props.data.length === 0) {
    return {};
  }

  const filteredData = props.data.filter(
    item => item.service_type === selectedServiceType.value.service_type
  );

  const grouped = {};

  filteredData.forEach(item => {
    const key = `${item.customer?.legal_name || 'Unknown'} - ${item.personal?.legal_name || 'Unknown'}`;
    if (!grouped[key]) {
      grouped[key] = {
        customer_name: item.customer?.legal_name || 'Unknown',
        service_by: item.personal?.first_name || 'Unknown',
        details: []
      };
    }
    grouped[key].details.push(item);
  });

  return grouped;
});

// Handle row click
const selectServiceType = (event) => {
  selectedServiceType.value = event.data;
};
</script>


<style scoped>
.cursor-pointer tr {
    cursor: pointer;
}

.custom-datatable {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #e0e0e0;
}

:deep(.p-datatable thead th) {
    background:#f80759;
    color: white;
    font-weight: bold;
    text-align: left;
    padding: 12px;
}

:deep(.p-datatable tbody tr:hover) {
    background: #f4f6f9;
    cursor: pointer;
    transition: background 0.2s ease-in-out;
}

:deep(.p-datatable tbody tr) {
    border-bottom: 1px solid #e0e0e0;
}

/* Column Text Styling */
.service-name {
    font-weight: 600;
    color: #333;
}

.count-badge {
    background:#f80759;
    color: white;
    padding: 6px 12px;
    border-radius: 10px;
    font-weight: bold;
    display: inline-block;
    min-width: 40px;
    text-align: center;
}

/* Header Text */
.header-text {
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: white;

}

</style>
