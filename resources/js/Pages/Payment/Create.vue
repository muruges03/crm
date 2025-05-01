<template>
    <app-menu />

    <div class="lg:pl-64 flex flex-col  ">
        <div class="p-5">
            <form class="bg-white-300 shadow-lg" @submit.prevent="store">
                <h2 class="text-lg flex font-semibold pb-4">
                    <inertia-link :href="route('payment.index')" class="flex">
<!--                        <img src="/assets/customer.png" class="h-6 w-6 mr-3 ml-2">-->
                        Create Payment
                    </inertia-link>
                </h2>
                <div class="grid grid-cols-12 gap-2 px-4">
                    <div class="col-span-12 sm:col-span-3">
                        <label for="title" class="mixlabel after:content-['*'] after:ml-0.5 after:text-red-500">Type</label>
                        <div class="relative">
                            <Multiselect   :multiple="false" v-model="form.payment_type" :class="`${form.errors.payment_type ? 'border-red-500 placeholder-text-300 placeholder-red-300' : ''}`"  class="!block" select-label="" deselect-label=""
                                           placeholder="Choose Type" ref="patron_type" :options="options" :searchable="true" :allow-empty="true">
                            </Multiselect>
                            <div v-if="form.errors.payment_type" class="text-red-500 text-xs">{{ form.errors.payment_type }}</div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-3">
                        <label for="payment_date" class="">Payment Date</label>
                        <Datepicker text-input   name="payment_date" v-model="form.payment_date" autoApply :enableTimePicker="false" id="payment_date"/>
                        <!--                            <div v-if="form.errors.payment_date" class="text-red-500 text-xs">{{ form.errors.payment_date }}</div>-->
                    </div>
                    <div class="col-span-12 sm:col-span-3" >
                        <label  class="mixlabel after:content-['*'] after:ml-0.5 after:text-red-500">Patron</label>
                        <Multiselect :value="this.patrons.id"  :multiple="false" v-model="form.vendor_id" select-label="" deselect-label="" track-by="id" label="legal_name" class="!block"
                                     placeholder="Select Customer Name" ref="customer_name" :options="this.patrons" :searchable="true" :allow-empty="true">

                        </Multiselect>
                        <div v-if="form.errors.vendor_id" class="text-red-500 text-xs">Please Select Patron </div>
                    </div>
                    <div class="col-span-12 sm:col-span-3">
                        <label for="title" class="mixlabel after:content-['*'] after:ml-0.5 after:text-red-500">Paid Through</label>
                        <div class="relative">
                            <Multiselect index="0" :vlaue="this.ledger.id" :multiple="false"  :group-select="false" v-model="form.ledger_id" class="!block"
                                          select-label="" deselect-label="" track-by="id" label="l_title"
                                         placeholder="Select Ledger" ref="title"  :options="this.ledger" :searchable="true" :allow-empty="true">
                            </Multiselect>
                            <div v-if="form.errors.ledger_id" class="text-red-500 text-xs">Ledger required.</div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-3" >
                        <label for="total_amount" class="mixlabel after:content-['*'] after:ml-0.5 after:text-red-500">Paid Amount</label>
                        <jet-input type="text" name="total_amount"  v-model="form.paid_amount" id="total_amount"  placeholder="Amount" />
                        <div v-if="form.errors.paid_amount" class="text-red-500 text-xs">Please Enter Amount</div>
                    </div>
                    <div class="col-span-12 sm:col-span-3"  >
                        <label for="description" class="mixlabel">Description</label>
                        <textarea v-model="form.description" rows="2" name="description"  placeholder="Description" class="appearance-none block w-full  border border-gray-300 rounded shadow-sm placeholder-gray-400 focus:outline-none focus:ring-cyan-300 focus:border-cyan-300 sm:text-xs font-normal" />
                    </div>
                </div>

                <div class="p-2">
                    <div class="flex justify-end">
                        <jet-button type="submit" >
                            CREATE
                        </jet-button>
                    </div>
                </div>
            </form>
        </div>
<!--        {{this.ledger}}-->
    </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import AppMenu from '@/Layouts/Appmenu.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import Pagination from '@/Jetstream/Pagination'
// import Multiselect from '@vueform/multiselect'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import Multiselect from '@suadelabs/vue3-multiselect'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { ExclamationCircleIcon } from '@heroicons/vue/solid'
export default {
    components: {
        AppLayout,
        AppMenu,
        Welcome,
        Pagination,
        Multiselect,Datepicker,
        JetButton,JetInput,
        ExclamationCircleIcon
    },
    props:[
      'patrons',
      'ledger',
    ],
    data() {
        return {
            form: this.$inertia.form({
                payment_type        : null,
                vendor_id           : null,
                payment_date        : null,
                ledger_id           : null,
                description         : null,
                total_amount        : null,
                paid_amount         : null,

            }),
            options: ['Payment','Receipt','Advance Payment'],
            addrows:[{
                payment_date      : '',
                ledger_id       : '',
                vendor_id       : '',
            }],
            value:null,
        }
    },
    methods: {
        store() {
            // alert();
            this.form.post(this.route('payment.store'))
        },
    },
}
</script>


