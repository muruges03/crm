<script setup>
import { ref, watch } from "vue";
import axios from "axios";
import SettingMenu from "@/Pages/SupportTicket/SettingMenu.vue"
import SupportSystem from "@/Pages/SupportTicket/SupportSystem.vue";
import SupportTicket from "@/Pages/SupportTicket/SupportTicket.vue";
import SupportTable from "@/Pages/SupportTicket/SupportTable.vue";

const activeTab = ref("view");
const message = ref('');
const isError = ref(false);

const props = defineProps({
    TicketSystem: Array
});

const TicketSystemData = ref([...props.TicketSystem]);

watch(() => props.TicketSystem, (newTickets) => {
    TicketSystemData.value = [...newTickets];
}, { deep: true });

const fetchTickets = async () => {
    try {
        const response = await axios.get("/api/support-tickets");
        TicketSystemData.value = response.data;
    } catch (error) {
        console.error("Failed to fetch ticket system data:", error);
        isError.value = false;
        message.value = "Failed to update tickets. Reloading...";
        setTimeout(() => {
            window.location.reload();
        }, 3000);
    }
};

const updateTicketSystem = async (newMessage) => {
    activeTab.value = 'view';
    message.value = newMessage;
    isError.value = false;

    await fetchTickets();

    setTimeout(() => {
        message.value = '';
    }, 3000);
};

const viewemit = () => {
    activeTab.value = 'view';
};
</script>

<template>
  <div
    v-if="message"
    class="fixed top-20 right-4 px-4 py-2 rounded-lg shadow-lg transition-opacity duration-500"
    :class="isError ? 'bg-red-500 text-white' : 'bg-indigo-900 text-white'">
    {{ message }}
  </div>

  <div :class="{'flex container space-x-2 justify-between mx-auto':true,'hidden':activeTab === 'system'}" >
    <div class="mx-5 flex items-center">
        <h1 class="text-indigo-900 text-xl font-bold">Support Tickets</h1>
    </div>
    <div class="flex space-x-4 justify-between">
        <button v-if="$page.props.auth.user.can['edit_support']"
      @click="activeTab = 'system'"
      :class="activeTab === 'system' ? 'bg-gray-200 text-black cursor-not-allowed' :  'bg-indigo-900 text-white'"
      class="px-4 rounded-lg">
       Create
    </button>
     <setting-menu />
    </div>

  </div>

  <div class="flex container overflow-auto mx-auto">
    <SupportTable v-if="activeTab === 'view'" :TicketSystem="TicketSystemData"/>
    <SupportSystem v-if="activeTab === 'system'" @update:SupportSystem="updateTicketSystem" @update:viewemit="viewemit"/>
    <!-- <SupportTicket v-if="activeTab === 'application'" @update:ShowTable="ShowActiveTap" @update:viewemit="viewemit"/> -->
  </div>
</template>
