<template>
  <app-menu />
  <h2 class="text-2xl lg:pl-64 font-bold ml-8 md:pt-6">
        Entity Form
    </h2>
    <div class="lg:pl-64 flex flex-col bg-white divide-x divide-gray-100 border-1 shadow-md">
     <div class=" md:col-span-2 p-5">
        <form class=" border-2" @submit.prevent="store">
            <div class="space-y-1 divide-y divide-gray-200">
                <div class="pt-1">
                    <div class="lg:flex p-2">
                        <fieldset class="ml-2 p-1 flex-1 border-gray-900" >
                            <legend class="p-2">Entity Details</legend>
                                <div class="grid grid-cols-6 gap-4">
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="last_name" class="block text-sm font-medium text-gray-700">Legal Name</label>
                                        <div class="">
                                            <input type="text"  v-model="form.legal_name" name="legal_name" id="legal_name" autocomplete="family-name"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
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
                                        <input id="api_key" type="text" class=" focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" name="api_Key" v-model="form.api_key" />
                                        <div v-if="form.errors.api_key" class="text-red-500 text-xs">{{ form.errors.api_key }}</div>
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="">
                                        <select id="status" v-model="form.status" name="Status" autocomplete="Inactive" class=" block w-full md:h-select py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-300 sm:text-sm">
                                           <option value="null" disabled selected hidden>Choose.</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        <div v-if="form.errors.status" class="text-red-500 text-xs">{{ form.errors.status }}</div>
                                    </div>
                                </div>
                                <div class=" col-span-6 sm:col-span-2">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Entity Type</label>
                                    <select id="entity_type" @change="patron(form.entity_type)"  v-model="form.entity_type" name="entity_type" class=" block w-full py-2 px-3 md:h-select border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-300 sm:text-sm">
                                       <option value="null" disabled selected hidden>Choose.</option>
                                        <option value="Organization"> Organization</option>
                                        <option value="Company">Company</option>
                                    </select>
                                            <div v-if="form.errors.entity_type" class="text-red-500 text-xs">{{ form.errors.entity_type }}</div>
                                </div>
                                <div class="col-span-6 sm:col-span-2" v-if="Company=='Company'" >
                                    <label for="contact_type" class="block text-sm font-medium text-gray-700">
                                    Parent Id
                                    </label>
                                    <div class="">
                                        <select class="block answer text-sm appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-2 px-2 pr-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            id="parent_id" :searchable="true" v-model="form.parent_id" >
                                            <option value="null" disabled selected hidden>Select Parent</option>
                                            <option v-for="entityorgs in entityorg" :value="entityorgs.id" :key="entityorgs.id" :data-type="Option" class="text-sm" >
                                            {{ entityorgs.legal_name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                  <div class="col-span-6 sm:col-span-2">
                                    <label for="Companylogo" class="block text-sm font-medium text-gray-700">
                                        Company Logo
                                    </label>
                                    <input type="file" v-on:change="onFileChange" class=" focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" name="logo_file" id="logo_file">
                                    <div v-if="form.errors.logo_file" class="text-red-500 text-xs">{{ form.errors.logo_file }}</div>
                                </div>
                                 <div class="col-span-6 sm:col-span-2">
                                      <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview"/>
                                 </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700">
                                    Description
                                    </label>
                                    <div class="">
                                        <textarea id="description"  v-model="form.description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border border-gray-300 rounded-md" />

                                        <p class="mt-2 text-sm text-gray-500">Write a few sentences about yourself.</p>
                                        <div v-if="form.errors.description" class="text-red-500 text-xs">{{ form.errors.description }}</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="ml-2 p-2 flex-1 border-gray-500" >
                            <legend class="p-2">Contact Address</legend>
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
                            <legend class="p-2">Contact Details</legend>
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
            <div class="p-2">
                <div class="flex justify-center ">
                    <jet-button type="submit" class="">
                        Create
                    </jet-button>
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
     import Pagination from '@/Jetstream/Pagination'
     import JetLabel from '@/Jetstream/Label.vue'
     import Multiselect from '@suadelabs/vue3-multiselect'
     import GrayButton from '@/Jetstream/GrayButton.vue'
     import JetButton from '@/Jetstream/Button.vue'
     import Swal from 'sweetalert2'
     export default ({
         components: {
             AppLayout,
             AppMenu,
             Welcome,
             Pagination,
             JetLabel,
             Multiselect,
             GrayButton,
             JetButton,

         },
         remember: 'form',
         props: {
             entityorg: Object,
         },
         data() {
             return {
             form: this.$inertia.form({
                legal_name: null,
                alias: null,
                url: null,
                logo_file: null,
                api_key: null,
                status: null,
                entity_type: null,
                parent_id: null,
                file: '',
                success: '',
                gstin:null,
                description: null,
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
                emergency_address: null,
                emergency_contact_name: null,
                emergency_email: null,
                emergency_phone: null,
                patron_type: null,
             }),
                imagePreview: null,
                showPreview: false,
                Company:'Organization',
             }
         },
        methods: {
            onFileChange(event){
                this.form.logo_file = event.target.files[0];
                let reader  = new FileReader();
                reader.addEventListener("load", function () {
                this.showPreview = true;
                this.imagePreview = reader.result;
                        }.bind(this), false);
                    if( this.form.logo_file ){
                        if ( /\.(jpe?g|png|gif)$/i.test( this.form.logo_file.name ) ) {
                            //console.log("here");
                            reader.readAsDataURL( this.form.logo_file );
                        }
                    }
            },
            store() {
                this.form.post(this.route('entities.store'))
            },
            patron(e){
                if(e=='Company'){
                    this.Company='Company';
                }else{
                    this.Company='Organization';
                }
            },
         },
     })
 </script>

