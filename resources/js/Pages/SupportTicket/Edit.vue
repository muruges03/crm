<script setup>
import { defineProps, defineEmits } from "vue";
import useSupportForm from "@/composables/useSupportForm";
import StepOne from "@/Pages/SupportTicket/components/StepOne.vue";
import Buttons from "@/Pages/SupportTicket/components/Buttons.vue";
import Appmenu from "@/Layouts/Appmenu.vue";

const props = defineProps({
    EditData: Object,
    ServiceType: Array,
    ServiceBy: Array,
    Customers: Array,
    UserGrp: Array,
    Application: Array,
});

const emit = defineEmits(["update:SupportSystem"]);
const {
    form,
    errors,
    id,
    Status,
    back,
    UpdateForm
} = useSupportForm(props, emit);
</script>

<template>
    <Appmenu />
    <div class="lg:pl-64 flex flex-col bg-white p-4 items-end justify-end right-0">
        <div class="container max-w-5xl mx-auto p-8 bg-white rounded-xl">
            <h2 class="text-2xl text-center font-semibold mb-4">Edit Support System</h2>
            <form @submit.prevent="UpdateForm" class="space-y-8">
                <StepOne
                    v-model:form="form"
                    :errors="errors"
                    :ServiceType="ServiceType"
                    :ServiceBy="ServiceBy"
                    :Customers="Customers"
                    :Status="Status"
                    :UserGrp="UserGrp"
                    :Application="Application"
                />
                <Buttons  @back="back" />
            </form>
        </div>
    </div>
</template>
