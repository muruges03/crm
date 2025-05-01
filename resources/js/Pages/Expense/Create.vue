<template>
    <app-menu />
    <div class="lg:pl-64">
        <div class=" md:px-4 bg-white md:py-6 sm:p-3">
            <div class="flex px-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                </svg>
                <h2 class="font-bold flex items-center text-lg">
                    <inertia-link :href="route('expense.index')" >CREATE EXPENSE</inertia-link>
                    <span class="text-gray-500 font-medium">
                            <svg class="flex-shrink-0 h-9 w-9 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                </h2>
            </div>

                <div class="shadow overflow-visible sm:rounded">
                    <div class="md:px-4 md:py-3 bg-white sm:p-3">
                    <form @submit.prevent="store" enctype="multipart/form-data" method="post">
                        <div class="overflow-visible sm:rounded-md">
                            <div class="md:px-4 md: py-5 bg-white ">
                                <div class="mt-2">
                                    <div class="  sm:-mx-2 md:mx-0 shadow ring-1 ring-black ring-opacity-5 sm:rounded">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50" style="background:#d1d5db">
                                            <tr>
                                                <th scope="col" class="py-1 pl-2 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 w-36 ">#</th>
                                                <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Ref No</th>
                                                <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 w-36">Expense</th>
                                                <!--                                    <th scope="col" class="px-3 py-1.5 text-left text-sm font-semibold text-gray-900">Stock</th>-->
                                                <th scope="col" class="px-3 py-1.5 text-left text-sm font-semibold text-gray-900 w-16">Amount</th>
                                                <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 w-36">Paid Through</th>
                                                <th scope="col" class="px-3 py-1.5 text-left text-sm font-semibold text-gray-900 w-20">Description</th>
                                                <th scope="col" class="py-1 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 w-36">Vendor </th>
<!--                                                <th scope="col" class="px-3 py-1.5 text-left text-sm font-semibold text-gray-900 w-20">Vehicle</th>-->
                                                <th scope="col" class="px-3 py-1.5 text-left text-sm font-semibold text-gray-900 w-36">Made By</th>
                                                <th scope="col" class="relative py-1 pl-3 pr-2 w-10">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="">
                                            <tr v-for="(add, index) in addrows" :key='add' class="hover:bg-[#0A021E] hover:bg-opacity-10">
                                                <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500" >
                                                    <Datepicker text-input  name="tx_date" v-model="add.date" class=''
                                                                autoApply :enableTimePicker="false" id="date" placeholder="date"/>
                                                    <div v-if="adderrors.date" class="text-red-500 text-xs">Date is Required</div>

                                                </td>
                                                <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 w-28">
                                                    <jet-input type="number" v-model="add.ref_no" name="ref_no" id="ref_no"  @blur="validate_refNo(add)" placeholder=""  />
                                                </td>

                                                <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500">
                                                    <Multiselect index="0" :vlaue="this.expense.id" :multiple="false"  :group-select="false" v-model="add.expense_id" class="!block"
                                                                 :class="`${adderrors.expense_id ? 'border-red-500' : ''}`"  select-label="" deselect-label="" track-by="id" label="l_title"
                                                                 placeholder="Select Ledger" ref="title"  :options="this.expense" :searchable="true" :allow-empty="true">
                                                    </Multiselect>
                                                    <div v-if="adderrors.expense_id" class="text-red-500 text-xs">Expense required.</div>
                                                </td>
                                                <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500">
                                                    <jet-input type="number" v-model="add.amount" name="amount" id="amount"   placeholder="AMount "  />
                                                    <div v-if="adderrors.amount" class="text-red-500 text-xs">The Amount is required.</div>
                                                </td>
                                                <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500">
                                                    <Multiselect index="0" :vlaue="this.asset.id" :multiple="false"  :group-select="false" v-model="add.journal_id" class="!block"
                                                                 select-label="" deselect-label="" track-by="id" label="l_title"
                                                                 placeholder="Select " ref="title"  :options="this.asset" :searchable="true" :allow-empty="true">
                                                    </Multiselect>
                                                    <div v-if="adderrors.journal_id" class="text-red-500 text-xs">The Paid through is required.</div>
                                                </td>
                                                <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500">
                                                            <textarea v-model="add.note"  name="notes" id="notes" rows="1"
                                                                      class="rounded  focus:z-10 appearance-none block xl:w-full border border-gray-300  placeholder-gray-400 focus:outline-none focus:ring-cyan-300 focus:border-cyan-300 sm:text-sm" placeholder="Enter Remarks"  />

                                                </td>
                                                <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500">
                                                    <Multiselect :value="this.patron.id"  :multiple="false" v-model="add.vendor_id"  select-label="" deselect-label="" track-by="id" label="legal_name" class="!block"
                                                                 placeholder="Select Vendor"  :options="this.patron" :searchable="true" :allow-empty="true">
                                                    </Multiselect>
                                                </td>
                                                <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500">
                                                    <Multiselect :value="this.personnel.id"  :multiple="false" v-model="add.made_by"  select-label="" deselect-label="" track-by="id" label="first_name" class="!block"
                                                                 placeholder="Select "  :options="this.personnel" :searchable="true" :allow-empty="true">
                                                    </Multiselect>
                                                    <div v-if="adderrors.made_by" class="text-red-500 text-xs">The made by is required.</div>
                                                </td>

                                                <td class="whitespace-nowrap py-4 px-1 text-sm font-medium text-gray-900 md:w-8">

                                                    <svg xmlns="http://www.w3.org/2000/svg" @click="deleteRow(index, add,addrows)" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                        <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="button"  @click="addRow" class="bg-blue-700 px-3 py-1 my-2 border border-gray-300 rounded shadow-sm text-sm font-medium text-white hover:bg-blue-400 ">
                                    Add Row
                                </button>


                                <div class="px-4 py-3 text-right sm:px-6" >
                                    <jet-button type="submit"  :class="{ 'opacity-25': disabled }" :disabled="disabled">Create</jet-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import AppMenu from '@/Layouts/Appmenu.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import Multiselect from '@suadelabs/vue3-multiselect'
