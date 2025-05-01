<template>
  <app-menu />
    <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <h2 class="text-lg font-semibold flex px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('personnel')">
                        <img src="/assets/add-user.png" class="w-6 h-6 mr-3">Create Personnel
                    </inertia-link>
                </h2>
                <div class="md:px-4 md:pt-6 ">
                    <div class="md:mx-4 md:visible invisible">
                        <div class="bg-gray-500 h-2 md:flex absolute" :style="fullWidth"></div>
                        <div class="flex justify-between md:px-8 md:mx-8">
                            <div class="bg-gray-400 md:px-4 md:py-4 px-2 py-2 md:w-16 md:h-16 h-10 w-10 rounded-full z-10" style="margin-top:-30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="md:h-8 md:w-8 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="bg-gray-400 md:px-4 md:py-4 px-2 py-2 md:w-16 md:h-16 h-10 w-10 rounded-full z-10"  style="margin-top:-30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="md:h-8 md:w-8 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="bg-gray-400 md:px-4 md:py-4 px-2 py-2 md:w-16 md:h-16 h-10 w-10 rounded-full z-10"  style="margin-top:-30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="md:h-8 md:w-8 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="bg-gray-400 md:px-4 md:py-4 px-2 py-2 md:w-16 md:h-16 h-10 w-10 rounded-full z-10"  style="margin-top:-30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="md:h-8 md:w-8 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <ul class="md:flex md:justify-between ">
                        <li class="mr-1">
                            <a  class="bg-white inline-block py-2 px-4 font-semibold"  v-bind:class="{'': openTab !== 1, 'border-t border-l border-r bg-indigo-300 rounded-t shadow-lg text-white': openTab === 1}">Personnel Details</a>
                        </li>
                        <li class="mr-1">
                            <a class="bg-white inline-block py-2 px-4 font-semibold" v-bind:class="{'': openTab !== 2, 'border-t border-l border-r rounded-t bg-indigo-300  shadow-lg text-white': openTab === 2}" >Contact Address</a>
                        </li>
                        <li class="mr-1">
                            <a class="bg-white inline-block py-2 px-4 font-semibold" v-bind:class="{'': openTab !== 3, 'border-t border-l border-r rounded-t bg-indigo-300 shadow-lg text-white': openTab === 3}" >Additional Address</a>
                        </li>
                        <li class="mr-1">
                            <a class="bg-white inline-block py-2 px-4 font-semibold"  v-bind:class="{'': openTab !== 4, 'border-t border-l border-r rounded-t bg-indigo-300 shadow-lg text-white': openTab === 4}" >Document Upload</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <form class="bg-white md:px-4 md:py-4">
                        <div class="space-y-1 divide-y divide-gray-200">
                            <div  v-if="openTab===1">
                                <div class="pl-2">
                                    <fieldset class="flex-1 border-gray-900" >
                                        <!-- <legend class="py-2">Personnel Details</legend> -->
                                        <div class="grid grid-cols-12 gap-2">
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="first_name" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">First Name</label>
                                                <jet-input type="text"  v-model="form.first_name" name="first_name" id="first_name" autocomplete="off"   />
                                                  <div v-if="errors.first_name" class="text-red-500 text-xs">Enter First Name</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="last_name" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Last Name</label>
                                                <jet-input type="text"  v-model="form.last_name" name="last_name" id="last_name" autocomplete="off"   />
                                                <div v-if="errors.last_name" class="text-red-500 text-xs">Enter Last Name</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="date_of_birth" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Birth Date</label>
                                                <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                                            ref="date_of_birth" name="date_of_birth" v-model="form.date_of_birth" autoApply :enableTimePicker="false"
                                                            id="date_of_birth"  autocomplete="date_of_birth" placeholder="D.O.B" />
                                                 <!-- <div v-if="errors.date_of_birth" class="text-red-500 text-xs">Please pick Date of birth</div> -->
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="gender" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Gender</label>
                                                <select id="gender" v-model="form.gender" name="gender" class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" >\
                                                    <option value="null" disabled selected hidden>Choose.</option>
                                                    <option value="" class="" disabled>Choose</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                 <div v-if="errors.gender" class="text-red-500 text-xs">Please Select Gender</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="department" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Department</label>
                                                <jet-input type="text"  v-model="form.department" name="department" id="department" autocomplete="off" />
                                                 <div v-if="errors.department" class="text-red-500 text-xs">Please Select Department</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="role" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Role</label>
                                                <jet-input type="text"  v-model="form.role" name="role" id="role" autocomplete="off" />
                                                 <div v-if="errors.role" class="text-red-500 text-xs">Please Select Role</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="joining_date" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Joining date</label>
                                                <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                                            ref="joining_date" name="joining_date" v-model="form.joining_date" autoApply :enableTimePicker="false"
                                                            id="joining_date"  autocomplete="joining_date" placeholder="Joining date" />
                                                 <div v-if="errors.joining_date" class="text-red-500 text-xs">Please Pick Joining date</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="personnel_type" class="block text-xs font-medium text-gray-700">
                                                    Personnel Type
                                                </label>
                                                <select id="personnel_type" v-model="form.personnel_type" name="personnel_type"  class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" >
                                                    <option value="null" disabled selected hidden>Choose.</option>
                                                    <option value="" class="" disabled>Choose</option>
                                                    <option value="Employee">Employee</option>
                                                </select>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="employee_code" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Employee Code</label>
                                                <jet-input type="text"  v-model="form.employee_code" name="employee_code" id="employee_code" autocomplete="off"/>
                                                 <div v-if="errors.employee_code" class="text-red-500 text-xs">Please Enter Employee Code</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="notes" class="block text-xs font-medium text-gray-700">Notes</label>
                                                <textarea  v-model="form.notes" name="notes" id="notes" autocomplete="off" class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"  />
                                             </div>
                                        </div>
                                    </fieldset>
                                    <div class="bg-gray-50 py-3 flex justify-end ">
                                        <jet-button type="button"  v-on:click="currentTab(2)" >
                                            Next
                                        </jet-button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="openTab===2">
                                <div class="pl-2">
                                    <fieldset class="flex-1 border-gray-900" >
                                        <!-- <legend class="p-2">Contact Address</legend> -->
                                        <div class="grid grid-cols-12 gap-2">
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="line_1" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                                    Address
                                                </label>
                                                <jet-input type="text"  v-model="form.line_1" name="line_1" id="line_1"/>
                                               <div v-if="errors.line_1" class="text-red-500 text-xs">Please Enter Address</div>
                                            </div>

                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="city" class="block text-xs font-medium text-gray-700">
                                                City
                                                </label>
                                                <jet-input type="text" v-model="form.city" name="city" id="city" class=" after:content-['*'] after:ml-0.5 after:text-red-500"  />
                                               <div v-if="errors.city" class="text-red-500 text-xs">Please Enter City</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="landmark" class="block text-xs font-medium text-gray-700">
                                                Landmark
                                                </label>
                                                <jet-input type="text" v-model="form.landmark" name="landmark" id="landmark"   />
                                                <!-- <div v-if="errors.first_name" class="text-red-500 text-xs">Enter First Name</div> -->
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="state_name" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                                State
                                                </label>
                                                <jet-input type="text" v-model="form.state_name" name="state_name" id="state_name" />
                                                <div v-if="errors.state_name" class="text-red-500 text-xs">Please Enter State Name</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="zip_code" class="block text-xs font-medium text-gray-700">
                                                Zip Code
                                                </label>
                                                <jet-input type="number"  v-model="form.zipcode" name="zipcode" id="zipcode" />
                                                <!-- <div v-if="errors.zipcode" class="text-red-500 text-xs">Please Enter Zipcode</div> -->
                                            </div>

                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="email" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                                    Email
                                                </label>
                                                <jet-input type="email" v-model="form.email" name="email" id="email"   />
                                                <div v-if="errors.email" class="text-red-500 text-xs">Please Enter Email</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="mobile" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                                Mobile
                                                </label>
                                                <jet-input type="number" v-model="form.mobile" name="mobile" id="mobile"   />
                                                <div v-if="errors.mobile" class="text-red-500 text-xs">Please enter Mobile number</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="alt_mobile" class="block text-xs font-medium text-gray-700">
                                                Alt Mobile
                                                </label>
                                                <jet-input type="number" v-model="form.alt_mobile" name="alt_mobile" id="alt_mobile"   />
                                                <!-- <div v-if="errors.first_name" class="text-red-500 text-xs">Enter First Name</div> -->
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="bg-gray-50  py-3 flex justify-between">
                                          <jet-button type="button" v-on:click="preTab(2)" >
                                            Previous
                                        </jet-button>
                                        <jet-button type="button" v-on:click="currentTab(3)" >
                                            Next
                                        </jet-button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="openTab===3">
                                <div class="pl-2">
                                    <fieldset class="flex-1 border-gray-900" >
                                        <!-- <legend class="p-2">Contact Address</legend> -->
                                        <div class="grid grid-cols-12 gap-2">
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="relation_type" class="block text-xs font-medium text-gray-700 ">
                                                    Relation Type
                                                </label>
                                                <jet-input type="text"  v-model="form.relation_type" name="relation_type" id="relation_type"/>
                                               <div v-if="errors.relation_type" class="text-red-500 text-xs">Please Enter Relation Type.</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="secondary_contact_name" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                                Parent/Spouse Name
                                                </label>
                                                <jet-input type="text" v-model="form.secondary_contact_name" name="secondary_contact_name" id="secondary_contact_name"   />
                                                <div v-if="errors.secondary_contact_name" class="text-red-500 text-xs">Enter First Name</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="secondary_address" class="block text-xs font-medium text-gray-700">
                                                Address
                                                </label>
                                                <jet-input type="text" v-model="form.secondary_address" name="secondary_address" id="secondary_address" class=" after:content-['*'] after:ml-0.5 after:text-red-500"  />
                                               <div v-if="errors.secondary_address" class="text-red-500 text-xs">Please Enter Address</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="secondary_email" class="block text-xs font-medium text-gray-700">
                                                    Email
                                                </label>
                                                <jet-input type="email" v-model="form.secondary_email" name="secondary_email" id="secondary_email"   />
                                                <div v-if="errors.secondary_email" class="text-red-500 text-xs">Please Enter Email</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="secondary_phone" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                                Mobile
                                                </label>
                                                <jet-input type="number" v-model="form.secondary_phone" name="secondary_phone" id="secondary_phone"   />
                                                <div v-if="errors.secondary_phone" class="text-red-500 text-xs">Please enter Mobile number</div>
                                            </div>

                                        </div>
                                    </fieldset>
                                    <div class="bg-gray-50 py-3 flex justify-between">
                                          <jet-button type="button" v-on:click="preTab(3)" >
                                            Previous
                                        </jet-button>
                                        <jet-button type="button" v-on:click="currentTab(4)" >
                                            Next
                                        </jet-button>
                                    </div>
                                </div>
                            </div>
                            <div  v-if="openTab===4">
                                <div class="pl-2">
                                    <fieldset class="flex-1 border-gray-900" >
                                        <!-- <legend class="py-2">Personnel Details</legend> -->
                                        <div class="grid grid-cols-6 gap-2 py-2">
                                            <div class="col-span-6 sm:col-span-2">
                                                <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px  after:content-['*'] after:ml-0.5 after:text-red-500"> Proof Upload </label>
                                                <div class=" sm:mt-0 sm:col-span-4">
                                                    <div class="flex justify-center border-2 border-gray-300 border-dashed rounded-md">
                                                        <div class="space-y-1 text-center">
                                                            <svg class="mx-auto h-6 w-6 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                            <div class="flex text-sm text-gray-600">
                                                                <label for="proof_document" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                                <span>Upload a file</span>
                                                                <input id="proof_document" name="proof_document[]" class="sr-only"  type="file" @change="onFileChangeProof" ref="proof_document" />
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="proofdocumenterror.proof_document" class="text-red-500 text-xs">Please Upload Proof</div>
                                            </div>
                                            <div class="col-span-6 sm:col-span-4">
                                                <img v-bind:src="imagePreview" style="height: 70px;width: 100%;" v-show="showPreview"/>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-6 gap-2 py-2">
                                            <div class="col-span-12 sm:col-span-2">
                                                <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px  after:content-['*'] after:ml-0.5 after:text-red-500"> Aadhar Upload </label>
                                                <div class=" sm:mt-0 sm:col-span-4">
                                                    <div class=" flex justify-center   border-2 border-gray-300 border-dashed rounded-md">
                                                        <div class="space-y-1 text-center">
                                                            <svg class="mx-auto h-6 w-6 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                            <div class="flex text-sm text-gray-600">
                                                                <label for="aadharcard" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                                <span>Upload a file</span>
                                                                <input id="aadharcard" name="aadharcard" class="sr-only"  type="file" @change="onFileChangeAadhar" ref="aadharcard" />
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="aadharProoferror.aadharcard" class="text-red-500 text-xs">Please Upload Aadhar card </div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-4">
                                                <img v-bind:src="imagePreviewAadhar" style="height: 70px;width: 100%;" v-show="showPreviewAadhar"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="bg-gray-50 py-3 flex justify-between ">
                                          <jet-button type="button" v-on:click="preTab(4)" >
                                            Previous
                                        </jet-button>
                                        <jet-button type="button"  @click="save(form,proofdocument,aadharProof)" >
                                            Create
                                        </jet-button>
                                    </div>
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
    import Pagination from '@/Jetstream/Pagination'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import Swal from 'sweetalert2'

    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';
    export default {

        metaInfo: { title: 'Product' },
        remember: 'form',
        components: {
            AppLayout,
                AppMenu,
                Welcome,
                Pagination,
                GrayButton,
                JetButton,
                JetInput,
                Datepicker
        },

        props: [],
        data() {
        return {
            form:{

                first_name      : null,
                last_name       : null,
                personnel_type  : 'Employee',
                gender          : null,
                date_of_birth   : null,
                department      : null,
                role            : null,
                joining_date    : null,
                notes           : null,
                employee_code   : null,

                line_1          : null,
                zipcode         : null,
                city            : null,
                state_name      : null,
                email           : null,
                landmark        : null,
                mobile          : null,
                alt_mobile      : null,

                relation_type   :       null,
                secondary_contact_name: null,
                secondary_address   :   null,
                secondary_email  :  	null,
                secondary_phone  :      null,

            },
              errors:{
                first_name              : false,
                last_name               : false,
                date_of_birth           : false,
                // personnel_type          : false,
                gender                  : false,
                department              : false,
                role                    : false,
                joining_date            : false,
                employee_code           : false,
                line_1                  : false,
                // zipcode                 : false,
                city                    : false,
                state_name              : false,
                mobile                  : false,
                email                   : false,
                secondary_contact_name  : false,
                secondary_phone         : false,
            },
             proofdocument:{
                    proof_document  : null,
                },
            proofdocumenterror:{
                proof_document  : false,
            },
            aadharProof:{
                aadharcard      : null,
            },
            aadharProoferror:{
                aadharcard      : false,
            },
            openTab              : 1,
            imagePreview         : null,
            imagePreviewAadhar   : null,
            showPreview          : false,
            showPreviewAadhar    : false,
             width               : 20,
        }
    },
    methods: {

        save(form,proofdocument,aadharProof) {
             if(proofdocument.proof_document==null)  return [this.proofdocumenterror.proof_document=true];
                else this.proofdocumenterror.proof_document=false;
            if(aadharProof.aadharcard==null)  return [this.aadharProoferror.aadharcard=true];
                else this.aadharProoferror.aadharcard=false;


             this.$inertia.post(this.route('personnel.store'),{form: form, proofdocument: proofdocument, aadharProof: aadharProof});


            // Swal.fire({
            //     title: 'Do you want to Create the changes?',
            //     showDenyButton: true,
            //     confirmButtonText: 'Create',
            //     denyButtonText: `Don't Create`,
            //     }).then((result, data) => {
            //     if (result.isConfirmed) {
            //         this.form.post(this.route('personnel.store', data), {
            //         preserveScroll: true,
            //         // onSuccess: () => {
            //         //         location.reload();
            //         // },
            //     });
            //     } else if (result.isDenied) {
            //         Swal.fire('Changes are not Updated', '', 'info')
            //     }
            //     })
            },
            currentTab: function (tabNumber) {
                if(tabNumber===2)
                {
                    if(this.form.first_name==null)  return [this.errors.first_name=true];
                        else this.errors.first_name=false;
                    if(this.form.last_name==null)  return [this.errors.last_name=true];
                        else this.errors.last_name=false;
                     if(this.form.date_of_birth==null)  return [this.errors.date_of_birth=true];
                        else this.errors.date_of_birth=false;
                    if(this.form.gender==null)  return [this.errors.gender=true];
                        else this.errors.gender=false;
                    if(this.form.department==null)  return [this.errors.department=true];
                        else this.errors.department=false;
                    if(this.form.role==null)  return [this.errors.role=true];
                        else this.errors.role=false;
                    if(this.form.joining_date==null)  return [this.errors.joining_date=true];
                        else this.errors.joining_date=false;
                    if(this.form.employee_code==null)  return [this.errors.employee_code=true];
                        else this.errors.employee_code=false;
                    this.width += 20;
                }
                if(tabNumber===3)
                {
                    if(this.form.line_1==null)  return [this.errors.line_1=true];
                        else this.errors.line_1=false;
                    if(this.form.city==null)  return [this.errors.city=true];
                        else this.errors.city=false;
                    if(this.form.state_name==null)  return [this.errors.state_name=true];
                        else this.errors.state_name=false;
                    if(this.form.email==null)  return [this.errors.email=true];
                        else this.errors.email=false;
                    if(this.form.mobile==null)  return [this.errors.mobile=true];
                        else this.errors.mobile=false;
                     this.width += 20;
                }
                 if(tabNumber===4)
                {
                    if(this.form.secondary_contact_name==null) return [this.errors.secondary_contact_name=true];
                        else this.errors.secondary_contact_name=false;
                    if(this.form.secondary_phone==null) return [this.errors.secondary_phone=true];
                        else this.errors.secondary_phone=false;
                     this.width += 10;
                }

                this.openTab = tabNumber;

            },
            preTab(tabNumber){
                if(tabNumber > 1){
                    this.openTab = tabNumber - 1;
                    if(tabNumber===4){
                        this.width -= 10;
                    }else{
                        this.width -=20;
                    }
                    // console.log( tabNumber,   this.openTab);
                }else{
                    this.openTab = tabNumber;
                      console.log( "else",   this.openTab);
                }

            },
            onFileChangeProof(event){
                //alert('asd');
                this.proofdocument.proof_document = event.target.files[0];
                let reader  = new FileReader();
                reader.addEventListener("load", function () {
                this.showPreview = true;
                this.imagePreview = reader.result;
                    }.bind(this), false);
                if( this.proofdocument.proof_document ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.proofdocument.proof_document.name ) ) {
                        // console.log("here", this.proofdocument.invoice_path.name);
                        reader.readAsDataURL( this.proofdocument.proof_document );
                    }
                }
            },
            onFileChangeAadhar(event){
                // alert('asd');
                this.aadharProof.aadharcard = event.target.files[0];
                let reader  = new FileReader();
                reader.addEventListener("load", function () {
                this.showPreviewAadhar = true;
                this.imagePreviewAadhar = reader.result;
                    }.bind(this), false);
                if( this.aadharProof.aadharcard ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.aadharProof.aadharcard.name ) ) {
                        // console.log("here", this.aadharProof.invoice_path.name);
                        reader.readAsDataURL( this.aadharProof.aadharcard );
                    }
                }
            },

        },
         computed: {
            fullWidth () {
                return `width:${this.width}%`;
            },
         }

    }
</script>

<style>
.shadow-lg {
    --tw-shadow: 0px 0px 15px 13px rgba(0, 0, 0, 0.1), 0px 0px 7px 1px rgba(0, 0, 0, 0.05);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}

#preview img {
  max-width: 100%;
  max-height: 500px;
}
</style>
