<template>
  <app-menu />

    <div class="lg:pl-64 flex flex-col ">
    <div class="p-5">
        <form class="shadow-lg" @submit.prevent="update">
            <h2 class="font-semibold flex items-center text-lg pb-4">
                <img src="/assets/customer.png" class="h-6 w-6 mr-3 ml-3">
                <inertia-link :href="route('patron')" >UPDATE CUSTOMER</inertia-link>
                <span class="text-gray-500 font-medium">
                    <svg class="flex-shrink-0 h-9 w-9 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                <span class="text-gray-700"> {{ form.legal_name }}</span>
            </h2>
            <div class="">
                <div class=" lg:flex p-1">
                    <fieldset class="ml-2 p-1 flex-1 border-gray-900" >
                        <legend class="">Patron Details  </legend>
                        <div class="grid grid-cols-6 gap-2">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="legal_name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Legal Name
                                </label>
                                    <input type="text" v-model="form.legal_name" name="legal_name" id="legal_name" autocomplete="legal_name" class="shadow-sm md:h-textbox  block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.legal_name" class="text-red-500 text-xs">{{ form.errors.legal_name }}</div>

                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="gstin" class="block text-sm font-medium text-gray-700">
                                GST IN
                                </label>
                                    <input type="text"  v-model="form.gstin" name="gstin" id="gstin" autocomplete="gstin" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.gstin" class="text-red-500 text-xs">{{ form.errors.gstin }}</div>
                                </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="patron_type" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                Patron Type
                                </label>
                                <Multiselect class="!block"
                                    v-model="form.patron_type"
                                    mode="tags"
                                    placeholder="Select One"
                                    :options="options"
                                    :searchable="true"
                                    id="patron_type"
                                     :multiple="true"
                                    />
                                <div v-if="form.errors.patron_type" class="text-red-500 text-xs">{{ form.errors.patron_type }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="patron_type" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Credit Ledger
                                </label>
                                <Multiselect class="!block"
                                    v-model="form.credit_ledger_id"
                                    :value="this.credit_ledger.id"
                                    mode="tags"
                                    track_by="id" label="title"
                                    placeholder="Select One"
                                    :options="this.credit_ledger"
                                    :searchable="true"
                                    id="credit_ledger"
                                    :multiple="false"
                                    :allow-empty="false"
                                />

<!--                                <div v-if="form.errors.credit_ledger_id" class="text-red-500 text-xs">{{ form.errors.credit_ledger_id }}</div>-->
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="patron_type" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                   Debit Ledger
                                </label>
                                <Multiselect class="!block"
                                    :value="this.debit_ledger.id"
                                    v-model="form.debit_ledger_id"
                                    mode="tags" label="title"
                                    track_by="id"
                                    placeholder="Select One"
                                    :options="this.debit_ledger"
                                    :searchable="true"
                                    id="debit_ledger"
                                    :allow-empty="false"
                                    :multiple="false"
                                />
<!--                                <div v-if="form.errors.debit_ledger_id" class="text-red-500 text-xs">{{ form.errors.debit_ledger_id }}</div>-->
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        Owner Name
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="form.name" name="name" id="name"
                                            class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block h-8 w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}
                                        </div>
                                    </div>
                                </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label for="patron_type"
                                       class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Payment Mode
                                </label>
                                <Multiselect style="height: 35px;" class="!block" v-model="form.payment_mode"
                                             placeholder="Select" :options="paymentMode" :searchable="true"
                                />
                                <div v-if="form.errors.payment_mode" class="text-red-500 text-xs">{{form.errors.payment_mode }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <label for="lead_by"
                                       class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Lead By
                                </label>
                                <Multiselect style="height: 35px;" class="!block" v-model="form.lead_by"
                                             placeholder="Select" :options="Customer" :searchable="true" label="first_name"
                                />
                                <div v-if="form.errors.lead_by" class="text-red-500 text-xs">{{form.errors.lead_by }}</div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="ml-2 p-1 flex-1 border-gray-500" >
                        <legend class="">Contact Address</legend>
                            <div class="grid grid-cols-6 gap-2">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="zip_code" class="block text-sm font-medium text-gray-700">
                                Zip Code
                                </label>
                                <input type="number"  v-model="form.zipcode" name="zipcode" id="zipcode" autocomplete="zip_code" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                <div v-if="form.errors.zipcode" class="text-red-500 text-xs">{{ form.errors.zipcode }}</div>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="line_1" class="block text-sm font-medium text-gray-700">
                                    Address Line 1
                                </label>
                                <input type="text"  v-model="form.line_1" name="line_1" id="line_1" autocomplete="line_1" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                <div v-if="form.errors.line_1" class="text-red-500 text-xs">{{ form.errors.line_1 }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="line_2" class="block text-sm font-medium text-gray-700">
                                Address Line 2
                                </label>
                                <input type="text"  v-model="form.line_2" name="line_2" id="line_2" autocomplete="line_2" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                <div v-if="form.errors.line_2" class="text-red-500 text-xs">{{ form.errors.line_2 }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="landmark" class="block text-sm font-medium text-gray-700">
                                Landmark
                                </label>
                                <input type="text" v-model="form.landmark" name="landmark" id="landmark" autocomplete="landmark" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                <div v-if="form.errors.landmark" class="text-red-500 text-xs">{{ form.errors.landmark }}</div>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="city" class="block text-sm font-medium text-gray-700">
                                City
                                </label>
                                <input type="text" v-model="form.city" name="city" id="city" autocomplete="city" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                <div v-if="form.errors.city" class="text-red-500 text-xs">{{ form.errors.city }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="state_name" class="block text-sm font-medium text-gray-700">
                                State
                                </label>
                                <input type="text" v-model="form.state_name" name="state_name" id="state_name" autocomplete="state_name" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                <div v-if="form.errors.state_name" class="text-red-500 text-xs">{{ form.errors.state_name }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="tag" class="block text-sm font-medium text-gray-700">
                                    Tag
                                </label>
                                <input type="text" v-model="form.tag" name="tag" id="tag" autocomplete="tag" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                <div v-if="form.errors.tag" class="text-red-500 text-xs">{{ form.errors.tag }}</div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class=" lg:flex  p-1">
                    <fieldset class="ml-2 p-1 flex-1 border-gray-500" >
                        <legend class="">Contact Details</legend>
                            <div class="grid grid-cols-6 gap-2">

                            <div class="col-span-6 sm:col-span-2">
                                <label for="contact_type" class="block text-sm font-medium text-gray-700">
                                Contact Type
                                </label>
                                    <select id="contact_type" v-model="form.contact_type" name="contact_type" autocomplete="contact_type" class="shadow-sm focus:ring-indigo-500 md:h-select focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="Default">Default</option>
                                        <option value="Office">Office</option>
                                        <option value="Billing">Billing</option>
                                        <option value="Shipping">Shipping</option>
                                    </select>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email
                                </label>
                                    <input type="email" v-model="form.email" name="email" id="email" autocomplete="email" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.email" class="text-red-500 text-xs">{{ form.errors.email }}</div>
                                </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="mobile" class="block text-sm font-medium text-gray-700">
                                Mobile
                                </label>
                                    <input type="number" v-model="form.mobile" name="mobile" id="mobile" autocomplete="mobile" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.mobile" class="text-red-500 text-xs">{{ form.errors.mobile }}</div>
                                </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="land_line" class="block text-sm font-medium text-gray-700">
                                Land Line
                                </label>
                                    <input type="number" v-model="form.land_line" name="land_line" id="land_line" autocomplete="land_line" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.land_line" class="text-red-500 text-xs">{{ form.errors.land_line }}</div>
                                </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="alt_mobile" class="block text-sm font-medium text-gray-700">
                                Alt Mobile
                                </label>
                                    <input type="number" v-model="form.alt_mobile" name="alt_mobile" id="alt_mobile" autocomplete="alt_mobile" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.alt_mobile" class="text-red-500 text-xs">{{ form.errors.alt_mobile }}</div>
                                </div>
                        </div>
                    </fieldset>

                    <fieldset class="ml-2 p-1 flex-1 border-gray-500" >
                        <legend class="">Emergency Details</legend>
                        <div class="grid grid-cols-6 gap-2">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="secondary_address" class="block text-sm font-medium text-gray-700">
                                        Address
                                </label>
                                    <input type="text" v-model="form.secondary_address" name="secondary_address" id="secondary_address" autocomplete="secondary_address" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.secondary_address" class="text-red-500 text-xs">{{ form.errors.secondary_address }}</div>
                                </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="secondary_contact_name" class="block text-sm font-medium text-gray-700">
                                    Contact Name
                                </label>
                                    <input type="text" v-model="form.secondary_contact_name" name="secondary_contact_name" id="secondary_contact_name" autocomplete="secondary_contact_name" class="shadow-sm md:h-textbox focus:ring-indigo-300 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.secondary_contact_name" class="text-red-500 text-xs">{{ form.errors.secondary_contact_name }}</div>
                                </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="secondary_email" class="block text-sm font-medium text-gray-700">
                                    Email
                                </label>
                                    <input type="email" v-model="form.secondary_email" name="secondary_email" id="secondary_email" autocomplete="secondary_email" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.secondary_email" class="text-red-500 text-xs">{{ form.errors.secondary_email }}</div>
                                </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="secondary_phone" class="block text-sm font-medium text-gray-700">
                                    Phone
                                </label>
                                    <input type="number" v-model="form.secondary_phone" name="secondary_phone" id="secondary_phone" autocomplete="secondary_phone" class="shadow-sm md:h-textbox focus:ring-indigo-300 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.secondary_phone" class="text-red-500 text-xs">{{ form.errors.secondary_phone }}</div>
                                </div>

                        </div>
                    </fieldset>
                </div>
            </div>
                <div class="flex justify-start overflow-x-auto px-4">
                     <button type="button" @click="openCreate()" class="flex bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        <div>Add Address</div>
                    </button>

                    <div v-for="(datas ,index) in data" :key="datas.id" class="ml-2 flex">

                        <button type="button" @click="openModal(datas.contact_id)" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg> -->
                            Address {{index++}}
                        </button>
                    </div>
            </div>
            <div class="p-4">
                <div class="flex justify-between">
                    <button type="button"  tabindex="-1" @click="destroy(this.form.patron_id)" v-if="$page.props.auth.user.can['delete_patroncontact']==true" class=" bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Delete
                    </button>
                    <jet-button type="submit"  v-if="$page.props.auth.user.can['edit_patroncontact']==true" >
                    Update
                    </jet-button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <!-- Edit popup address -->
     <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400"  v-if="isOpen" >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            ​
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                    <form class="w-full max-w-xl bg-white max-w-7xl" @submit.prevent="addressupdate">

                       <div class="p-2"   >  <!-- md:flex xl:flex lg:flex v-for="(getadds ,index) in getadd" :key="getadds.id" :class="index % 2 === 1"-->
                          <fieldset class="ml-2 p-2 flex-1 border-gray-500" >
                            <legend>Contact Address</legend>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">
                                    Zip Code
                                    </label>
                                    <div class="">
                                        <input type="text"   v-model="getadd[0].zipcode" name="zipcode" id="zipcode" autocomplete="zipcode" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.zipcode" class="text-red-500">{{ forms.errors.zipcode }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="line_1" class="block text-sm font-medium text-gray-700">
                                        Address Line 1
                                    </label>
                                    <div class="">
                                        <input type="text"   v-model="getadd[0].line_1" name="line_1" id="line_1" autocomplete="line_1" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.line_1" class="text-red-500">{{ forms.errors.line_1 }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="line_2" class="block text-sm font-medium text-gray-700">
                                    Address Line 2
                                    </label>
                                    <div class="">
                                        <input type="text"   v-model="getadd[0].line_2" name="line_2" id="line_2" autocomplete="line_2" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.line_2" class="text-red-500">{{ forms.errors.line_2 }}</div> -->
                                    </div>
                                </div>
                            </div>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="landmark" class="block text-sm font-medium text-gray-700">
                                    Landmark
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="getadd[0].landmark" name="landmark" id="landmark" autocomplete="landmark" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.landmark" class="text-red-500">{{ forms.errors.landmark }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">
                                    City
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="getadd[0].city" name="city" id="city" autocomplete="city" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.city" class="text-red-500">{{ forms.errors.city }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="state_name" class="block text-sm font-medium text-gray-700">
                                    State
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="getadd[0].state_name" name="state_name" id="state_name" autocomplete="state_name" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.state_name" class="text-red-500">{{ forms.errors.state_name }}</div> -->
                                    </div>
                                </div>
                            </div>

                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="tag" class="block text-sm font-medium text-gray-700">
                                        Tag
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="getadd[0].tag" name="tag" id="tag" autocomplete="tag" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.tag" class="text-red-500">{{ forms.errors.tag }}</div> -->
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                           <fieldset class="ml-2 p-1 flex-1 border-gray-500" >
                            <legend>Contact Details</legend>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="contact_type" class="block text-sm font-medium text-gray-700">
                                    Contact Type
                                    </label>
                                    <div class="">
                                        <select id="contact_type"  v-model="getadd[0].contact_type" name="contact_type" autocomplete="contact_type" class="shadow-sm focus:ring-indigo-500 md:h-select focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="Default">Default</option>
                                            <option value="Office">Office</option>
                                            <option value="Billing">Billing</option>
                                            <option value="Shipping">Shipping</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">
                                        Email
                                    </label>
                                    <div class="">
                                        <input type="email"  v-model="getadd[0].email" name="email" id="email" autocomplete="email" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.email" class="text-red-500">{{ forms.errors.email }}</div> -->
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="mobile" class="block text-sm font-medium text-gray-700">
                                    Mobile
                                    </label>
                                    <div class="">
                                        <input type="number"  v-model="getadd[0].mobile" name="mobile" id="mobile" autocomplete="mobile" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.mobile" class="text-red-500">{{ forms.errors.mobile }}</div> -->
                                    </div>
                                </div>
                            </div>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="land_line" class="block text-sm font-medium text-gray-700">
                                    Land Line
                                    </label>
                                    <div class="">
                                        <input type="number"  v-model="getadd[0].land_line" name="land_line" id="land_line" autocomplete="land_line" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.land_line" class="text-red-500">{{ forms.errors.land_line }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="alt_mobile" class="block text-sm font-medium text-gray-700">
                                    Alt Mobile
                                    </label>
                                    <div class="">
                                        <input type="number"  v-model="getadd[0].alt_mobile" name="alt_mobile" id="alt_mobile" autocomplete="alt_mobile" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.alt_mobile" class="text-red-500">{{ forms.errors.alt_mobile }}</div> -->
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <gray-button  type="submit"  >
                            Save
                            </gray-button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <gray-button @click="closeModal()" type="button" >
                                Cancel
                            </gray-button>
                        </span>
                    </div>
                </form>

            </div>
        </div>
     </div>
      <!-- Create Address -->
       <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400"  v-if="isCreate">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form class="w-full max-w-xl bg-white max-w-7xl" @submit.prevent="address">
                       <div class="p-2" >  <!-- md:flex xl:flex lg:flex -->
                          <fieldset class="ml-2 p-2 flex-1 border-gray-500" >
                            <legend>Contact Address</legend>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">
                                    Zip Code
                                    </label>
                                    <div class="">
                                        <input type="number"  v-model="forms.zipcode" name="zipcode" id="zipcode" autocomplete="zip_code" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.zipcode" class="text-red-500 text-xs">{{ forms.errors.zipcode }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="line_1" class="block text-sm font-medium text-gray-700">
                                        Address Line 1
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="forms.line_1" name="line_1" id="line_1" autocomplete="line_1" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.line_1" class="text-red-500 text-xs">{{ forms.errors.line_1 }}</div>
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="line_2" class="block text-sm font-medium text-gray-700">
                                    Address Line 2
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="forms.line_2" name="line_2" id="line_2" autocomplete="line_2" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.line_2" class="text-red-500 text-xs">{{ forms.errors.line_2 }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="landmark" class="block text-sm font-medium text-gray-700">
                                    Landmark
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="forms.landmark" name="landmark" id="landmark" autocomplete="landmark" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.landmark" class="text-red-500 text-xs">{{ forms.errors.landmark }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">
                                    City
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="forms.city" name="city" id="city" autocomplete="city" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.city" class="text-red-500 text-xs">{{ forms.errors.city }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="state_name" class="block text-sm font-medium text-gray-700">
                                    State
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="forms.state_name" name="state_name" id="state_name" autocomplete="state_name" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.state_name" class="text-red-500 text-xs">{{ forms.errors.state_name }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="tag" class="block text-sm font-medium text-gray-700">
                                        Tag
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="forms.tag" name="tag" id="tag" autocomplete="tag" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.tag" class="text-red-500 text-xs">{{ forms.errors.tag }}</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="ml-2 p-1 flex-1 border-gray-500" >
                            <legend>Contact Details</legend>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="contact_type" class="block text-sm font-medium text-gray-700">
                                    Contact Type
                                    </label>
                                    <div class="">
                                        <select id="contact_type" v-model="forms.contact_type" name="contact_type" autocomplete="contact_type" class="shadow-sm focus:ring-indigo-500 md:h-select focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="Default">Default</option>
                                            <option value="Office">Office</option>
                                            <option value="Billing">Billing</option>
                                            <option value="Shipping">Shipping</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">
                                        Email
                                    </label>
                                    <div class="">
                                        <input type="email" v-model="forms.email" name="email" id="email" autocomplete="email" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.email" class="text-red-500 text-xs">{{ forms.errors.email }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="mobile" class="block text-sm font-medium text-gray-700">
                                    Mobile
                                    </label>
                                    <div class="">
                                        <input type="number" v-model="forms.mobile" name="mobile" id="mobile" autocomplete="mobile" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.mobile" class="text-red-500 text-xs">{{ forms.errors.mobile }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="land_line" class="block text-sm font-medium text-gray-700">
                                    Land Line
                                    </label>
                                    <div class="">
                                        <input type="number" v-model="forms.land_line" name="land_line" id="land_line" autocomplete="land_line" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.land_line" class="text-red-500 text-xs">{{ forms.errors.land_line }}</div>
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="alt_mobile" class="block text-sm font-medium text-gray-700">
                                    Alt Mobile
                                    </label>
                                    <div class="">
                                        <input type="number" v-model="forms.alt_mobile" name="alt_mobile" id="alt_mobile" autocomplete="alt_mobile" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="forms.errors.alt_mobile" class="text-red-500 text-xs">{{ forms.errors.alt_mobile }}</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <gray-button  type="submit"  >
                            Save
                            </gray-button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                            <gray-button @click="closeModal()" type="button" class="inline-flex items-center px-4 py-2 bg-white border  rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-200 active:bg-white focus:outline-none focus:border-white focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            Cancel
                            </gray-button>
                        </span>
                        </div>
                    </form>
                </div>
            </div>
     </div>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Pagination from '@/Jetstream/Pagination'
    import { useForm } from "@inertiajs/inertia-vue3";
    import TrashedMessage from '../TrashedMessage'
    import JetButton from '@/Jetstream/Button.vue'
    import Multiselect from '@suadelabs/vue3-multiselect'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import Swal from 'sweetalert2'
export default {
     metaInfo() {
        return { title: this.form.name }
        },
    remember: 'form',
    components: {
        AppLayout,
            AppMenu,
            Welcome,
            Pagination,
            TrashedMessage,
            Multiselect,
            GrayButton,
            JetButton
    },
     setup(props) {
        const form = useForm({
            id                  :   props.data[0].id,
            patron_id           :   props.data[0].patron_id,
            contact_id          :   props.data[0].contact_id,
            payment_mode          :   props.data[0].payment_mode,
            credit_ledger_id    :   props.data[0].credit_ledger_id ? props.c_ledgerId[0] : null,
            debit_ledger_id     :   props.data[0].debit_ledger_id ? props.d_ledgerId[0] : null,
            line_1              : props.data[0].line_1,
            line_2              : props.data[0].line_2,
            city                : props.data[0].city,
            state_name          : props.data[0].state_name,
            zipcode             : props.data[0].zipcode,
            tag                 : props.data[0].tag,
            email               : props.data[0].email,
            landmark            : props.data[0].landmark,
            contact_type        : props.data[0].contact_type,
            mobile              : props.data[0].mobile,
            alt_mobile          : props.data[0].alt_mobile,
            land_line           : props.data[0].land_line,
            secondary_address   : props.data[0].secondary_address,
            secondary_contact_name: props.data[0].secondary_contact_name,
            secondary_email     : props.data[0].secondary_email,
            secondary_phone     : props.data[0].secondary_phone,
            patron_type         : props.data[0].patron_type,
            legal_name          : props.data[0].legal_name,
            gstin               : props.data[0].gstin,
            name                : props.data[0].person_name,
            lead_by                : props.data[0].lead_by,

        });

        return {form};
    },

    data() {
        return {
            forms: this.$inertia.form({
                line_1: null,
                line_2: null,
                city: null,
                state_name: null,
                zipcode: null,
                landmark: null,
                contact_type: 'Default',
                tag: null,
                email: null,
                mobile: null,
                alt_mobile: null,
                land_line: null,
                name:null,
                lead_by:null,
            }),
            isOpen: false,
            isCreate: false,
            index:0,
            getadd:[],
            value:[],
            paymentMode : ["Monthly","Yearly"],
            options: ['Customer','Vendor','Contractor','Consultant','Service Provider','Supplier','Transport','Maistry','Party','Others'],
    }
},
    props: [
        'data', 'Customer',
        'patron_type',
        'credit_ledger','debit_ledger','c_ledgerId','d_ledgerId'
    ],
    methods: {
        update(){
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
                }).then((result) => {
                if (result.isConfirmed) {
                    this.form.put(this.route('patron.update', this.form.id))
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
                })
            },
        destroy(patron_id) {
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
                this.form.get(this.route('patron.destroy', patron_id))

            }
            })
        },

        address() {
            this.forms.post(this.route('patron.address', this.form.patron_id))
        },
        addressupdate(){
            this.getadd[0]._method = 'PUT';
            this.$inertia.put('../../addressupdate/' + this.getadd[0].id, this.getadd[0])
        },
        openModal: function(id){
            axios.get(this.route('patronaddress', id))
                .then(response => {
                    this.getadd = response.data
                    //console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
            })
              this.isOpen = true;
        },
        openCreate:function(){
            this.isCreate = true;
        },
        closeModal: function () {
                this.isOpen = false;
                this.isCreate = false;
            },
        multiselect(){
            this.form.patron_type=this.patron_type;
            // console.log(this.form.patron_type);
        },
    },
        mounted:function(){
             this.multiselect()
      },
}


</script>