import '@vuepic/vue-datepicker/dist/main.css';
import Swal from 'sweetalert2'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import moment from "moment";
import JetInput from '@/Jetstream/Input.vue'
import JetButton from '@/Jetstream/Button.vue'

export default ({
    components: {
        AppLayout,
        AppMenu,JetInput,
        Welcome,Multiselect,Swal,Datepicker,
        moment,JetButton
    },

    props: {
        asset: Array,
        expense : Array,
        personnel : Array,
        patron : Array,
        vehicles : Array,

    },

    data() {
        return {
            disabled:false,
            addrows:[{
                expense_id       : '',
                date            : '',
                ref_no          : '',
                made_by         : '',
                journal_id      : '',
                note           : '',
                machine_id     : '',
                vendor_id       : '',
                amount          : '0.00',
            }],
            adderrors:{
                expense_id     : false,
                date         : false,
                made_by        : false,
                journal_id   : false,
                amount       : false,

            },

        }
    },
    methods: {
        addRow: function() {
            this.addrows.push({
                expense_id       : '',
                date            : '',
                ref_no          : '',
                made_by         : '',
                machine_id     : '',
                journal_id      : '',
                note           : '',
                vendor_id       : '',
                amount          : '0.00',
            });
        },
        formatNumber(num) {
            // input = num;
            var n1, n2;
            num = num + '' || '';
            // works for integer and floating as well
            n1 = num.split('.');
            n2 = n1[1] || null;
            n1 = n1[0].replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
            num = n2 ? n1 + '.' + n2 : n1;
            // console.log("Input:",num)
            // console.log("Output:", 9 );

            return num;
        },

        deleteRow(index, add,addrows) {
            if(addrows.length > 1){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var idx = this.addrows.indexOf(add);
                        // console.log(idx, index);
                        if (idx > -1) {
                            this.addrows.splice(idx, 1);
                        }
                    }

                })
            }
        },
        store() {
            for (var i = 0; i < this.addrows.length; i++){
                // console.log(this.addrows[i]);
                if(this.addrows[i].date=='' || this.addrows[i].date==null)  return this.adderrors.date=true;
                else this.adderrors.date=false;
                if(this.addrows[i].journal_id=='' || this.addrows[i].journal_id==null)  return this.adderrors.journal_id=true;
                else this.adderrors.journal_id=false;
                if(this.addrows[i].amount=='' || this.addrows[i].amount==null)  return this.adderrors.amount=true;
                else this.adderrors.amount=false;
                if(this.addrows[i].expense_id=='' || this.addrows[i].expense_id==null)  return this.adderrors.expense_id=true;
                else this.adderrors.expense_id=false;
                if(this.addrows[i].made_by=='' || this.addrows[i].made_by==null)  return this.adderrors.made_by=true;
                else this.adderrors.made_by=false;
            }

            this.$inertia.post(this.route('expense.store'),{add:this.addrows});
            this.disabled=true;
        },
        validate_refNo(add)
        {
            // console.log(add);
            // for (var i = 0; i     < this.addrows.length; i++) {
            axios.get(this.route('expense.getrefNo', {id: add}))
                .then(response => {
                    var value1 = response.data;
                    // console.log(value1);
                    // var num=0;
                    // num=parseInt(this.reference_no['ref_no'])+1;
                    // this.reference_no=0;
                    if (value1 == 1) {
                        add.ref_no = '';
                    }
                })
                .catch(error => {
                    console.log(error);
                });

        },



    },
    mounted() {
        // this.addRow();

    }

})
</script>
