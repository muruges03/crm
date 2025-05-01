<template>
    <Appmenu />
    <div class="lg:pl-64 flex flex-col bg-white p-4 justify-end right-0">
        <CreateForm :TicketSystem="TicketSystem"/>
    </div>
</template>

<script setup>
import { ref, provide } from "vue";
import Appmenu from '@/Layouts/Appmenu.vue';
import CreateForm from "@/Pages/SupportTicket/Create.vue"

const props = defineProps({
    ServiceType: Array,
    ServiceBy: Array,
    Customers: Array,
    TicketSystem: Array,
    UserGrp: Array,
    Application: Array,
});
const ServiceType = ref(props.ServiceType);
const ServiceBy = ref(props.ServiceBy);
const Customers = ref(props.Customers);
const UserGrp = ref(props.UserGrp);
const Application = ref(props.Application);

provide("ServiceType", ServiceType);
provide("ServiceBy", ServiceBy);
provide("Customers", Customers);
provide("UserGrp", UserGrp);
provide("Application", Application);


</script>
