<template>
 <app-menu />
    <div class="lg:pl-64 flex flex-col bg-white divide-x divide-gray-100 border-1 ">
        <form class="space-y-8  m-5">
            <div class="space-y-8  sm:space-y-5">
                <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
                    <div class="flex">
                        <img src="/assets/invoice.png" class="w-8 text-[#476b9c]"/>
                        <h2 class="text-2xl leading-6 font-bold ">New Invoice</h2>
                    </div>
                    <div class="space-y-6 sm:space-y-5">
                        <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start">
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500">Customer</label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2 flex">
                                <Multiselect :value="this.patron.id"  :multiple="false" v-model="form.customer_name" select-label="" deselect-label="" track-by="id" label="legal_name" class="!block"
                                        placeholder="Select" ref="customer_name" :options="this.patron" :searchable="true" :allow-empty="true">
                                        <template ><strong> {{ this.patron.legal_name }}</strong></template>
                                </Multiselect>
                                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg> -->
                                <div v-if="errors.customer_name" class="text-xs text-red-500">The customer name field is required.</div>
                            </div>
                        </div>
                        <div class="mt-6  ">
                            <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start">
                                <label for="username" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500"> Invoice # </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="max-w-lg flex rounded ">
                                        <input  v-model="form.prefix" type="text" style="width:70px;" required name="prefix" id="prefix"  class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                        <input  v-model="form.invoice_number"  ref="invoice_number" type="number"  name="invoice_number" required id="invoice_number"   class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" >
                                        <div v-if="errors.invoice_number" class="text-xs text-red-500">The invoice number Already Taken.</div>
                                    </div>
                                </div>

                             <label for="order_number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Order Number</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input  v-model="form.order_number" ref="order_number" type="number" name="order_number" id="order_number" autocomplete="order_number" class="max-w-lg block w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded">
                                    <div v-if="errors.order_number" class="text-xs text-red-500">The order number field is required.</div>
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start">
                            <label for="invoiced_at" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2  after:content-['*'] after:ml-0.5 after:text-red-500">Invoice Date</label>
                            <div class="sm:col-span-2">
                                <input v-model="form.invoiced_at" type="date" ref="invoiced_at" name="invoiced_at" id="invoiced_at" required autocomplete="invoiced_at" class="block max-w-lg w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded">
                                 <div v-if="errors.invoiced_at" class="text-xs text-red-500">The order invoiced At is required.</div>
                            </div>
                             <label for="due_at" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 pt-5 ">Due Date</label>
                            <div class="sm:col-span-2">
                                <input v-model="form.due_at" type="date" ref="due_at" name="due_at" id="due_at" autocomplete="due_at" class="block max-w-lg w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded">
                                <div v-if="errors.due_at" class="text-xs text-red-500">The order invoiced At is required.</div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-6 sm:gap-4 sm:items-start">
                            <label for="type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 after:content-['*'] after:ml-0.5 after:text-red-500"> Type </label>
                            <div class="sm:col-span-2 ">
                                <select  v-model="form.type" ref="type"  @change='invoiceType($event)' id="type" required name="type" autocomplete="type"  class="sm:col-span-1 w-full block focus:ring-indigo-500 focus:border-indigo-500  sm:text-sm border-gray-300 rounded">
                                    <option vlaue="Monthly">Monthly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                                 <div v-if="errors.type" class="text-xs text-red-500">The type is required.</div>
                            </div>
                            <div v-if="yearly" class="md:flex sm:col-span-4 md:col-span-6 lg:col-span-4">
                                <label for="start_date"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Start month </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-1 md:col-span-2 lg:col-span-1 md:pl-10">
                                    <input type="month" v-model="form.start_date" name="start_date" ref="start_date" id="start_date"  autocomplete="start_date" class="block max-w-lg w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded">
                                    <div v-if="errors.start_date" class="text-xs text-red-500">The Start Date is required.</div>
                                </div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 md:pl-5"> End Month </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-1 md:col-span-2 lg:col-span-1 md:pl-10">
                                    <input type="month" v-model="form.end_date" name="end_date" ref="end_date" id="end_date" autocomplete="end_date" class="block max-w-lg w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded">
                                    <div v-if="errors.end_date" class="text-xs text-red-500">The end Date is required.</div>
                                </div>
                            </div>
                            <div v-if="monthly"  class="sm:col-span-3 flex pt-2 justify-between ">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 pt-5"> Duration </label>
                                <div class="sm:col-span-2 ">
                                    <input type="month" v-model="form.start_date" required ref="start_date" id="start_date" autocomplete="start_date" class="block max-w-lg w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded">
                                    <div v-if="errors.start_date" class="text-xs text-red-500">The Start Date is required.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 sm:px-6 ">
                    <div class="mt-4 flex flex-col">
                        <div class="-my-2 -mx-4  sm:-mx-6 lg:-mx-8 lg:px-4">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <div class=" shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300" style=" border-collapse: collapse;">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-2 py-2 text-left text-sm font-semibold text-gray-900 " >#</th>
                                                <th class="px-2 description py-2 text-left text-sm font-semibold text-gray-900 sm:pl-6" >Description</th>
                                                <!-- <th class="hidden px-1 py-2 text-center text-sm font-semibold text-gray-900 md:table-cell">Discount</th> -->
                                                <th class="hidden px-1 py-2 text-center text-sm font-semibold text-gray-900 md:table-cell">Tax</th>
                                                <th class="hidden px-3 py-2 text-center text-sm font-semibold text-gray-900 md:table-cell">Price</th>
                                                <th class="hidden px-0 py-2 text-left text-sm font-semibold text-gray-900 md:table-cell">Quantity</th>
                                                <th  class="hidden px-2 py-2 text-left text-sm font-semibold text-gray-900 md:table-cell">Amount</th>
                                                <th  class=" hidden relative py-3.5 pl-3 pr-4 sm:pr-6 md:table-cell">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="(add, index) in addrows" :key='add'>
                                                <td class="px-1 py-1 text-sm text-gray-500">{{++index}}</td>
                                                <td class="px-1 py-1 text-sm text-gray-500">
                                                    <span class="md:hidden">Item Details</span>
                                                    <div class="px-1 w-full">
                                                        <Multiselect :value="this.product.id" required ref="product_id" :multiple="false" v-model="add.product_id" select-label="" deselect-label="" track-by="id" label="name"
                                                               class=" !block focus:ring-indigo-500 focus:border-indigo-500    sm:text-sm border-gray-300"
                                                            placeholder="Select Item" :options="this.product" :searchable="true" :allow-empty="true"
                                                           @select='productChange($event,add)' @remove="productChangeempty(add)">
                                                            <template ><strong> {{ this.product.name }}</strong></template>
                                                        </Multiselect>
                                                         <div v-if="adderrors.product_id" class="text-xs text-red-500">The Product is required.</div>
                                                    </div>
                                                    <div class="px-1 ">
                                                        <textarea  v-model="add.description" rows="4" name="description" ref="description" id="description" placeholder="Description"  class="w-full block focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" />
                                                        <div v-if="adderrors.description" class="text-xs text-red-500">The description is required.</div>
                                                    </div>
                                                    <dl class="font-normal md:hidden mt-10">
                                                        <!-- <dt class="md:hidden">Discount</dt>
                                                        <dd class="mt-1 truncate text-gray-500 sm:hidden">
                                                            <div class="flex">
                                                                <select id="discount_type" name="discount_type" ref="discount_type" v-model="add.discount_type" autocomplete="discount_type" @change="calculateLineTotal(add)" class="max-w-lg block   sm:max-w-xs sm:text-sm border-gray-300 rounded">
                                                                      <option vlaue="₹">₹</option>
                                                                      <option value="%" selected>%</option>
                                                                </select>
                                                                <input type="number" v-model="add.discount_amount" ref="discount_amount" id="discount_amount" autocomplete="discount_amount" @change="calculateLineTotal(add)" class=" block w-full   sm:text-sm  border-gray-300 outline-none focus:outline-none rounded">
                                                                 <div v-if="adderrors.discount_amount" class="text-xs text-red-500">The discount amount is required.</div>
                                                            </div>
                                                        </dd> -->
                                                        <dt class="md:hidden">Tax %</dt>
                                                        <dd class="truncate text-gray-500 sm:hidden">
                                                            <Multiselect :value="this.tax.id" :multiple="false" ref="tax_id" v-model="add.tax_id" select-label=" " deselect-label=" " track-by="id" label="tax_amount"
                                                                class=" !block focus:ring-indigo-500 focus:border-indigo-500  w-full sm:text-sm border-gray-300 rounded"
                                                                placeholder="Select Tax" :options="this.tax" :searchable="true" :allow-empty="true"
                                                                 @select="taxchange($event,add)"  @remove="taxremove(add)">
                                                                <template ><strong> {{ this.tax.tax_amount }}</strong></template>
                                                            </Multiselect>
                                                            <div v-if="adderrors.tax_id" class="text-xs text-red-500">The tax is required.</div>
                                                        </dd>
                                                        <dt class="md:hidden">Price</dt>
                                                        <dd class="mt-1 truncate text-gray-500 sm:hidden">
                                                            <input type="number" v-model="add.price" ref="price" @change="calculateLineTotal(add)" name="price" id="price" autocomplete="price" class="max-w-lg block w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded">
                                                            <div v-if="adderrors.price" class="text-xs text-red-500">The price is required.</div>
                                                        </dd>
                                                        <dt class="md:hidden">Quantity</dt>
                                                        <dd class="mt-1 truncate text-gray-500 sm:hidden">
                                                            <input type="number" v-model="add.quantity" ref="quantity" name="quantity" id="quantity"  @change="calculateLineTotal(add)" autocomplete="quantity" class="max-w-lg block w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded">
                                                            <div v-if="adderrors.quantity" class="text-xs text-red-500">The quantity is required.</div>
                                                        </dd>
                                                        <dt class="md:hidden">Amount</dt>
                                                        <dd class="mt-1 truncate text-gray-500 sm:hidden">
                                                            <input type="number" v-model="add.total_amount" ref="total_amount" name="total_amount" id="total_amount" autocomplete="total_amount" class="max-w-lg block w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded">
                                                            <div v-if="adderrors.total_amount" class="text-xs text-red-500">The total amount is required.</div>
                                                        </dd>
                                                    </dl>
                                                </td>
                                                <!-- <td  class="hidden px-1 py-1 text-sm text-gray-500 md:table-cell">
                                                    <div class="flex">
                                                        <select id="discount_type" name="discount_type" ref="discount_type" @change="calculateLineTotal(add)" v-model="add.discount_type" autocomplete="discount_type"  class="max-w-lg block   sm:max-w-xs sm:text-sm border-gray-300 rounded">
                                                            <option vlaue="₹">₹</option>
                                                            <option value="%" selected>%</option>
                                                        </select>
                                                        <input type="number" v-model="add.discount_amount" @change="calculateLineTotal(add)" id="discount_amount" autocomplete="discount_amount" class="max-w-lg block w-full  sm:text-sm  border-gray-300 outline-none focus:outline-none rounded">
                                                        <div v-if="adderrors.discount_amount" class="text-xs text-red-500">The discount amount is required.</div>
                                                    </div>
                                                </td> -->
                                                <td  class="hidden px-1 py-1 text-sm text-gray-500 md:table-cell">
                                                   <Multiselect :value="this.tax.id" :multiple="false" ref="tax_id" v-model="add.tax_id" select-label="" deselect-label="" track-by="id" label="tax_amount"
                                                                class="max-w-lg !block   sm:max-w-xs sm:text-sm border-gray-300 rounded"
                                                            placeholder="Select" :options="this.tax" :searchable="true" :allow-empty="true"
                                                             @select="taxchange($event,add)"  @remove="taxremove(add)">
                                                            <template ><strong> {{ this.tax.tax_amount }}</strong></template>
                                                    </Multiselect>
                                                    <div v-if="adderrors.tax_id" class="text-xs text-red-500">The tax is required.</div>
                                                 </td>
                                                <td  class="hidden px-1 py-1 text-sm text-gray-500 md:table-cell">
                                                    <input type="number" v-model="add.price" name="price" id="price" ref="price" placeholder="Enter Price" @change="calculateLineTotal(add)" autocomplete="price" class="max-w-lg block w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded">
                                                    <div v-if="adderrors.price" class="text-xs text-red-500">The price is required.</div>
                                                 </td>
                                                 <td  class="hidden px-1 py-1 text-sm text-gray-500 md:table-cell">
                                                    <input type="number" v-model="add.quantity" name="quantity" id="quantity" ref="quantity" placeholder="Enter Quantity" @change="calculateLineTotal(add)" autocomplete="quantity" class="max-w-lg block w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded">
                                                    <div v-if="adderrors.quantity" class="text-xs text-red-500">The quantity is required.</div>
                                                </td>
                                                <td class="hidden px-1 py-1 text-sm text-gray-500 md:table-cell">
                                                    <input type="number" disabled v-model="add.total_amount" ref="total_amount" name="total_amount" placeholder="Total Amount" id="total_amount" autocomplete="total_amount" class="max-w-lg block w-full  focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded">
                                                    <div v-if="adderrors.total_amount" class="text-xs text-red-500">The total amount is required.</div>
                                                </td>
                                                <td colspan="1" class=" relative whitespace-nowrap py-4 md:pl-3 md:pr-4 text-right text-sm font-medium">
                                                    <svg xmlns="http://www.w3.org/2000/svg" @click="deleteRow(index, add,addrows)" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                        <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <button type="button" class="bg-blue-500 py-1 px-2 m-2 border border-gray-300 rounded  text-sm font-medium text-white hover:bg-blue-600 opacity-50 hover:opacity-100">
                            <i class="fa fa-plus  text-white" @click="addRow">Add row</i>
                        </button>
                        <label for="notes" class="block text-sm font-medium text-gray-700 md:pt-16">Customer Notes</label>
                        <div class="mt-1">
                            <textarea  v-model="form.notes" rows="2" name="notes" id="notes" ref="notes" placeholder="Thanks for your business." vlaue="Thanks for your business." class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded" />
                            <div v-if="errors.notes" class="text-xs text-red-500">The notes is required.</div>
                        </div>
                    </div>
                    <div class="mt-1 md:mt-0 md:col-span-2">
                         <div class="px-4 py-2 bg-white sm:p-2">
                             <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-1 flex justify-between py-2">
                                <label for="untaxed_amount" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Sub Total </label>
                                <label for="untaxed_amount"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 sm:col-span-2" style="text-align-last: end;"> {{form.untaxed_amount}}</label>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5 flex justify-between py-2">
                                <label for="discount_amount" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 sm:col-span-2"> Discount </label>
                                 <label for="discount_amount"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2" style="text-align-last: end;"> {{form.discount_amount}}</label>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5 flex justify-between py-2">
                                <label for="" class="sm:col-span-2 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Tax </label>
                                <label for="tax_amount" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 items-end" style="text-align-last: end;"> {{form.tax_amount}} </label>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5 flex justify-between py-2">
                                <label for="total_amount" class="block text-sm font-bold text-gray-700 sm:mt-px sm:pt-2 sm:col-span-2"> Total (&#x20b9;) </label>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 items-end" style="text-align-last: end;"> {{form.total_amount}} </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1 mt-1">
                        <label for="comment" class="block text-sm font-medium text-gray-700 ">Authorized Sign</label>
                    </div>
                    <div class="md:col-span-2 mt-1">
                        <label for="comment" class="block text-sm font-medium text-gray-700 ">Terms & Conditons</label>
                        <div class="mt-1">
                            <textarea readonly  v-model="this.email[0]['team_condition']" rows="2" placeholder="Enter the terms and conditions of your business to be displayed in your transaction" class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="button" :disabled="isDisabled" @click='save(form,addrows)' class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent  text-sm font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" >Save</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Multiselect from '@suadelabs/vue3-multiselect'
    import Swal from 'sweetalert2'
    export default ({
        components: {
        AppLayout,
        AppMenu,
        Welcome,Multiselect,Swal
        },
        props:['tax','product','patron', 'invoice','invoiceid','email'],
        data() {
            return {
                form:{
                    customer_name:null,
                    prefix:'INV',
                    invoice_number:this.invoiceid,
                    order_number:null,
                    status:'1',
                    start_date:null,
                    end_date:null,
                    invoiced_at:null,
                    due_at:null,
                    untaxed_amount:'0.00',
                    tax_amount:'0.00',
                    total_amount:'0.00',
                    discount_amount:'0.00',
                    notes:"Bank Name - ICICI BANK, ACCOUNT NUMBER - MODOMINES, ACCOUNT NUMBER - 278005000665, IFSC CODE - ICIC0002780, BANK BRANCH - JAGANATHAPURAM",
                    type: 'Monthly',
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
        methods: {
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
                    this.monthly=true;
                    this.yearly=false;
                }else{
                    this.yearly=true;
                    this.monthly=false;
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

            productChangeempty(add){
                add.price='';
                add.quantity='';
                add.tax_id='';
                add.total_amount='';
                add.description='';
                this.calculateLineTotal(add);
            },
            taxchange(option,add){
                console.log('add tax',option,add);
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
                    console.log(this.invoice.length);
                for (var i = 0; i < this.invoice.length; i++){
                    if(form.invoice_number==this.invoice[i]['invoice_number'])  return [this.errors.invoice_number=true,this.$refs.invoice_number.focus()];
                        else this.errors.invoice_number=false;
                }
                // if(form.order_number==null)  return [this.errors.order_number=true,this.$refs.order_number.focus()];
                //     else this.errors.order_number=false;
                if(form.due_at==null)  return [this.errors.due_at=true,this.$refs.due_at.focus()];
                    else this.errors.due_at=false;
                if(form.type=='Monthly'){
                    // if(form.start_date==null)  return [this.errors.start_date=true,this.$refs.start_date.focus()];
                    //     else this.errors.start_date=false;
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
        },
        mounted(){
        }
    });
</script>

<style>
@media (min-width: 1025px) {
    .description {
        width:40%;
    }
}

</style>
