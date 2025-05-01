<template>
   <app-menu />
    <h2 class=" flex lg:pl-64 ml-8 font-bold items-center text-2xl pt-2">
        <inertia-link  class="" :href="route('entities')">Entity</inertia-link>
        <span class="text-gray-400 font-medium">
            <svg class="flex-shrink-0 h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </span>
        <span class="text-gray-700">{{ form.legal_name }}</span>
    </h2>

   <div class="lg:pl-64 flex flex-col  divide-x divide-gray-100 border-1 shadow-md">
     <div class=" md:col-span-2 p-5">
        <form class=" border-2" @submit.prevent="store">
            <div class="space-y-1 divide-y divide-gray-200">
                <div class="pt-1">
                    <div class=" lg:flex p-2">
                          <fieldset class="ml-2 p-1 flex-1 border-gray-900" >
                             <legend>Entity Details</legend>
                                    <div class="grid grid-cols-6 gap-4">
                                        <div class="col-span-6 sm:col-span-2">
                                            <label for="last-name" class="block text-sm font-medium text-gray-700">Legal Name</label>
                                            <div class="">
                                                <input type="text"  v-model="form.legal_name"  id="legal_name" autocomplete="family-name"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                <div v-if="form.errors.legal_name" class="text-red-500 text-xs">{{ form.errors.legal_name }}</div>
                                            </div>
                                        </div>
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="email-address" class="block text-sm font-medium text-gray-700">Alias</label>
                                        <div class="">
                                            <input type="text" v-model="form.alias"  id="alias"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            <div v-if="form.errors.alias" class="text-red-500 text-xs">{{ form.errors.alias }}</div>
                                        </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="gstin" class="block text-sm font-medium text-gray-700">GST IN</label>
                                        <div class="">
                                            <input id="gstin" type="text" class=" focus:ring-indigo-500 md:h-textbox  focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"  v-model="form.gstin"   />
                                            <div v-if="form.errors.gstin" class="text-red-500 text-xs">{{ form.errors.gstin }}</div>
                                            </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="url" class="block text-sm font-medium text-gray-700">Url</label>
                                        <div class="">
                                            <input id="url" type="text" class=" focus:ring-indigo-500 md:h-textbox  focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"  v-model="form.url"   />
                                            <div v-if="form.errors.url" class="text-red-500 text-xs">{{ form.errors.url }}</div>
                                         </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="password-confirmation" class="block text-sm font-medium text-gray-700">Api Key</label>
                                        <div class="">
                                            <input id="api_key" type="text" class=" focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" name="api_key" v-model="form.api_key" />
                                            <div v-if="form.errors.api_key" class="text-red-500 text-xs">{{ form.errors.api_key }}</div>
                                         </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-2">
                                         <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                        <div class="">
                                            <select id="status" v-model="form.status" name="Status" autocomplete="Inactive" class=" block w-full md:h-select focus:ring-indigo-500  focus:border-indigo-300 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <option :value="null" />
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <div v-if="form.errors.status" class="text-red-500 text-xs">{{ form.errors.status }}</div>
                                         </div>
                                    </div>
                                        <div class="col-span-6 sm:col-span-2">
                                            <label for="status" class="block text-sm font-medium text-gray-700">Entity Type</label>
                                            <select id="entity_type" v-model="form.entity_type" @change="patron(form.entity_type)" name="entity_type" class=" block w-full md:h-select py-2 px-3 focus:ring-indigo-500  focus:border-indigo-300 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <option :value="null" />
                                                <option value="Organization"> Organization</option>
                                                <option value="Company">Company</option>
                                            </select>
                                            <div v-if="form.errors.entity_type" class="text-red-500 text-xs">{{ form.errors.entity_type }}</div>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2" v-if="Company=='Company'">
                                            <label for="entity_access" class="block text-sm font-medium text-gray-700">
                                                Parent Id
                                            </label>
                                            <div class="">
                                                <select
                                                     class="block answer text-sm appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-2 px-2 pr-4 rounded leading-tight focus:outline-none focus: focus:border-gray-500"
                                                                id="parent_id"
                                                                :searchable="true"
                                                                v-model="form.parent_id"
                                                            >
                                                            <option value="null" disabled selected hidden>Select Parent</option>
                                                                <option
                                                                v-for="entityorgs in entityorg"
                                                                :value="entityorgs.id"
                                                                :key="entityorgs.id"
                                                                :data-type="Option"
                                                                class="text-sm"
                                                                >
                                                                {{ entityorgs.legal_name }}
                                                            </option>
                                                        </select>
                                                <div v-if="form.errors.entity_access" class="text-red-500 text-xs">{{ form.errors.entity_access }}</div>
                                            </div>
                                        </div>

                                        <div class="col-span-6 sm:col-span-4">
                                             <label for="description" class="block text-sm font-medium text-gray-700">
                                                Description
                                            </label>
                                            <div class="">
                                                <textarea id="description"  v-model="form.description" name="description" rows="3" class="block w-full py-2 px-3 focus:ring-indigo-500  focus:border-indigo-300 shadow-sm sm:text-sm border-gray-300 rounded-md" />

                                                <p class="mt-2 text-sm text-gray-500">Write a few sentences about yourself.</p>
                                                <div v-if="form.errors.description" class="text-red-500 text-xs">{{ form.errors.description }}</div>
                                            </div>
                                        </div>

                                        <div  class="col-span-6 sm:col-span-2">
                                            <label for="logo_file" class="block text-sm font-medium text-gray-700">Company Logo</label>
                                            <input
                                                type="file"
                                                @change="previewImage"
                                                ref="photo"
                                                id="logo_file"
                                                name="logo_file"
                                                class="
                                                    w-full
                                                    px-2
                                                    py-1
                                                    text-sm

                                                    border
                                                    rounded-md
                                                    focus:outline-none
                                                    focus:ring-1
                                                    focus:ring-blue-600
                                                "
                                            />
                                                <img
                                                    v-if="url"
                                                    :src="url"
                                                    class="w-full text-xs mt-4 h-40 w-40"
                                                />

                                     <div v-if="form.errors.logo_file" class="text-xs text-red-500 ">{{ form.errors.logo_file }}</div>
                                 </div>
                                <div  class="col-span-6 sm:col-span-2 mt-5">
                                    <gray-button type="button"  tabindex="-1" @click="image(images)" >
                                        Update Image
                                    </gray-button>
                                </div>
                                <div class="col-span-6 sm:col-span-2 ">
                                <label for="images" class="mb-2 block text-sm font-medium text-gray-700">Image</label>
                                <img
                                    :src="showImage() + form.logo_file"
                                    class=" h-20 w-auto "
                                />

                            </div>

                                </div>
                        </fieldset>
                        <fieldset class="ml-2 p-2 flex-1 border-gray-500" >
                            <legend>Contact Address</legend>
                            <div class="grid grid-cols-6 gap-4">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">
                                    Zip Code
                                    </label>
                                    <div class="">
                                        <input type="number"  v-model="form.zipcode" name="zipcode" id="zipcode"  class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.zipcode" class="text-red-500 text-xs">{{ form.errors.zipcode }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="line_1" class="block text-sm font-medium text-gray-700">
                                        Address Line 1
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="form.line_1" name="line_1" id="line_1" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.line_1" class="text-red-500 text-xs">{{ form.errors.line_1 }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="line_2" class="block text-sm font-medium text-gray-700">
                                    Address Line 2
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="form.line_2" name="line_2" id="line_2" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.line_2" class="text-red-500 text-xs">{{ form.errors.line_2 }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="landmark" class="block text-sm font-medium text-gray-700">
                                    Landmark
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="form.landmark" name="landmark" id="landmark"  class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.landmark" class="text-red-500 text-xs">{{ form.errors.landmark }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">
                                    City
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="form.city" name="city" id="city"  class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.city" class="text-red-500 text-xs">{{ form.errors.city }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="state_name" class="block text-sm font-medium text-gray-700">
                                    State
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="form.state_name" name="state_name" id="state_name"  class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.state_name" class="text-red-500 text-xs">{{ form.errors.state_name }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="tag" class="block text-sm font-medium text-gray-700">
                                        Tag
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="form.tag" name="tag" id="tag"  class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.tag" class="text-red-500 text-xs">{{ form.errors.tag }}</div>
                                    </div>
                                </div>
                            </div>
                            <legend>Contact Details</legend>
                            <div class="grid grid-cols-6 gap-4">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="contact_type" class="block text-sm font-medium text-gray-700">
                                    Contact Type
                                    </label>
                                    <div class="">
                                        <select id="contact_type" v-model="form.contact_type" name="contact_type"  class="shadow-sm focus:ring-indigo-500 md:h-select focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md">
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
                                        <input type="email" v-model="form.email" name="email" id="email"  class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.email" class="text-red-500 text-xs">{{ form.errors.email }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="mobile" class="block text-sm font-medium text-gray-700">
                                    Mobile
                                    </label>
                                    <div class="">
                                        <input type="number" v-model="form.mobile" name="mobile" id="mobile"  class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.mobile" class="text-red-500 text-xs">{{ form.errors.mobile }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="land_line" class="block text-sm font-medium text-gray-700">
                                    Land Line
                                    </label>
                                    <div class="">
                                        <input type="number" v-model="form.land_line" name="land_line" id="land_line"  class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.land_line" class="text-red-500 text-xs">{{ form.errors.land_line }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="alt_mobile" class="block text-sm font-medium text-gray-700">
                                    Alt Mobile
                                    </label>
                                    <div class="">
                                        <input type="number" v-model="form.alt_mobile" name="alt_mobile" id="alt_mobile"  class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.alt_mobile" class="text-red-500 text-xs">{{ form.errors.alt_mobile }}</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                    </div>
                <div class="">
                <div class="flex overflow-x-auto justify-start p-2">
                     <gray-button type="button" @click="openCreate()" class="flex  py-2 px-4   ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        <div>Add Address</div>
                    </gray-button>

                    <div v-for="(entitie ,index) in entities" :key="entitie.id" class="ml-2 flex">

                        <gray-button type="button" @click="openModal(entitie.contact_id)" >
                            Address {{index++}}
                        </gray-button>
                    </div>
                </div>
            </div>
                <div class="p-2">
                    <div class="flex justify-between">
                        <button @click="destroy"  class="md:inline-flex justify-center py-1 px-4 text-md font-medium rounded-md text-red-800 hover:bg-red-50  ">
                         Delete
                        </button>
                        <jet-button type="submit"  tabindex="-1">
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
                <div class="inline-block align-bottom  rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                    <form class="w-full bg-white max-w-xl max-w-7xl" @submit.prevent="addressupdate">

                       <div class="p-2"   >  <!-- md:flex xl:flex lg:flex v-for="(getadds ,index) in getadd" :key="getadds.id" :class="index % 2 === 1"-->
                          <fieldset class="ml-2 p-2 flex-1 border-gray-500" >
                            <legend>Contact Address</legend>
                            <div class=" grid grid-cols-1 md:gap-y-2 gap-x-4 sm:grid-cols-6">

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">
                                    Zip Code
                                    </label>
                                    <div class="">
                                        <input type="number"   v-model="getadd[0].zipcode" name="zipcode" id="zipcode" autocomplete="zipcode" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" required/>
                                        <!-- <div v-if="forms.errors.zipcode" class="text-red-500 text-xs">{{ forms.errors.zipcode }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="line_1" class="block text-sm font-medium text-gray-700">
                                        Address Line 1
                                    </label>
                                    <div class="">
                                        <input type="text"   v-model="getadd[0].line_1" name="line_1" id="line_1" autocomplete="line_1" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.line_1" class="text-red-500 text-xs">{{ forms.errors.line_1 }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="line_2" class="block text-sm font-medium text-gray-700">
                                    Address Line 2
                                    </label>
                                    <div class="">
                                        <input type="text"   v-model="getadd[0].line_2" name="line_2" id="line_2" autocomplete="line_2" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.line_2" class="text-red-500 text-xs">{{ forms.errors.line_2 }}</div> -->
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
                                        <!-- <div v-if="forms.errors.landmark" class="text-red-500 text-xs">{{ forms.errors.landmark }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">
                                    City
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="getadd[0].city" name="city" id="city" autocomplete="city" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.city" class="text-red-500 text-xs">{{ forms.errors.city }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="state_name" class="block text-sm font-medium text-gray-700">
                                    State
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="getadd[0].state_name" name="state_name" id="state_name" autocomplete="state_name" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.state_name" class="text-red-500 text-xs">{{ forms.errors.state_name }}</div> -->
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
                                        <!-- <div v-if="forms.errors.tag" class="text-red-500 text-xs">{{ forms.errors.tag }}</div> -->
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
                                        <select id="contact_type" required v-model="getadd[0].contact_type" name="contact_type" autocomplete="contact_type" class="shadow-sm focus:ring-indigo-500 md:h-select focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md">
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
                                        <!-- <div v-if="forms.errors.email" class="text-red-500 text-xs">{{ forms.errors.email }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="mobile" class="block text-sm font-medium text-gray-700">
                                    Mobile
                                    </label>
                                    <div class="">
                                        <input type="number"  v-model="getadd[0].mobile" name="mobile" id="mobile" autocomplete="mobile" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.mobile" class="text-red-500 text-xs">{{ forms.errors.mobile }}</div> -->
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
                                        <!-- <div v-if="forms.errors.land_line" class="text-red-500 text-xs">{{ forms.errors.land_line }}</div> -->
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="alt_mobile" class="block text-sm font-medium text-gray-700">
                                    Alt Mobile
                                    </label>
                                    <div class="">
                                        <input type="number"  v-model="getadd[0].alt_mobile" name="alt_mobile" id="alt_mobile" autocomplete="alt_mobile" class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <!-- <div v-if="forms.errors.alt_mobile" class="text-red-500 text-xs">{{ forms.errors.alt_mobile }}</div> -->
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <jet-button  type="submit" >
                                Save
                            </jet-button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <gray-button @click="closeModal()" >
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
                <div class="inline-block align-bottom  rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form class="w-full bg-white max-w-xl max-w-7xl" @submit.prevent="address">
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
                              <jet-button  type="submit"  >
                                Save
                              </jet-button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                              <gray-button @click="closeModal()" type="button" class="">
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
     //import { ref } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Pagination from '@/Jetstream/Pagination'
    import { useForm } from "@inertiajs/inertia-vue3";
    import TrashedMessage from '../TrashedMessage'
    import Multiselect from '@suadelabs/vue3-multiselect'
    import { HomeIcon } from '@heroicons/vue/solid'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import RedButton from '@/Jetstream/RedButton.vue'
    import JetButton from '@/Jetstream/Button.vue'
import Swal from 'sweetalert2'
     export default ({
         components: {
             AppLayout,
             AppMenu,
             Welcome,
             Pagination,
             TrashedMessage,
             Multiselect,
             HomeIcon,
             GrayButton,
             RedButton,
             JetButton
         },
        setup(props) {
        const form = useForm({
            id: props.entities[0].id,
            entity_id: props.entities[0].entity_id,
            legal_name: props.entities[0].legal_name,
            alias: props.entities[0].alias,
            url: props.entities[0].url,
            logo_file: props.entities[0].logo_file,
            api_key: props.entities[0].api_key,
            status: props.entities[0].status,
            entity_type: props.entities[0].entity_type,
            parent_id:props.entities[0].parent_id,
            description: props.entities[0].description,
            line_1:props.entities[0].line_1,
            line_2: props.entities[0].line_2,
            city: props.entities[0].city,
            state_name:props.entities[0].state_name,
            zipcode: props.entities[0].zipcode,
            landmark:props.entities[0].landmark,
            contact_type: props.entities[0].contact_type,
            tag:props.entities[0].tag,
            email: props.entities[0].email,
            mobile: props.entities[0].mobile,
            alt_mobile:props.entities[0].alt_mobile,
            land_line: props.entities[0].land_line,
            patron_type:props.entities[0].patron_type,
            gstin:props.entities[0].gstin,
        });

        return { form };
    },
    props: {
        entities: Object,
        entityorg: Object,
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
        }),
        images: this.$inertia.form({
            logo_file: null,
        }),
        Company:'Organization',
        isOpen: false,
        isCreate: false,
        getadd:[],
        options: ['Customer','Vendor','Contractor','Consultant','Service Provider','Supplier','Transport','Maistry','Party','Others'],
        url:null,
        }
    },
    methods: {
        store() {
            if (confirm('Are you sure you want to update this Entity ..?')) {
                    this.form.put(this.route('entities.update',this.entities[0]['id']))
                }
            },
         image() {
            if (this.$refs.photo) {
                this.images.logo_file = this.$refs.photo.files[0];
                }
                // console.log(this.entities[0]['id']);
             // console.log(this.images.logo_file,this.form.entity_id);
                this.images.post(this.route('entities.updateimage',this.entities[0]['id']))
            },

        destroy() {
            if (confirm('Are you sure you want to delete this Entity?')) {
                this.form.get(this.route('entities.destroy',this.entities[0]['id']))
            }
        },

        restore() {
            if (confirm('Are you sure you want to restore this Entity?')) {
                this.$inertia.put(this.route('entities.restore',this.entities[0]['id']))
            }
        },
        address() {
            this.forms.post(this.route('entities.addresscreate', this.form.entity_id))
        },
        addressupdate(){
            this.getadd[0]._method = 'PUT';
            this.$inertia.put('../../entiteaddress/' + this.getadd[0].id, this.getadd[0])
        },
        openCreate:function(){
            this.isCreate = true;
        },
        openModal:function(id){
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

        closeModal: function () {
                this.isOpen = false;
                this.isCreate = false;
        },
        patron(e){
            if(e=='Company'){
            this.Company='Company';
            }else{
                this.Company='Organization';
                }
                },
            showImage() {
            this.img='/portal.agro.com/storage/public/';
            // this.img='../../../storage/public/';
            //console.log('',this.img,this.legal_name);
            return this.img;
        },
    }
})
 </script>
