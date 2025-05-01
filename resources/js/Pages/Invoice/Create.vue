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
                    <inertia-link :href="route('invoice')" >CREATE NEW INVOICE</inertia-link>
                        <span class="text-gray-500 font-medium">
                            <svg class="flex-shrink-0 h-9 w-9 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    <span class="text-gray-700"> {{ form.invoice_number }}</span>
                </h2>
            </div>

            <form >
            <div class="shadow overflow-visible sm:rounded">
                <div class="md:px-4 md:py-3 bg-white sm:p-3">
                    <div class="grid grid-cols-12 gap-2 md:px-2">

                        <div class="col-span-12 sm:col-span-3">
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500">Customer</label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2 flex">
                                <Multiselect :value="this.patron.id"  :multiple="false" v-model="form.customer_name" select-label="" deselect-label="" track-by="id" label="legal_name" class="!block"
                                        placeholder="Select Customer Name" ref="customer_name" :options="this.patron" :searchable="true" :allow-empty="true">
                                        <template ><strong> {{ this.patron.legal_name }}</strong></template>
                                </Multiselect>
                            </div>
                            <div v-if="errors.customer_name" class="text-xs text-red-500">The customer name field is required.</div>
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label for="username" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500"> Invoice # </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="max-w-lg flex rounded ">
                                    <jet-input  v-model="form.prefix" type="text" style="width:70px;" required name="prefix" id="prefix"  class="inline-flex  rounded-l-md border border-r-0 " />
                                    <jet-input  v-model="form.invoice_number"  ref="invoice_number" type="number"  name="invoice_number" required id="invoice_number"   class="flex-1  rounded-none rounded-r-md" />

                                </div>
                                <div v-if="errors.invoice_number" class="text-xs text-red-500">The invoice number Already Taken.</div>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label for="order_number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Order Number</label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <jet-input  v-model="form.order_number" ref="order_number" type="number" name="order_number" id="order_number" autocomplete="order_number" class="" />
                            </div>
                             <div v-if="errors.order_number" class="text-xs text-red-500">The order number field is required.</div>
                        </div>

                        <div class="col-span-12 sm:col-span-3">
                            <label for="invoiced_at" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500">Invoice Date</label>
                            <div class="sm:col-span-2">
                                <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="invoiced_at" name="invoiced_at" v-model="form.invoiced_at" autoApply :enableTimePicker="false"
                                    id="invoiced_at"  autocomplete="invoiced_at" placeholder="Invoice Date" />
                            </div>
                            <div v-if="errors.invoiced_at" class="text-xs text-red-500">The order invoiced At is required.</div>
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                             <label for="due_at" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 pt-5 ">Due Date</label>
                            <div class="sm:col-span-2">
                                <Datepicker  class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md" ref="due_at" name="due_at" v-model="form.due_at" autoApply :enableTimePicker="false"
                                    id="due_at"  autocomplete="due_at" placeholder="Due Date" />
                            </div>
                            <div v-if="errors.due_at" class="text-xs text-red-500">The order invoiced At is required.</div>
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label for="title" class="mixlabel after:content-['*'] sm:pt-2  after:ml-0.5 after:text-red-500">Journal</label>
                            <div class="relative">
                                <Multiselect index="0" :vlaue="this.ledger.id" :multiple="false"  :group-select="false" v-model="form.ledger_id" class="!block"
                                             select-label="" deselect-label="" track-by="id" label="l_title"
                                             placeholder="Select Ledger" ref="title"  :options="this.ledger" :searchable="true" :allow-empty="true">
                                </Multiselect>
                                <div v-if="errors.ledger_id" class="text-red-500 text-xs">Ledger required.</div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <label for="type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500"> Type </label>
                            <div class="sm:col-span-2 ">
                                <select  v-model="form.type" ref="type"  @change='invoiceType($event)' id="type" required name="type" autocomplete="type"  class="sm:col-span-1 w-full block focus:ring-indigo-500 focus:border-indigo-500  sm:text-sm border-gray-300 rounded">
                                    <option value="Monthly">Monthly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>
                            <div v-if="errors.type" class="text-xs text-red-500">The type is required.</div>
                        </div>

                        <div v-if="yearly" class="col-span-12 sm:col-span-3">
                            <label for="start_date"  class="block text-sm font-medium text-gray-700 sm:pt-2"> Start month </label>
                            <div class="">
                                 <Datepicker  format="MM/yyyy"  class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                     ref="start_date" name="start_date" v-model="form.start_date" autoApply :enableTimePicker="false"
                                    id="start_date"  autocomplete="start_date" placeholder="Start Date" />
                            </div>
                            <div v-if="errors.start_date" class="text-xs text-red-500">The Start Date is required.</div>

                        </div>
                        <div v-if="yearly" class="col-span-12 sm:col-span-3">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 sm:pt-2"> End Month </label>
                            <div class="">
                               <Datepicker  format="MM/yyyy"  class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                     ref="end_date" name="end_date" v-model="form.end_date" autoApply :enableTimePicker="false"
                                    id="end_date"  autocomplete="end_date" placeholder="End Date" />
                            </div>
                            <div v-if="errors.end_date" class="text-xs text-red-500">The end Date is required.</div>
                        </div>

                        <div v-if="monthly" class="col-span-12 sm:col-span-3">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 pt-5"> Month </label>
                            <div class="sm:col-span-2 ">
                                 <Datepicker  format="MM/yyyy"   class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                     ref="start_date" name="start_date" v-model="form.start_date" autoApply :enableTimePicker="false"
                                    id="start_date"  autocomplete="start_date" placeholder="Start Date" />
                            </div>
                            <div v-if="errors.start_date" class="text-xs text-red-500">The Start Date is required.</div>
                        </div>
                    </div>
                </div>
                <div class="px-6 ">
                    <div class=" overflow-visible ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded">
                        <table class="min-w-full ">

                            <tbody class="">
                                <tr v-for="(add, index) in addrows" :key='add'>
                                    <div class="bg-[#4989a8] border text-white flex justify-between px-2 py-2 rounded text-base"><span>Row : {{index+1}} </span>
                                         <svg xmlns="http://www.w3.org/2000/svg" @click="deleteRow(index, add, addrows)" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </div>
                                    <div class="grid grid-cols-12  gap-2  py-1">
                                        <div class="col-span-12 sm:col-span-3">
                                            <Multiselect :value="this.product.id" required ref="product_id" :multiple="false" v-model="add.product_id" select-label="" deselect-label="" track-by="id" label="name"
                                                class=" block focus:ring-indigo-500 focus:border-indigo-500    sm:text-sm border-gray-300"
                                                placeholder="Select Item" :options="this.product" :searchable="true" :allow-empty="true"
                                                @select='productChange($event,add)' @remove="productChangeempty(add)">
                                            </Multiselect>
                                            <div v-if="adderrors.product_id" class="text-xs text-red-500">The Product is required.</div>
                                        </div>

                                        <div class="col-span-12 sm:col-span-3">
                                          <Multiselect :value="this.tax.id" :multiple="false" ref="tax_id" v-model="add.tax_id" select-label=" " deselect-label=" " track-by="id" label="tax_amount"
                                                class=" block focus:ring-indigo-500 focus:border-indigo-500  w-full sm:text-sm border-gray-300 rounded"
                                                placeholder="Select Tax" :options="this.tax" :searchable="true" :allow-empty="true"  :custom-label="nameWithLang"
                                                    @select="taxchange($event,add)"  @remove="taxremove(add)">
                                            </Multiselect>
                                            <div v-if="adderrors.tax_id" class="text-xs text-red-500">The tax is required.</div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-2">
                                                <!-- <infra-label for="title" class="mixlabel">Discount Type</infra-label> -->
                                            <jet-input type="number" v-model="add.quantity" ref="quantity" name="Quantity" placeholder="Quantity" id="quantity"  @change="calculateLineTotal(add)" autocomplete="quantity" class="" />
                                            <div v-if="adderrors.quantity" class="text-xs text-red-500">The quantity is required.</div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-2">
                                            <!-- <infra-label for="title" class="mixlabel ">Price / Unit</infra-label> -->
                                            <div class="relative rounded shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm"> ₹ </span>
                                                </div>
                                                <jet-input type="number" v-model="add.price" ref="price" @change="calculateLineTotal(add)" name="price" style="padding-left:17px !important" placeholder="Price (0.00)" id="price" autocomplete="price" class="" />
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm" id="price-currency"> INR </span>
                                                </div>
                                            </div>
                                            <div v-if="adderrors.price" class="text-xs text-red-500">The price is required.</div>
                                        </div>

                                        <div class="col-span-12 sm:col-span-2">
                                            <!-- <infra-label for="title" class="mixlabel ">Total</infra-label> -->
                                            <div class="relative rounded shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm"> ₹ </span>
                                                </div>
                                                <jet-input type="number" v-model="add.total_amount" ref="total_amount" name="total_amount" id="total_amount" style="padding-left:17px !important" placeholder="Total Amount " autocomplete="total_amount" class="" />
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm" id="price-currency"> INR </span>
                                                </div>
                                            </div>
                                            <div v-if="adderrors.total_amount" class="text-xs text-red-500">The total amount is required.</div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6">
                                            <textarea  v-model="add.description" rows="4" name="description" ref="description" id="description" placeholder="Description"  class="w-full block focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" />
                                            <div v-if="adderrors.description" class="text-xs text-red-500">The description is required.</div>
                                        </div>
                                    </div>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="md:grid md:grid-cols-3 md:gap-2 md:px-4">
                    <div class="md:col-span-1 ml-2">
                         <button type="button"  @click="addRow" class="bg-[#4989a8] py-1 px-3 border border-gray-300 rounded shadow-sm text-sm font-medium text-white hover:bg-[#4989a8] ">
                            <i class="fa fa-plus  text-white"></i>Add Row
                        </button>

                    </div>
                    <div class="mt-1 md:mt-0 md:col-span-2">
                         <div class="px-4  bg-white sm:pr-2">
                             <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-1 flex justify-between py-1">
                                <label for="amount_untaxed" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Sub Total </label>
                                <label for="amount_untaxed"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 sm:col-span-2" style="text-align-last: end;"> {{formatNumber(form.untaxed_amount)}}</label>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-1 flex justify-between py-1">
                                <label for="discount_amount" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 sm:col-span-2"> Discount (₹) </label>
                                 <label for="discount_amount"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2" style="text-align-last: end;"> {{formatNumber(form.discount_amount)}}</label>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-1 flex justify-between py-1">
                                <label for="amount_tax" class="sm:col-span-2 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Tax </label>
                                <label for="amount_tax" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 items-end" style="text-align-last: end;"> {{formatNumber(form.tax_amount)}} </label>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-1 flex justify-between py-1">
                                <label for="amount_total" class="block text-sm font-bold text-gray-700 sm:mt-px sm:pt-2 sm:col-span-2"> Total (&#x20b9;) </label>
                                <div class="relative rounded shadow-sm flex justify-end">
                                    <span class="text-gray-500 sm:text-sm pr-2"> ₹ </span>
                                    <label  class="block text-sm font-medium text-gray-700 sm:mt-px items-end" style="text-align-last: end;">{{formatNumber(form.total_amount)}}</label>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="md:grid md:grid-cols-6 md:gap-2 md:px-6 md:mt-2">

                    <div class="md:col-span-2">
                         <label for="notes" class="block text-sm font-medium text-gray-700">Customer Notes</label>
                        <textarea  v-model="form.notes" rows="4" name="notes" id="notes" ref="notes" placeholder="Thanks for your business." vlaue="Thanks for your business." class="shadow-sm focus:ring-indigo-300 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded" />
                    </div>

                    <div class="md:col-span-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700 ">Terms & Conditons</label>
                        <div class="mt-1">
                            <textarea readonly  v-model="this.email[0]['team_condition']" rows="2" placeholder="Enter the terms and conditions of your business to be displayed in your transaction" class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded" />
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                     <div class="flex justify-end">
                        <button type="button" :disabled="isDisabled" @click='save(form,addrows)' class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent  text-sm font-semibold rounded text-white bg-[#4989a8] hover:bg-[#4989a8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" >Create</button>
                    </div>
                </div>
            </div>
        </form>
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

    export default ({
        components: {
        AppLayout,
        AppMenu,JetInput,
        Welcome,Multiselect,Swal,Datepicker,
        moment
        },
        props:['tax','product','patron','invoiceid','email','ledger'],
        // ,'ledger'
        setup(){
            function handleChangedMonth(payload) {
                // console.log( payload )
            }
            return {handleChangedMonth}
        },
    data() {
        return {
            form:{
                customer_name   : null,
                prefix          : 'INV',
                invoice_number  : this.invoiceid,
                order_number    : null,
                status          : '1',
                start_date      : null,
                end_date        : null,
                invoiced_at     : null,
                due_at          : null,
                ledger_id       : null,
                untaxed_amount  : '0.00',
                tax_amount      : '0.00',
                total_amount    : '0.00',
                discount_amount : '0.00',
                notes           : 'Thanks for Your Business',
                type            : 'Monthly',
            },
            addrows:[{
                product_id:'',
                total_amount:'',
                description:'',
                quantity:'',
                price:'',
                discount_type:'%',
                discount_amount:'0',
                total_discount  : '0',
                tax_id:'',
                isActive: true,
            }],
            yearly: false,
            monthly: true,
            isDisabled:false,
            errors:{
                customer_name:false,
                prefix:false,
                invoice_number:false,
                order_number:false,
                start_date:false,
                end_date:false,
                due_at:false,
                notes:false,
            },
            adderrors:{
                product_id:false,
                description:false,
                quantity:false,
                price:false,
            },
        }
    },
    created: function () {
        this.moment = moment;
    },
    methods: {
        formatNumber(num) {
            // input = num;
            var n1, n2;
            num = num + '' || '';
            // works for integer and floating as well
            n1 = num.split('.');
            n2 = n1[1] || null;
            n1 = n1[0].replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
            num = n2 ? n1 + '.' + n2 : n1;
            // console.log("Input:",input)
            // console.log("Output:", 9 );

            return num;
        },
        addRow: function() {
            this.addrows.push({
                product_id:'',
                total_amount:'',
                tax_amount:'',
                description:'',
                quantity:'',
                price:'',
                discount_type:'%',
                discount_amount:'0',
                total_discount  : '0',
                tax_id:'',
            });
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
                        this.calculateTotal();
                    }
                }
                })
            }
        },
        calculateTotal() {
            var total,subtotal=0,totalamount=0,totaltaxamount=0,totaldiscount=0,discountamount=0,
            total = this.addrows.reduce(function (sum, product) {
                var lineTotal = parseFloat(product.total_amount);
                var lineTax  = parseFloat(product.tax_id['tax_amount']);
                if (!isNaN(lineTax)) lineTax = lineTax;
                        else  lineTax = '0.00';
                // console.log('lineTax',lineTax);
                var lineDiscount  = parseFloat(product.total_discount);
                if (!isNaN(lineTotal)) {
                    var taxsum =(lineTotal * (lineTax/100)+lineTotal);
                    subtotal +=lineTotal;
                    totalamount +=  taxsum;
                    totaltaxamount += lineTotal * (lineTax/100);
                    totaldiscount += lineDiscount;
                    return subtotal,totalamount,totaltaxamount,totaldiscount,total;
                }
            }, 0);
            // console.log( subtotal,totalamount,totalta xamount,totaldiscount);
            if (!isNaN(subtotal)) this.form.untaxed_amount = subtotal.toFixed(2);
                        else  this.form.untaxed_amount = '0.00';
            if (!isNaN(totalamount)){
                if(!isNaN(totaldiscount)){ discountamount = totaldiscount; }else{discountamount='0';}
                var totalamt= totalamount-discountamount;
                this.form.total_amount = totalamt.toFixed(2);
            }else{  this.form.total_amount = '0.00';}
            if (!isNaN(totaltaxamount)) this.form.tax_amount = totaltaxamount.toFixed(2);
                        else  this.form.tax_amount = '0.00';
            if (!isNaN(totaldiscount)) this.form.discount_amount = totaldiscount.toFixed(2);
                        else  this.form.discount_amount = '0.00';
            // console.log(subtotal,total);
        },
        calculateLineTotal(add) {
            var total = parseFloat(add.price) * parseFloat(add.quantity);
            var taxtotal= (total * (add['tax_id']['tax_amount']/100));
            // console.log('asdd = ',add,taxtotal);
            if (!isNaN(total))  add.total_amount = total.toFixed(2);
                else add.total_amount = '0';
                if (!isNaN(taxtotal))  add.tax_amount = taxtotal.toFixed(2);
                else  add.tax_amount = '0';
            if(add.discount_type=="%") add.total_discount  = (total * (add.discount_amount/100))
                else add.total_discount  = add.discount_amount;
                    console.log('asdd = ',add.total_discount);
            this.calculateTotal();
        },
        invoiceType(event){
            if('Monthly'==event.target.value){
                this.monthly = true;
                this.yearly  = false;
                //this.form.end_date    = '';
            }else{
                //this.form.end_date    = new Date();
                //this.form.end_date.setDate(this.form.end_date.getDate() + 365);
                this.yearly  = true;
                this.monthly = false;
            }
        },
        productChange(option,add){
            // console.log(option);
            add.price=option['sale_price'];
            add.quantity='1';
            add.description=option['description'];
            var taxvalue =this.tax,
            result = taxvalue.reduce(function (r, a) {
                if(a['id']==option['tax_id']){
                    add.tax_id=a;
                    // console.log(a['id']==option['tax_id']);
                }
                return r;
            }, Object.create(null));
            this.calculateLineTotal(add);
        },
        nameWithLang ({ tax_name, tax_amount }) {
            // console.log(tax_name, tax_amount);
            return `${tax_name} - ${tax_amount} %`
        },
        productChangeempty(add){
            add.price='';
            add.quantity='';
            add.tax_id='';
            add.total_amount='';
            add.description='';
            this.calculateLineTotal(add);
        },
        taxchange(option,add){
            // console.log('add tax',option,add);
            add.tax_id=option;
            this.calculateLineTotal(add);
        },
        taxremove(add){
            // console.log('taxremove',add);
            add.tax_id={id: '', tax_name: '', tax_type: '', tax_amount: '',};
            this.calculateTotal();
        },
        save(form,addrows){
            // console.log(addrows);
            if(form.customer_name==null)  return [this.errors.customer_name=true];
                else this.errors.customer_name=false;
            if(form.invoiced_at==null)  return [this.errors.invoiced_at=true];
                else this.errors.invoiced_at=false;
            if(form.due_at==null)  return [this.errors.due_at=true];
                else this.errors.due_at=false;
            if(form.type=='Monthly'){
                 if(form.start_date==null)  return [this.errors.start_date=true,this.$refs.start_date.focus()];
                    else this.errors.start_date=false;
            }else{
                if(form.start_date==null)  return [this.errors.start_date=true,this.$refs.start_date.focus()];
                    else this.errors.start_date=false;
                if(form.end_date==null)  return [this.errors.end_date=true,this.$refs.end_date.focus()];
                    else this.errors.end_date=false;
            }
            for (var i = 0; i < addrows.length; i++){
                // console.log(addrows[i].product_id);
                if(addrows[i].product_id=='' || addrows[i].product_id==null)  return this.adderrors.product_id=true;
                    else this.adderrors.product_id=false;
                if(addrows[i].description=='' || addrows[i].description==null)  return this.adderrors.description=true;
                    else this.adderrors.description=false;
                if(addrows[i].quantity=='' || addrows[i].quantity==null)  return this.adderrors.quantity=true;
                    else this.adderrors.quantity=false;
                    // console.log('ddrows[i].price',addrows[i].price);
                if( addrows[i].price==null )  return this.adderrors.price=true;
                    else this.adderrors.price=false;
            }
            // this.isDisabled=true;
            // return;
            this.$inertia.post(this.route('invoice.store'),{form: form,add:addrows});
        },
        onloadfunction(){
            this.form.invoiced_at = new Date();
            this.form.due_at      = new Date();
            this.form.due_at.setDate(this.form.due_at.getDate() + 5);
            //this.form.start_date  = new Date();
            //console.log(this.form.due_at);
        },
    },
    mounted(){
        this.onloadfunction();
    }
});
</script>

<style>
/*
.multiselect--active {
    border-radius: 4px !important;
    outline: none !important;
    outline-offset: 4px !important;
    --tw-ring-inset: var(--tw-empty,

        );
    --tw-ring-offset-width: 1px;
    --tw-ring-offset-color: #a3b5dc !important;
    --tw-ring-color: #a3b5dc !important;
    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow);
    border-color: #a3b5dc !important;

}
.multiselect__single{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
} */

/* .multiselect__tags {
    min-height: 40px;
    display: block;
    padding: 8px 40px 0 8px !important;
    border-radius: 5px;
    border: 1px solid #e8e8e8;
    background: #fff;
    font-size: 14px;
} */
</style>
