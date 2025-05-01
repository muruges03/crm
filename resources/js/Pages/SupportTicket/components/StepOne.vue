<script setup>
import { defineProps, defineEmits } from "vue";
import SelectOptions from "@/components/SelectOptions.vue";
import DateTimePicker from "@/components/DateTimePicker.vue";
import AppInput from "@/components/AppInput.vue";
import RichEditor from "./RichEditor.vue";
const props = defineProps(["form", "errors","Application", "ServiceType", "ServiceBy", "Customers", "Status", 'UserGrp']);
const emit = defineEmits(["update:form"]);



const tatOptions = [
   { "id": "Service Call", "label": "Service Call" },
   { "id": "Requirement", "label": "Requirement" },
   { "id": "Possible", "label": "Possible" },
   { "id": "Not Possible", "label": "Not Possible" },
   { "id": "Testing", "label": "Testing" },
   { "id": "Deployed", "label": "Deployed" },
   { "id": "Done", "label": "Done" },
];
</script>

<template>
    <div class="grid grid-cols-6 gap-6">
        <div class="col-span-2">
            <SelectOptions v-model="form.service_type" label="Service Type" :error="errors.service_type"
                :options="ServiceType" show="type" placeholder="Select a service type" />
        </div>

        <div class="col-span-2">
            <SelectOptions v-model="form.service_by" label="Service Provider" :error="errors.service_by"
                :options="ServiceBy" show="first_name" placeholder="Select a service provider" />
        </div>

        <div class="col-span-2">
            <SelectOptions v-model="form.customer_id" label="Customer" :error="errors.customer_id"
                :options="Customers" show="legal_name" placeholder="Select a customer" />
        </div>

        <div class="col-span-2">
            <SelectOptions v-model="form.application_id" label="Application" :error="errors.application"
                :options="Application" show="legal_name" placeholder="Select service application" />
        </div >
        <div class="col-span-2">
            <SelectOptions v-model="form.tat_level" :options="tatOptions" label="TAT Level" show="label"
                :error="errors.tat_level" placeholder="Select TAT level" />
        </div>
        <div class="col-span-2">
            <SelectOptions v-model="form.made_by" :options="UserGrp" label="User Group" show="title"
                :error="errors.made_by" placeholder="Select user group" />
        </div>
        <div class="col-span-3">
            <app-input v-model="form.client_name"  label="Client Name"
                :error="errors.client_name" placeholder="Enter Name..." />
        </div>
        <div class="col-span-3">
            <SelectOptions v-model="form.status" :options="Status" label="Status" show="label"
                :error="errors.status" />
        </div>
        <div class="col-span-3">
            <DateTimePicker v-model="form.date" :error="errors.date || ''" label="Start Date & Time" />
        </div>

        <div class="col-span-3">
            <DateTimePicker v-model="form.tat_date" :error="errors.tat_date || ''" label="Expected Completion Date" />
        </div>
        <div class="col-span-6">
            <RichEditor v-model="form.description" :error="errors.description" label="Service Description" />
        </div>
    </div>
</template>
