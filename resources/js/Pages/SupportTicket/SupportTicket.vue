<script setup>
import { defineEmits } from "vue";
import useApplicationForm from "@/composables/useApplicationForm";
import AppInput from "@/components/AppInput.vue";
import AppTextarea from "@/components/AppTextarea.vue";
import SelectOptions from "@/components/SelectOptions.vue";
import RichEditor from "./components/RichEditor.vue";
import Appmenu from "@/Layouts/Appmenu.vue";
import Buttons from "./components/Buttons.vue";

const emit = defineEmits(["update:ShowTable", "update:viewemit"]);
const {
    form,
    errors,
    Status,
    submitForm,
    back,
} = useApplicationForm(emit);
</script>

<template>
    <Appmenu />
    <div class="lg:pl-64 flex flex-col bg-white p-8 m-10 right-0">
        <h2 class="text-2xl text-center font-semibold mb-4">Application Form</h2>
        <form @submit.prevent="submitForm" class="space-y-8">
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <AppInput v-model="form.legal_name" label="Legal Name" type="text" placeholder="Enter Legal Name" />
                    <p v-if="errors.legal_name" class="text-red-500 text-sm">{{ errors.legal_name }}</p>
                </div>
                <div>
                    <AppInput v-model="form.prefix" label="Prefix" type="text" placeholder="Enter Prefix" />
                    <p v-if="errors.prefix" class="text-red-500 text-sm">{{ errors.prefix }}</p>
                </div>
                <div>
                    <SelectOptions v-model="form.status" label="Service Status" :error="errors.status" :options="Status"
                        show="label" placeholder="Select service status" />
                </div>
                <div class="col-span-3">
                    <RichEditor v-model="form.description" label="Description" :error="errors.description" />
                </div>
            </div>
            <Buttons @back="back"/>

        </form>
    </div>
</template>
