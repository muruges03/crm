<script setup>
import { defineEmits } from "vue";
import useSystemForm from "@/composables/useSystemForm";
import StepOne from "@/Pages/SupportTicket/components/StepOne.vue";
import Buttons from "@/Pages/SupportTicket/components/Buttons.vue";

const emit = defineEmits(["update:SupportSystem", "update:viewemit"]);
const {
    form,
    errors,
    ServiceType,
    ServiceBy,
    Customers,
    UserGrp,
    Status,
    Application,
    submitForm,
    back
} = useSystemForm(emit);
</script>

<template>
    <div class="container max-w-5xl mx-auto px-8 pb-2 pt-0 bg-white shadow-lg rounded-xl">
        <h2 class="text-2xl text-center font-semibold mb-4">Support Ticket Form</h2>
        <form @submit.prevent="submitForm" class="space-y-8">
            <StepOne  v-model:form="form" :errors="errors" :ServiceType="ServiceType" :ServiceBy="ServiceBy" :Customers="Customers" :Status="Status" :UserGrp="UserGrp" :Application="Application"/>
            <Buttons  @back="back" />
        </form>
    </div>
</template>
