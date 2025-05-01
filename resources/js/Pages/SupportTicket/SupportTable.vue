<script setup>
import { ref, computed, onMounted } from "vue";
import { VueDraggableNext } from "vue-draggable-next";
import axios from "axios";
import useKonBon from "@/composables/useKonBon";

const props = defineProps({ TicketSystem: Array });

const { fetchTickets,
    destroy,
    updateTatLevel,
    onDrop,
    ticketsByTatLevel,
    TicketSystemData,
    tatOptions,
   } = useKonBon(props)
</script>

<template>

    <div >

        <div class="flex gap-4">
            <div class="flex space-x-2 overflow-auto mx-auto min-h-screen p-2">
                <div
                    v-for="(tickets, level) in ticketsByTatLevel"
                    :key="level"
                    class="w-64 bg-white p-4 rounded-lg mx-4 shadow-lg border min-h-screen border-gray-200"
                >
                    <!-- Header -->
                    <h2 class="text-lg font-semibold text-center text-gray-700 mb-3 flex items-center justify-between">
                        <span>{{ level }}</span>
                        <button class="rounded-lg flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0" stroke="currentColor" class="w-6 text-white bg-gray-500 rounded-full">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </h2>


                    <!-- Draggable Container -->
                    <VueDraggableNext
                        group="tickets"
                        item-key="id"
                        @end="onDrop"
                        :data-level="level"
                        class="space-y-3 min-h-20 border-2 border-dashed border-gray-300 rounded-lg p-2 bg-gray-50"
                    >
                        <div
                            v-for="ticket in tickets"
                            :key="ticket.id"
                            :data-id="ticket.id"
                            class="bg-white p-3 rounded-lg shadow-md border border-gray-300 cursor-grab transition hover:shadow-lg"
                        >
                            <!-- Ticket Info -->
                            <component
            :is="$page.props.auth.user.can['edit_support'] ? 'inertia-link' : 'span'"
            :href="$page.props.auth.user.can['edit_support'] ? route('supportSystem.edit', ticket.id) : null"
            class="block text-center"
            :class=" $page.props.auth.user.can['edit_support'] == true ? 'text-blue-600 hover:text-blue-800 transition' : 'text-gray-500 cursor-not-allowed'"
        >
            <p class="text-sm font-bold text-gray-700">
                {{ ticket.customer?.legal_name ?? "N/A" }}
            </p>
            <p class="text-xs text-gray-500">
                {{ ticket.type?.type ?? "N/A" }}
            </p>
            <p class="text-xs text-gray-400">
                TAT Date: {{ ticket.tat_date ?? "N/A" }}
            </p>
        </component>

                            <!-- Actions -->
                            <div class="flex justify-between items-center mt-3">
                                <!-- Delete Button -->
                                <button v-if="$page.props.auth.user.can['delete_support'] == true"
                                    @click="destroy(ticket.id)"
                                    class="text-red-600 hover:text-red-800 transition p-1"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-5 h-5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                        />
                                    </svg>
                                </button>

                                <!-- Update Dropdown -->
                                <select
                                    v-model="ticket.tat_level"
                                    @change="updateTatLevel(ticket)"
                                    class="py-1 px-2 border border-gray-300 bg-white rounded-md text-xs focus:ring-2 focus:ring-blue-400 transition"
                                >
                                    <option value="null" selected hidden>Choose...</option>
                                    <option v-for="option in tatOptions" :key="option.id" :value="option.id">
                                        {{ option.id }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </VueDraggableNext>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.height{
    height: fit-content;
}
</style>
