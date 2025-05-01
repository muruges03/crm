<template>
  <app-menu />
     <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <h2 class="font-semibold flex text-lg px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('personnel')"><img src="/assets/add-user.png" class="w-6 h-6 mr-3">Edit Personnel</inertia-link>
                    <span class="text-gray-500 font-medium mt-1">
                        <svg class="flex-shrink-0 h-7 w-7 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span class="text-gray-700 mt-1">{{ form.first_name }}</span>
                </h2>
                <div class="md:px-4 md:pt-6">
                    <div class="md:mx-8 md:visible invisible">
                        <div class="bg-gray-500 h-2 md:flex absolute" :style="fullWidth"></div>
                        <div class="flex justify-between md:px-8 md:mx-8">
                            <div class="bg-gray-400 px-4 py-4 w-16 h-16 rounded-full z-10" style="margin-top:-30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="bg-gray-400 px-4 py-4 w-16 h-16 rounded-full z-10"  style="margin-top:-30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="bg-gray-400 px-4 py-4 w-16 h-16 rounded-full z-10"  style="margin-top:-30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="bg-gray-400 px-4 py-4 w-16 h-16 rounded-full z-10"  style="margin-top:-30px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <ul class="md:flex md:justify-between md:mx-8">
                        <li class="mr-1">
                            <a  class="bg-white inline-block py-2 px-4 font-semibold"  v-bind:class="{'': openTab !== 1, 'border-t border-l border-r rounded-t bg-indigo-300 shadow-lg text-white': openTab === 1}">Personnel Details</a>
                        </li>
                        <li class="mr-1">
                            <a class="bg-white inline-block py-2 px-4 font-semibold" v-bind:class="{'': openTab !== 2, 'border-t border-l border-r rounded-t bg-indigo-300 shadow-lg text-white': openTab === 2}" >Contact Address</a>
                        </li>
                        <li class="mr-1">
                            <a class="bg-white inline-block py-2 px-4 font-semibold"  v-bind:class="{'': openTab !== 3, 'border-t border-l border-r rounded-t bg-indigo-300 shadow-lg text-white': openTab === 3}" >Additional Address</a>
                        </li>
                        <li class="mr-1">
                            <a class="bg-white inline-block py-2 px-4 font-semibold" v-bind:class="{'': openTab !== 4, 'border-t border-l border-r rounded-t bg-indigo-300 shadow-lg text-white': openTab === 4}" >Document Upload</a>
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
                                                 <!-- <div v-if="errors.date_
                                                 of_birth" class="text-red-500 text-xs">Please pick Date of birth</div> -->
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
                                                <jet-input type="text"  v-model="form.department" name="department" id="department" autocomplete="off"   />
                                                 <div v-if="errors.department" class="text-red-500 text-xs">Please Select Department</div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-3">
                                                <label for="role" class="block text-xs font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Role</label>
                                                <jet-input type="text"  v-model="form.role" name="role" id="role" autocomplete="off"   />
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
                                                <!-- <div v-if="errors.first_name" class="text-red-500 text-xs">Enter First Name</div> -->
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="bg-gray-50 py-3 flex justify-end">
                                        <jet-button type="button"  v-on:click="currentTab(2,form)" >
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
                                                <jet-input type="text" v-model="form.city" name="city" id="city after:content-['*'] after:ml-0.5 after:text-red-500"  />
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
                                    <div class="bg-gray-50  py-3 flex justify-between  ">
                                        <jet-button type="button" v-on:click="preTab(2)" >
                                            Previous
                                        </jet-button>
                                        <jet-button type="button" v-on:click="currentTab(3, form)" >
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
                                   <div class="bg-gray-50  py-3 flex justify-between  ">
                                        <jet-button type="button" v-on:click="preTab(3)" >
                                            Previous
                                        </jet-button>
                                        <jet-button type="button" v-on:click="currentTab(4, form)" >
                                            Next
                                        </jet-button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="openTab===4">
                                <div class="pl-2">
                                    <fieldset class="flex-1 border-gray-900" >
                                        <!-- <legend class="py-2">Personnel Details</legend> -->
                                        <div class="grid grid-cols-6 gap-2">
                                            <div class="col-span-6 sm:col-span-2">
                                                <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px "> Proof Upload </label>
                                                <div class=" sm:mt-0 sm:col-span-4">
                                                    <div class=" flex justify-center   border-2 border-gray-300 border-dashed rounded-md">
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
                                            <div class="col-span-6 sm:col-span-4 flex px-2">
                                                <img v-bind:src="imagePreview" style="height: 70px;width: 75%;" v-show="showPreview"/>
                                                <img
                                                    :src=" showImage() + form.proof_document"
                                                    class="object-cover h-25 w-40"
                                                />
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-6 gap-2 py-2">
                                            <div class="col-span-6 sm:col-span-2">
                                                <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px "> Aadhar Upload </label>
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
                                            <div class="col-span-6 sm:col-span-4 flex px-2">
                                                <!-- <div class="col-span-6 sm:col-span-2"> -->
                                                    <img v-bind:src="imagePreviewAadhar" style="height: 70px;width: 75%;" v-show="showPreviewAadhar"/>
                                                <!-- </div>
                                                <div class="col-span-6 sm:col-span-4"> -->
                                                    <img
                                                        :src="showImage() + form.aadharcard"
                                                        class="object-cover h-25 w-40"
                                                    />
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="bg-gray-50 py-3 md:flex justify-between">
                                        <button type="button" class="px-4 py-2 text-white font-medium bg-red-400 rounded-md"  @click="deletepersonnel()" >
                                            Delete
                                        </button>
                                        <div class=" flex py-2 md:py-0">
                                            <jet-button type="button" class="mx-2" v-on:click="preTab(4)" >
                                                Previous
                                            </jet-button>
                                            <jet-button type="button"  @click="update(form,proofdocument,aadharProof)" >
                                                Update
                                            </jet-button>
                                        </div>
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
    import JetButton from '@/Jetstream/Button.vue'
    import Swal from 'sweetalert2'
    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';
    import JetInput from '@/Jetstream/Input.vue'
    export default {
        metaInfo: { title: 'personnel' },
        remember: 'form',
        components: {
            AppLayout,
                AppMenu,
                Welcome,
                Pagination,
                JetButton,
                JetInput,
                Datepicker
        },
        data() {
            return {
                form:({
                    pid             :   this.personnel[0]['personnel_id'],
                    first_name      :   this.personnel[0]['first_name'],
                    last_name       :   this.personnel[0]['last_name'],
                    personnel_type  :   this.personnel[0]['personnel_type'],
                    gender          :   this.personnel[0]['gender'],
                    date_of_birth   :   this.personnel[0]['date_of_birth'],
                    department      :   this.depertment.department,
                    role            :   this.depertment.role,
                    joining_date    :   this.personnel[0]['joining_date'],
                    notes           :   this.personnel[0]['notes'],
                    proof_document  :   this.depertment.proof_document,
                    employee_code   :   this.depertment.employee_code,
                    aadharcard      :   this.depertment.aadharcard,
                    cid             :   this.personnel[0]['contact_id'],
                    line_1          :   this.personnel[0]['line_1'],
                    zipcode         :   this.personnel[0]['zipcode'],
                    city            :   this.personnel[0]['city'],
                    state_name      :   this.personnel[0]['state_name'],
                    email           :   this.personnel[0]['email'],
                    landmark        :   this.personnel[0]['landmark'],
                    mobile          :   this.personnel[0]['mobile'],
                    alt_mobile      :   this.personnel[0]['alt_mobile'],

                    relation_type   :       this.personnel[0]['relation_type'],
                    secondary_contact_name: this.personnel[0]['secondary_contact_name'],
                    secondary_address   :   this.personnel[0]['secondary_address'],
                    secondary_email  :  	this.personnel[0]['secondary_email'],
                    secondary_phone  :      this.personnel[0]['secondary_phone'],

                }),
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
            openTab             : 1,
            imagePreview        : null,
            imagePreviewAadhar  : null,
            showPreview         : false,
            showPreviewAadhar   : false,
            width               : 20,

            }
        },

        props: {
            personnel: Object,
            depertment: Object,
        },

    methods: {
        deletepersonnel() {
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
                    console.log(this.form.pid, this.form.cid);
                    this.$inertia.delete(this.route('personnel.destroy', [this.form.pid, this.form.cid]))
                }
            });
        },

        update(form,proofdocument,aadharProof) {
            if(form.secondary_contact_name==null) return [this.errors.secondary_contact_name=true];
                else this.errors.secondary_contact_name=false;
            if(form.secondary_phone==null) return [this.errors.secondary_phone=true];
                else this.errors.secondary_phone=false;

             this.$inertia.post(this.route('personnel.update'),{form:form, proofdocument:proofdocument, aadharProof:aadharProof});
        },


             currentTab: function (tabNumber, form) {
                 if(tabNumber===2)
                {
                    console.log("asdad",form.employee_code);
                    if(form.first_name==null)  return [this.errors.first_name=true];
                        else this.errors.first_name=false;
                    if(form.last_name==null)  return [this.errors.last_name=true];
                        else this.errors.last_name=false;
                     if(form.date_of_birth==null)  return [this.errors.date_of_birth=true];
                        else this.errors.date_of_birth=false;
                    if(form.gender==null)  return [this.errors.gender=true];
                        else this.errors.gender=false;
                    if(form.department==null)  return [this.errors.department=true];
                        else this.errors.department=false;
                    if(form.role==null)  return [this.errors.role=true];
                        else this.errors.role=false;
                    if(form.joining_date==null)  return [this.errors.joining_date=true];
                        else this.errors.joining_date=false;
                    if(form.employee_code==null)  return [this.errors.employee_code=true];
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
            showImage() {
                var img='/storage/public/';
                return img;
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
</style>
