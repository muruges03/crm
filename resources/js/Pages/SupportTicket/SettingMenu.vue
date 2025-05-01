<template>
    <div class="relative">
        <div v-if="message" class="fixed top-4 left-3/4 transform  bg-blue-900 text-white px-4 py-2 rounded shadow-lg z-50">
            {{ message }}
        </div>

        <svg @click="dialog = !dialog" viewBox="0 0 1024 1024" class="h-8 w-8 cursor-pointer"
                xmlns="http://www.w3.org/2000/svg" fill="#000000">
                <g id="SVGRepo_iconCarrier">
                    <path fill="#000000"
                        d="M600.704 64a32 32 0 0 1 30.464 22.208l35.2 109.376c14.784 7.232 28.928 15.36 42.432 24.512l112.384-24.192a32 32 0 0 1 34.432 15.36L944.32 364.8a32 32 0 0 1-4.032 37.504l-77.12 85.12a357.12 357.12 0 0 1 0 49.024l77.12 85.248a32 32 0 0 1 4.032 37.504l-88.704 153.6a32 32 0 0 1-34.432 15.296L708.8 803.904c-13.44 9.088-27.648 17.28-42.368 24.512l-35.264 109.376A32 32 0 0 1 600.704 960H423.296a32 32 0 0 1-30.464-22.208L357.696 828.48a351.616 351.616 0 0 1-42.56-24.64l-112.32 24.256a32 32 0 0 1-34.432-15.36L79.68 659.2a32 32 0 0 1 4.032-37.504l77.12-85.248a357.12 357.12 0 0 1 0-48.896l-77.12-85.248A32 32 0 0 1 79.68 364.8l88.704-153.6a32 32 0 0 1 34.432-15.296l112.32 24.256c13.568-9.152 27.776-17.408 42.56-24.64l35.2-109.312A32 32 0 0 1 423.232 64H600.64zm-23.424 64H446.72l-36.352 113.088-24.512 11.968a294.113 294.113 0 0 0-34.816 20.096l-22.656 15.36-116.224-25.088-65.28 113.152 79.68 88.192-1.92 27.136a293.12 293.12 0 0 0 0 40.192l1.92 27.136-79.808 88.192 65.344 113.152 116.224-25.024 22.656 15.296a294.113 294.113 0 0 0 34.816 20.096l24.512 11.968L446.72 896h130.688l36.48-113.152 24.448-11.904a288.282 288.282 0 0 0 34.752-20.096l22.592-15.296 116.288 25.024 65.28-113.152-79.744-88.192 1.92-27.136a293.12 293.12 0 0 0 0-40.256l-1.92-27.136 79.808-88.128-65.344-113.152-116.288 24.96-22.592-15.232a287.616 287.616 0 0 0-34.752-20.096l-24.448-11.904L577.344 128zM512 320a192 192 0 1 1 0 384 192 192 0 0 1 0-384zm0 64a128 128 0 1 0 0 256 128 128 0 0 0 0-256z">
                    </path>
                </g>
            </svg>

        <div v-if="dialog" class="absolute top-8 right-0 bg-white shadow-lg rounded-lg p-4 w-48">
            <div class="flex items-center cursor-pointer gap-3 hover:bg-gray-200 p-2" @click="showForm('service')">
                <PlusSvg />
                <p>Service Type</p>
            </div>
            <div class="flex items-center cursor-pointer gap-3 hover:bg-gray-200 p-2" @click="showForm('group')">
                <PlusSvg />
                <p>Group User</p>
            </div>
            <Link class="flex items-center cursor-pointer gap-3 hover:bg-gray-200 p-2" href="/support/create">
                <PlusSvg />
                <p>Application</p>
            </Link>
        </div>

        <!-- Reusable Popup Form -->
        <div v-if="formVisible"
            class="fixed inset-0 z-10 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md"
            @click="formVisible = false">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96" @click.stop>
                <h2 class="text-lg font-bold mb-4">{{ formType === 'service' ? 'Add Service Type' : 'Add Group User' }}</h2>
                <AppInput v-model="inputValue" type="text"
                    :placeholder="formType === 'service' ? 'Service Name' : 'Group Name'"
                    class="w-full p-2 border rounded mb-4" />
                <span v-if="error" class="text-red-500">{{ error }}</span>
                <div class="flex justify-end">
                    <button @click="cancelForm"
                        class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button @click="submitForm"
                        class="bg-gray-600 bg-opacity-75 text-white px-4 py-2 rounded ml-2">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import AppInput from "@/components/AppInput.vue";
import PlusSvg from "./components/PlusSvg.vue";
import { set } from "lodash";
import { Link } from "@inertiajs/inertia-vue3";

const dialog = ref(false);
const formVisible = ref(false);
const formType = ref("");
const inputValue = ref("");
const error = ref("");
const message = ref('')

const showForm = (type) => {
    formType.value = type;
    formVisible.value = true;
    dialog.value = false;
};
const cancelForm =() => {
    formVisible.value = false;
    inputValue= ''
}

const submitForm = async () => {
    if (!inputValue.value.trim()) {
        error.value = formType.value === 'service' ? 'Service type is required' : 'Group name is required';
        return;
    }
    error.value = '';

    try {
        const endpoint = formType.value === 'service' ? '/supportType' : '/addGroup';
        const datatype = formType.value === 'service' ? 'type' : 'title'
        await axios.post(endpoint, { [datatype]: inputValue.value }).then((res) => message.value = res.data );
        formVisible.value = false;
        inputValue.value = '';
        setTimeout(() => {
        message.value =''
        }, 3000);
    } catch (err) {
        console.error("Error submitting form:", err);
    }
};
</script>
