<template>
    <app-menu />

    <div class="lg:pl-64 flex flex-col  ">
        <div class="p-5">
            <form class="bg-white-300 shadow-lg" @submit.prevent="store">
                <h2 class="text-lg flex font-semibold pb-4">
                    <inertia-link :href="route('patron')" class="flex">
                        <img src="/assets/customer.png" class="h-6 w-6 mr-3 ml-2">
                        ADD NEW CUSTOMER
                    </inertia-link>
                </h2>
                <div class="pt-1">
                    <div class=" lg:flex">
                        <fieldset class="ml-2  flex-1 border-gray-900">
                            <legend class="">Patron Details</legend>
                            <div class="grid grid-cols-12 gap-2">

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="legal_name"
                                        class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                        Legal Name
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="form.legal_name" name="legal_name" id="legal_name"
                                            class="shadow-sm md:h-textbox  block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.legal_name" class="text-red-500 text-xs">{{form.errors.legal_name }}</div>
                                    </div>
                                </div>


                                <div class="col-span-12 sm:col-span-3">
                                    <label for="gstin" class="block text-sm font-medium text-gray-700">
                                        GST IN
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="form.gstin" name="gstin" id="gstin"
                                            class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="form.errors.gstin" class="text-red-500 text-xs">{{ form.errors.gstin }}</div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-3">
                                    <label for="patron_type"
                                        class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                        Patron Type
                                    </label>
                                    <Multiselect style="height: 35px;" class="!block" v-model="form.patron_type" mode="tags"
                                        placeholder="Select One" :options="options" :searchable="true"
                                        id="patron_type" />
                                    <div v-if="form.errors.patron_type" class="text-red-500 text-xs">{{form.errors.patron_type }}</div>
                                </div>
                                <div class="col-span-12 sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                        Owner Name
                                    </label>
                                    <div class="">
                                        <input type="text" v-model="form.name" name="name" id="name"
                                            class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
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
                                    <SelectOptions v-model="form.lead_by" show="first_name"
                                                 placeholder="Select" :options="Customer"
                                                  />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="ml-2 flex-1 border-gray-500">
                            <legend class="">Contact Address</legend>
                            <div class="grid grid-cols-12 gap-2">

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">
                                        Zip Code
                                    </label>
                                    <input type="number" v-model="form.zipcode" name="zipcode" id="zipcode"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.zipcode" class="text-red-500 text-xs">{{ form.errors.zipcode }}</div>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="line_1" class="block text-sm font-medium text-gray-700">
                                        Address Line 1
                                    </label>
                                    <input type="text" v-model="form.line_1" name="line_1" id="line_1"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.line_1" class="text-red-500 text-xs">{{ form.errors.line_1 }}
                                    </div>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="line_2" class="block text-sm font-medium text-gray-700">
                                        Address Line 2
                                    </label>
                                    <input type="text" v-model="form.line_2" name="line_2" id="line_2"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.line_2" class="text-red-500 text-xs">{{ form.errors.line_2 }}
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-3">
                                    <label for="landmark" class="block text-sm font-medium text-gray-700">
                                        Landmark
                                    </label>
                                    <input type="text" v-model="form.landmark" name="landmark" id="landmark"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.landmark" class="text-red-500 text-xs">{{form.errors.landmark }}</div>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="city" class="block text-sm font-medium text-gray-700">
                                        City
                                    </label>
                                    <input type="text" v-model="form.city" name="city" id="city"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.city" class="text-red-500 text-xs">{{ form.errors.city }}
                                    </div>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="state_name" class="block text-sm font-medium text-gray-700">
                                        State
                                    </label>
                                    <input type="text" v-model="form.state_name" name="state_name" id="state_name"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.state_name" class="text-red-500 text-xs">{{form.errors.state_name }}</div>
                                </div>
                                <div class="col-span-12 sm:col-span-3">
                                    <label for="tag" class="block text-sm font-medium text-gray-700">
                                        Tag
                                    </label>
                                    <input type="text" v-model="form.tag" name="tag" id="tag"
                                        class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.tag" class="text-red-500 text-xs">{{ form.errors.tag }}</div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="lg:flex">
                        <fieldset class="ml-2 p-1 flex-1 border-gray-500">
                            <legend class="">Contact Details</legend>
                            <div class="grid grid-cols-12 gap-2">

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="contact_type" class="block text-sm font-medium text-gray-700">
                                        Contact Type
                                    </label>
                                    <select id="contact_type" v-model="form.contact_type" name="contact_type"
                                        class="shadow-sm focus:ring-indigo-500 md:h-select focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="Default">Default</option>
                                        <option value="Office">Office</option>
                                        <option value="Billing">Billing</option>
                                        <option value="Shipping">Shipping</option>
                                    </select>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="email" class="block text-sm font-medium text-gray-700">
                                        Email
                                    </label>
                                    <input type="email" v-model="form.email" name="email" id="email"
                                        class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.email" class="text-red-500 text-xs">{{ form.errors.email }}
                                    </div>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="mobile" class="block text-sm font-medium text-gray-700">
                                        Mobile
                                    </label>
                                    <input type="number" v-model="form.mobile" name="mobile" id="mobile"
                                        class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.mobile" class="text-red-500 text-xs">{{ form.errors.mobile }}
                                    </div>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="land_line" class="block text-sm font-medium text-gray-700">
                                        Land Line
                                    </label>
                                    <input type="number" v-model="form.land_line" name="land_line" id="land_line"
                                        class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.land_line" class="text-red-500 text-xs">{{ form.errors.land_line }}</div>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="alt_mobile" class="block text-sm font-medium text-gray-700">
                                        Alt Mobile
                                    </label>
                                    <input type="number" v-model="form.alt_mobile" name="alt_mobile" id="alt_mobile"
                                        class="shadow-sm focus:ring-indigo-500 md:h-textbox focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.alt_mobile" class="text-red-500 text-xs">{{ form.errors.alt_mobile }}</div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="ml-2 p-1 flex-1 border-gray-500">
                            <legend class="">Emergency Details</legend>
                            <div class="grid grid-cols-12 gap-2">
                                <div class="col-span-12 sm:col-span-3">
                                    <label for="secondary_address" class="block text-sm font-medium text-gray-700">
                                        Address
                                    </label>
                                    <input type="text" v-model="form.secondary_address" name="secondary_address"
                                        id="secondary_address"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.secondary_address" class="text-red-500 text-xs">{{ form.errors.secondary_address }}</div>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="secondary_contact_name" class="block text-sm font-medium text-gray-700">
                                        Contact Name
                                    </label>
                                    <input type="text" v-model="form.secondary_contact_name"
                                        name="secondary_contact_name" id="secondary_contact_name"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-300 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.secondary_contact_name" class="text-red-500 text-xs">{{ form.errors.secondary_contact_name }}</div>
                                </div>

                                <div class="col-span-12 sm:col-span-3">
                                    <label for="secondary_email" class="block text-sm font-medium text-gray-700">
                                        Email
                                    </label>
                                    <input type="email" v-model="form.secondary_email" name="secondary_email"
                                        id="secondary_email"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.secondary_email" class="text-red-500 text-xs">{{ form.errors.secondary_email }}</div>
                                </div>
                                <div class="col-span-12 sm:col-span-3">
                                    <label for="secondary_phone" class="block text-sm font-medium text-gray-700">
                                        Phone
                                    </label>
                                    <input type="number" v-model="form.secondary_phone" name="secondary_phone"
                                        id="secondary_phone"
                                        class="shadow-sm md:h-textbox focus:ring-indigo-300 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.secondary_phone" class="text-red-500 text-xs">{{ form.errors.secondary_phone }}</div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>
                <div class="p-2" v-if="$page.props.auth.user.can['create_patroncontact'] == true">
                    <div class="flex justify-end">

                        <jet-button type="submit">
                            CREATE
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
import Multiselect from '@vueform/multiselect'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import { ExclamationCircleIcon } from '@heroicons/vue/solid'
import SelectOptions from '@/components/SelectOptions.vue'
export default {
    metaInfo: { title: 'Patron' },
    remember: 'form',
    components: {
        AppLayout,
        AppMenu,
        Welcome,
        SelectOptions,
        Pagination,
        Multiselect,
        JetButton, JetInput,
        ExclamationCircleIcon
    },
    props: {
        Customer:Array,
    },
    data() {
        return {
            form: this.$inertia.form({
                line_1: null,
                line_2: null,
                city: null,
                state_name: null,
                zipcode: null,
                landmark: null,
                payment_mode : null,
                contact_type: 'Default',
                tag: null,
                name: null,
                email: null,
                mobile: null,
                alt_mobile: null,
                land_line: null,
                secondary_address: null,
                secondary_contact_name: null,
                secondary_email: null,
                secondary_phone: null,
                patron_type: null,
                legal_name: null,
                gstin: null,
                poc_name: null,
                poc_mobile: null,
                poc_alt_mobile: null,
                poc_landline: null,
                poc_email: null,
                lead_by:null
            }),
            value: null,
            paymentMode : ["Monthly","Yearly"],
            options: ['Customer', 'Vendor', 'Contractor', 'Consultant', 'Service Provider', 'Supplier', 'Transport', 'Maistry', 'Party', 'Others']
        }
    },
    methods: {
        store() {
            // alert();
            this.form.post(this.route('patron.store'))
        },
    },
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
