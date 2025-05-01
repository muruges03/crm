<script setup>
import { ref, computed, toRaw, watch } from 'vue'
import Appmenu from '@/Layouts/Appmenu.vue';
import DashboardCard from '@/components/DashboardCard.vue'
import EngineerData from '@/components/EngineerData.vue';
import axios from 'axios';
import DashboardGraph from '@/components/DashboardGraph.vue';
import DashboardDateWise from '@/components/DashboardDateWise.vue';
import DatePicker from '@/components/DatePicker.vue';

const date = ref('');
const dateWiseData = ref('');
const props = defineProps({
    Tickets: Array,
    formattedData: Array
})
const Activity = ref('')
const updateEngineerData = (id) => {
    console.log(id, date)
    axios.get('/get-engineer-data', { params: { id, date: toRaw(date.value) } }).then(res => {
        Activity.value = res.data[0];
    }).catch(error => {
        console.error('Error fetching engineer data:', error);
    });

}
const filterPersonal = computed(() => {
    const uniqueId = new Set();
    return props.Tickets.filter(ticket => {
        if (ticket.personal) {
            const id = ticket.personal.id;
            if (!uniqueId.has(id)) {
                uniqueId.add(id);
                return true;
            }
        }
        return false;
    }).map(ticket => {
        const fullName = `${ticket.personal.first_name} ${ticket.personal.last_name}`;
        return {
            id: ticket.personal.id,
            name: fullName.length > 15 ? fullName.substring(0, 13) + '...' : fullName
        };
    });
});
watch(date, async (newDates) => {
  if (!newDates || newDates.length === 0) return;
  const formattedDates = newDates.map(d => d.toISOString().split("T")[0]);
  try {
    const response = await axios.get("/get-datewise-data", {
      params: { date: formattedDates  },
    });
   console.log(response.data)
    dateWiseData.value = response.data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
});
</script>

<template>
    <Appmenu />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:pl-72  p-8">
        <div class="mb-8">
            <p class="mt-3 text-lg text-gray-600">Welcome back! Here's your business at a glance.</p>
        </div>
        <DashboardGraph :FormattedData="formattedData" />
        <div class=" my-4">
            <DatePicker v-model="date" multiple />
        </div>
        <div>
            <DashboardDateWise :data="dateWiseData[0]"/>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="personal in filterPersonal" :key="personal.id">
                <DashboardCard :id="personal.id" :title="personal.name" @engineerData="updateEngineerData" />

            </div>
        </div>

        <EngineerData :Date="date" :User="User" :Activity="Activity" />
    </div>
</template>
<style>
.dp__pointer{
    height:31px!important;
}
</style>
