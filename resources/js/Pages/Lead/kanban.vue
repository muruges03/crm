<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col bg-white divide-x divide-gray-200 border-2 shadow-md">
        <div class="border-b border-gray-200 px-2 py-2 flex sm:items-center justify-between sm:px-2 lg:px-8">
            <h2 class=" text-1xl min-w-0 font-bold">
                Team Project Board <span
                    class="text-sm bg-gray-400 px-1 py-1 rounded-full text-sm text-white">{{ lead.data.length }}</span>
            </h2>
            <div class=" sm:mt-0 sm:ml-4 ">
                <jet-button type="button">
                    <inertia-link :href="route('lead.create')">Create</inertia-link>
                </jet-button>
            </div>
        </div>
        <!-- filter popup -->
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" v-if="isFilter">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <form class="border-2 p-2" @submit.prevent="filter" autocomplete="off">
                        <div class="grid grid-cols-6 gap-4">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="purchase_date" class="block text-sm font-medium text-gray-700"> From
                                    Date</label>
                                <Datepicker range multiCalendars
                                    class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                    ref="date" name="date" v-model="form.date" autoApply :enableTimePicker="false"
                                    id="date" autocomplete="date" placeholder="Date" />
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <jet-input list="city" type="text" v-model="form.city" name="city" />
                                <datalist id="city">
                                    <option v-for="city_name in city" :value="city_name.city" :key="city_name.city"
                                        class="text-md">
                                        {{ city_name.city }}
                                    </option>
                                </datalist>
                                <div v-if="form.errors.city" class="text-red-500 text-xs">{{ form.errors.city }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="state_name" class="block text-sm font-medium text-gray-700">State</label>
                                <jet-input list="state_name" type="text" v-model="form.state_name" name="state_name" />
                                <datalist id="state_name">
                                    <option v-for="state_name in state" :value="state_name.state_name"
                                        :key="state_name.state_name" class="text-md">
                                        {{ state_name.state_name }}
                                    </option>
                                </datalist>
                                <div v-if="form.errors.state_name" class="text-red-500 text-xs">{{
                                    form.errors.state_name }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="city" class="block text-sm font-medium text-gray-700">Lead Contact
                                    No</label>
                                <jet-input type="number" v-model="form.lcn" name="lcn" id="lcn" />
                                <div v-if="form.errors.lcn" class="text-red-500 text-xs">{{ form.errors.city }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="ccn" class="block text-sm font-medium text-gray-700">Contact No</label>
                                <jet-input type="number" v-model="form.ccn" name="ccn" id="ccn" />
                                <div v-if="form.errors.ccn" class="text-red-500 text-xs">{{ form.errors.ccn }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="user" class="block text-sm font-medium text-gray-700">User</label>
                                <select v-model='form.user'
                                    class="mt-2 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="null" disabled selected hidden>Choose.</option>
                                    <option v-for='data in user' :key='data.id' :value='data.id'>{{ data.first_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6 flex justify-between">
                            <gray-button type="button" @click="isFilter = false">
                                Cancel
                            </gray-button>
                            <jet-button type="submit">
                                Search
                            </jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End filter popup -->
        <div class="border-b border-gray-200 px-4 py-4 flex w-full sm:items-center md:justify-between sm:px-6 lg:px-8">
            <div class="block flex">
                <a :href="route('settings.import')" target="_blank"> <svg
                        class="w-8 h-8 text-indigo-600 stroke-current mt-2 flex" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg></a>
            </div>
            <div class="inline-flex md:mt-0 mt-2 md:flex ">
                <select id="" v-model="data" @change="kanbanchange(data)" name=""
                    class="block  focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-full">
                    <option value="lead" Selected>Lead</option>
                    <option value="ass">Assigned</option>
                    <option value="person">Person</option>
                </select>
                <input v-if="islead" name="table_search" v-model="term" @keyup="searchlead" type="text"
                    autocomplete="off"
                    class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-gray-200 rounded-full focus:outline-none focus:ring "
                    placeholder="Search Lead Name ..." />
                <input v-if="isass" name="table_search" v-model="ass" @keyup="searchass" type="text" autocomplete="off"
                    class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-gray-200 rounded-full focus:outline-none focus:ring "
                    placeholder="Search Assigned Name ..." />
                <input v-if="isperson" name="table_search" v-model="person" @keyup="searchperson" type="text"
                    autocomplete="off"
                    class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-gray-200 rounded-full focus:outline-none focus:ring "
                    placeholder="Search person Name ..." />
                <svg @click="openFilter()" xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-20 text-gray-400  md:ml-2 md:mt-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </div>
        </div>
        <div class="relative p-2 flex overflow-auto h-full">
            <div v-for="status in leadPipelineStage" :key="status.id" class="mr-6 w-4/5 max-w-xs flex-shrink-0">
                <div class="rounded-md shadow-md  bg-blue-100 p-2 ">
                    <div class="flex items-center flex-shrink-0 h-10 px-2">
                        <span class="block text-sm font-semibold"> {{ status.lead_stage }}</span>
                        <!-- <span class="flex items-center justify-center w-5 h-5 ml-2 text-sm font-semibold text-indigo-500 bg-white rounded bg-opacity-30">6</span> -->
                        <inertia-link :href="route('lead.create')"
                            class="flex items-center justify-center  ml-auto text-indigo-500 rounded hover:bg-indigo-500 hover:text-indigo-100">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </inertia-link>
                    </div>
                    <div class="p-1 flex flex-col pb-2 overflow-auto">
                        <div class="flex-1 flex flex-col h-full rounded shadow-xs">
                            <transition-group class="flex flex-col overflow-auto" tag="div">
                                <draggable v-for="leads in lead.data" :key="leads.id" :id="status.id" :leads="leads"
                                    @dragover.prevent @drop="drop" class="dragArea list-group w-full"
                                    v-bind="taskDragOptions" @dragover="handleTaskMoved(leads)">
                                    <!-- <inertia-link :href="route('lead.edit', leads.id)">    -->
                                    <div draggable="true" v-show="status.id === leads.lead_pipeline_stage_id"
                                        class="relative flex flex-col items-start p-4 mt-3 bg-white rounded-lg cursor-pointer bg-opacity-90 group hover:bg-opacity-100">
                                        <span
                                            class="flex items-center  px-3 text-xs font-semibold text-green-500 bg-green-100 rounded-full">
                                            <inertia-link :href="route('lead.edit', leads.id)">{{ leads.lead_name
                                                }}</inertia-link>
                                        </span>
                                        <div
                                            class="flex justify-between items-center w-full text-xs text-gray-400 h-6 mt-2">
                                            <div class="flex">
                                                <inertia-link :href="route('lead.edit', leads.id)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </inertia-link>
                                                <inertia-link class="mt-2" :href="route('lead.edit', leads.id)">
                                                    <span class="ml-1 mt-4  leading-none">{{ leads.city }}</span>
                                                </inertia-link>
                                            </div>
                                            <div class="relative flex  ml-4">
                                                <inertia-link :href="route('lead.edit', leads.id)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                </inertia-link>
                                                <inertia-link :href="route('lead.edit', leads.id)" class="mt-2">
                                                    <span class="ml-1 mt-2  leading-none">{{ leads.person_name }}</span>
                                                </inertia-link>
                                            </div>
                                        </div>
                                        <p class="mt-3 text-sm font-medium">
                                            <inertia-link :href="route('lead.edit', leads.id)">{{ leads.description
                                                }}</inertia-link>
                                        </p>
                                        <div class="flex items-center w-full text-xs text-gray-400 h-6 mt-2 ">
                                            <div class="flex items-center" v-show="status.id == '1'">
                                                <inertia-link :href="route('lead.edit', leads.id)">
                                                    <svg class="w-4 h-4 text-gray-300 fill-current"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </inertia-link>
                                                <inertia-link :href="route('lead.edit', leads.id)">
                                                    <span class="ml-1 leading-none">{{ leads.created }}</span>
                                                </inertia-link>
                                            </div>
                                            <div class="flex items-center" v-show="status.id > '1'">
                                                <inertia-link :href="route('lead.edit', leads.id)">
                                                    <svg class="w-4 h-4 text-gray-300 fill-current"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </inertia-link>
                                                <inertia-link :href="route('lead.edit', leads.id)">
                                                    <span class="ml-1 leading-none">{{ leads.modified }}</span>
                                                </inertia-link>
                                            </div>
                                            <img class="w-6 h-6 ml-auto rounded-full"
                                                src='https://randomuser.me/api/portraits/women/26.jpg' />
                                            <inertia-link :href="route('lead.edit', leads.id)">
                                                <span class="ml-2">{{ leads.first_name }}</span>
                                            </inertia-link>
                                        </div>
                                        <div
                                            class="flex justify-between items-center w-full text-xs text-gray-400 h-6 mt-4">
                                            <div class="flex">
                                                <div class="relative flex items-center" v-show="status.id == '1'">
                                                    <svg class="relative w-4 h-4 text-gray-300 fill-current"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="ml-1 leading-none">{{ leads.created_by }}</span>
                                                </div>
                                                <div class="relative flex items-center" v-show="status.id > '1'">
                                                    <svg class="relative w-4 h-4 text-gray-300 fill-current"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="ml-1 leading-none">{{ leads.modified_by }}</span>
                                                </div>
                                            </div>
                                            <div class="flex">
                                                <select v-model='userid'
                                                    style="width:100px;height:20px;padding: 0;padding-left: 10px;font-size: 12px;padding-left: 11px;"
                                                    @change="changeboard($event.target.value, leads)"
                                                    class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="null" disabled selected hidden>Choose.</option>
                                                    <option v-for='data in leadPipelineStage' :key='data.id'
                                                        :value='data.id'>{{ data.lead_stage }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- </a>-->
                                </draggable>
                            </transition-group>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col items-center justify-center">
                        <span class="text-gray-600">{{ status.lead_stage }}.</span>
                    </div>
                </div>
            </div>
        </div>
        <Pagination :links="lead.links" />
    </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import AppMenu from '@/Layouts/Appmenu.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import Pagination from '@/Jetstream/Pagination'
import { TrashIcon } from '@heroicons/vue/outline'
import GrayButton from '@/Jetstream/GrayButton.vue'
import { VueDraggableNext } from 'vue-draggable-next'
import JetLabel from '@/Jetstream/Label.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetButton from '@/Jetstream/Button.vue'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import Swal from 'sweetalert2'
export default ({
    components: {
        AppLayout,
        AppMenu,
        Welcome,
        Pagination,
        TrashIcon,
        GrayButton,
        Draggable: VueDraggableNext,
        JetLabel,
        JetInput,
        JetButton,
        Datepicker
    },
    props: [
        "lead",
        "leadPipelineStage", 'user', 'city', 'state'
    ],
    data() {
        return {
            form: this.$inertia.form({
                state_name: null,
                city: null,
                lcn: null,
                ccn: null,
                date: null,
                user: null,
            }),
            enabled: true,
            dragging: true,
            status: [],
            term: null,
            islead: true,
            isass: false,
            isperson: false,
            isFilter: false,
            data: 'lead',
            userid: 'null',
            person: '',
            ass: '',

        }
    },
    computed: {
        taskDragOptions() {
            return {
                animation: 500,
                group: "task-list",
                dragClass: "status-drag"
            };
        }
    },
    methods: {
        openFilter: function () {
            this.isFilter = true;
        },
        kanbanchange(data) {
            // alert(bill);
            if (data == 'lead') {
                this.islead = true;
                this.isass = false;
                this.isperson = false;
            } else if (data == 'ass') {
                this.isass = true;
                this.islead = false;
                this.isperson = false;
            } else {
                this.isperson = true;
                this.islead = false;
                this.isass = false;
            }
        },
        searchlead() {
            this.$inertia.replace(this.route('lead', { term: this.term }))
        },
        searchass() {
            this.$inertia.replace(this.route('lead', { ass: this.ass }))
        },
        searchperson() {
            this.$inertia.replace(this.route('lead', { person: this.person }))
        },
        handleTaskMoved(data) {
            this.status.push(data);
        },
        changeboard(e, id) {
            console.log(e, id);
            this.$inertia.get(this.route('lead.status', e), id, {
                preserveScroll: true,
                onSuccess: () =>
                    // [this.userid=null,
                    alert('Update successfully'),
                // location.reload(),
            })
        },
        drop(event) {
            this.$inertia.get(this.route('lead.status', event.currentTarget.id), this.status[0], {
                preserveScroll: true,
                onSuccess: () => alert('Update successfully'),
                // location.reload(),
            })
        },
        filter() {
            this.form.get(this.route('lead'))
        },
    },
});

</script>

<style scoped>
.status-drag {
    transition: transform 0.5s;
    transition-property: all;
}
</style>
<style scoped>
.moving-card {
    @apply opacity-50 bg-gray-100 border border-blue-500;
}
</style>
