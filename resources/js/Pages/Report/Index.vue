<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col bg-white ">
        <div class="px-4 py-4 sm:px-6 lg:px-8">
            <div class="mt-4 sm:mt-0 flex  md:px-3 justify-between">
                <h2 class="text-lg font-semibold flex">
                    Report
                </h2>
            </div>
            <div class="px-4 py-4">
                <form>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 ">
                                Date
                            </label>
                            <Datepicker
                                class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                ref="date" name="date" v-model="form.date" range autoApply :enableTimePicker="false"
                                id="date" placeholder="Start Date" />
                        </div>
                        <div class="col-span-12 sm:col-span-2" v-if="this.form.patron_id == null">
                            <label
                                class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                Ledger
                            </label>
                            <Multiselect :value="this.ledger.id" :multiple="true" v-model="form.ledger_id" class="!block"
                                select-label="" deselect-label="" track-by="id" label="title" placeholder="Select"
                                ref="name" :options="this.ledger" :searchable="true" :allow-empty="true">

                            </Multiselect>
                        </div>
                        <div class="col-span-6 sm:col-span-3" v-if="this.form.ledger_id == null">
                            <jet-label for="title"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500">Patron</jet-label>
                            <Multiselect :value="this.patron.id" :multiple="false" v-model="form.patron_id" class="!block"
                                select-label="" deselect-label="" track-by="id" label="legal_name"
                                placeholder="Select Patron" :options="this.patron" :searchable="true"
                                :allow-empty="true">
                            </Multiselect>
                            <!--                                <div v-if="errors.patron_id" class="text-red-500 text-xs">Select Patron</div>-->
                        </div>

                    </div>
                    <!--                        v-if="$page.props.auth.user.can['create_account']==true"-->
                    <div class="p-2 flex justify-end ">
                        <!--                            <div class="">-->
                        <a v-if="this.form.ledger_id != null"
                            class=" py-1.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d628bbf] hover:bg-[#0d628bbf] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d628bbf]"
                            :href="route('getLedger', this.form)" target="_blank">
                            Generate
                        </a>
                        <a v-if="this.form.patron_id != null"
                            class=" py-1.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d628bbf] hover:bg-[#0d628bbf] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d628bbf]"
                            :href="route('getPatron', this.form)" target="_blank">
                            Generate
                        </a>
                        <!--                            </div>-->
                    </div>
                </form>
                <!--                </div>-->
            </div>

            <div class="px-4 py-4">
                <h2 class="text-lg font-semibold flex"> Payment Report</h2>
                <form>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 ">
                                Date
                            </label>
                            <Datepicker
                                class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                ref="date" name="date" v-model="paymentform.date" range autoApply
                                :enableTimePicker="false" id="date" placeholder="Start Date" />
                        </div>

                        <div class="col-span-6 sm:col-span-3" v-if="this.form.ledger_id == null">
                            <jet-label for="title"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500">Patron</jet-label>
                            <Multiselect :value="this.patron.id" :multiple="false" v-model="paymentform.patron_id" class="!block"
                                select-label="" deselect-label="" track-by="id" label="legal_name"
                                placeholder="Select Patron" :options="this.patron" :searchable="true"
                                :allow-empty="true">
                            </Multiselect>
                            <!--                                <div v-if="errors.patron_id" class="text-red-500 text-xs">Select Patron</div>-->
                        </div>

                    </div>
                    <!--                        v-if="$page.props.auth.user.can['create_account']==true"-->
                    <div class="p-2 flex justify-end ">

                        <a class=" py-1.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d628bbf] hover:bg-[#0d628bbf] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d628bbf]"
                            :href="route('getPaymentReport', this.paymentform)" target="_blank">
                            Generate
                        </a>
                        <!--                            </div>-->
                    </div>
                </form>
                <!--                </div>-->
            </div>
            <CustomerReport :patron="patron"/>
            <TicketReport :patron="patron"/>
            <EmployeeReport :Employee="Employee"/>
        </div>
    </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import AppMenu from '@/Layouts/Appmenu.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import JetButton from '@/Jetstream/Button.vue'
import GrayButton from '@/Jetstream/GrayButton.vue'
import JetInput from '@/Jetstream/Input.vue'
import CustomerReport from './CustomerReport.vue';
import EmployeeReport from './EmployeeReport.vue';
import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';
import { Switch } from '@headlessui/vue'
import Multiselect from '@suadelabs/vue3-multiselect'
import Swal from 'sweetalert2';
import TicketReport from './TicketReport.vue'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
export default ({
    components: {
        AppLayout,
        AppMenu,
        Welcome,
        JetButton,
        GrayButton,
        TicketReport,
        EmployeeReport,
        CustomerReport,
        Table: Tailwind2.Table, JetInput, Switch, Multiselect, Datepicker
    },
    props: {
        ledger: Array,
        patron: Array,
        Employee:Array
    },
    data() {
        return {
            form: this.$inertia.form({
                date: null,
                ledger_id: null,
                patron_id: null,
            }),
            paymentform: this.$inertia.form({
                date: null,
                patron_id: null,
            }),
        }
    },
    methods: {

    }
});
</script>
