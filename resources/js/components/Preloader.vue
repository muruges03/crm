<template>
    <div v-if="show" class="preloader-wrapper">
        <img class="loader" :src="getPreloader" alt="Loading..." />
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";

const show = ref(false);
const page = usePage();

const preloaders = {
    "/dashboard": "/images/dashboard.gif",
    "/home": "/images/home.gif",
    "/entities": "/images/enterprise.gif",
    "/user": "/images/worker.gif",
    "/support": "/images/helpdesk.gif",
    "/settings": "/images/settings.gif",
    "/defaultSetting": "/images/settings.gif",
    "/personnel": "/images/telecommuting.gif",
    "/invoice": "/images/invoice.gif",
    "/tax": "/images/tax.gif",
    "/ledger": "/images/inheritance.gif",
    "/payment": "/images/money.gif",
    "/expense": "/images/money.gif",
    "/products": "/images/box.gif",
    "/account": "/images/writing.gif",
    "/accounts": "/images/writing.gif",
    "/accountType": "/images/writing.gif",
    "/customer": "/images/customer-care.gif",
    "/report": "/images/checklist.gif",
};
let currentPath = ref('/');

const getPreloader = computed(() => {

    if (preloaders[currentPath.value]) {
     
        return preloaders[currentPath.value];
    }

    const firstSegment = '/' + currentPath.value.split('/')[1];
    if (preloaders[firstSegment]) {
        return preloaders[firstSegment];
    }

    return "/images/default-loader.gif";
});


Inertia.on("start", (event) => {
    const url = new URL(event.detail.visit.url, window.location.origin);
    
    if (url.search) {
        return;
    }

    currentPath.value = url.pathname;

    setTimeout(() => {
        show.value = true;
    }, 50);
});
Inertia.on("finish", () => {
    show.value = false;
});
</script>

<style>
.preloader-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}


.loader {
    width: 100px;
    height: 100px;
}
</style>
