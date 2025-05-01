<template>
    <app-menu />
    <h2 class="text-2xl font-bold lg:pl-64 ml-8 sm:pt-6">
        Lead Update
    </h2>
     <div class="lg:pl-64 flex flex-col">
    <div class=" md:col-span-6 p-5">
        <div class="flex overflow-auto-x">
            <ul class="flex ">
                 <li class="-mb-px mr-1">
                    <a  class="bg-white inline-block py-2  rounded-t px-4 text-blue-500  font-semibold" v-on:click="currentTab(1)" v-bind:class="{'': openTab !== 1, 'border-t border-l border-r rounded-t sm:px-20 scale-100 shadow-lg text-black': openTab === 1}" >Details</a>
                </li>
                <li class="mr-1">
                    <a class="bg-white inline-block py-2 px-4 text-blue-500  font-semibold" v-on:click="currentTab(2)" v-bind:class="{'': openTab !== 2, 'border-t border-l border-r rounded-t sm:px-20 scale-100 shadow-lg text-black': openTab === 2}" >Contact Person</a>
                </li>
            </ul>
        </div>
        <div>
            <form class="shadow-md md:p-4" @submit.prevent="update" >
                <div class=""  v-if="openTab===1">
                    <div class="  p-2">
                        <div class="grid grid-cols-6 gap-4">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="lead_name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Title</label>
                                <jet-input type="text" v-model="form.lead_name"  id="lead_name" name="lead_name"  />
                                <div v-if="form.errors.lead_name" class="text-red-500 text-xs">{{ form.errors.lead_name }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="lead_type" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500"> Lead Type</label>
                                <Multiselect :value="this.leadtype.id" :multiple="false" v-model="form.lead_type_id" deselect-label="Can't remove this value" track-by="id" label="lead_type" class="!block"
                                placeholder="Select one" :options="this.leadtype" :searchable="true" :allow-empty="true">
                                <template ><strong> {{ this.leadtype.lead_type }}</strong></template>
                                </Multiselect>
                                    <div v-if="form.errors.lead_type_id" class="text-red-500 text-xs">{{ form.errors.lead_type_id }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="lead_value" class="block text-sm font-medium text-gray-700 ">Lead Value</label>
                                <jet-input id="lead_value" type="number"  v-model="form.lead_value"/>
                                <div v-if="form.errors.lead_value" class="text-red-500 text-xs">{{ form.errors.lead_value }}</div>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="source" class="block text-sm font-medium text-gray-700">Refered By</label>
                                <jet-input type="text" v-model="form.source"  id="source"   />
                                <div v-if="form.errors.source" class="text-red-500 text-xs">{{ form.errors.source }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="lead_email" class="block text-sm font-medium text-gray-700">Email</label>
                                <jet-input type="text" v-model="form.lead_email"  id="lead_email" autocomplete="lead_email"  />
                                <div v-if="form.errors.lead_email" class="text-red-500 text-xs">{{ form.errors.lead_email }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Assign To</label>
                                <Multiselect :value="this.userlead.id" :multiple="false" v-model="form.assigned_to" deselect-label="Can't remove this value" track-by="id" label="first_name" class="!block"
                                    placeholder="Select one" :options="this.userlead" :searchable="true" :allow-empty="true">
                                    <template ><strong> {{ this.userlead.first_name }}</strong></template>
                                </Multiselect>
                                <div v-if="form.errors.assigned_to" class="text-red-500 text-xs">{{ form.errors.assigned_to }}</div>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="closed_at" class="block text-sm font-medium text-gray-700">Close At</label>
                                 <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                    ref="closed_at" name="closed_at" v-model="form.closed_at" autoApply :enableTimePicker="false"
                                    id="closed_at"  autocomplete="closed_at" placeholder="Close date" />
                                <div v-if="form.errors.closed_at" class="text-red-500 text-xs">{{ form.errors.closed_at }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="expected_close_date" class="block text-sm font-medium text-gray-700 ">Expected Close Date</label>
                                  <Datepicker class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
                                    ref="expected_close_date" name="expected_close_date" v-model="form.expected_close_date" autoApply :enableTimePicker="false"
                                    id="expected_close_date"  autocomplete="expected_close_date" placeholder="Expect Close date" />
                                <div v-if="form.errors.expected_close_date" class="text-red-500 text-xs">{{ form.errors.expected_close_date }}</div>
                            </div>
                             <div class="col-span-6 sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Description</label>
                                <textarea id="description" type="text" class="border-gray-300  w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"  v-model="form.description"  autocomplete="" />
                                <div v-if="form.errors.description" class="text-red-500 text-xs">{{ form.errors.description }}</div>
                            </div>
                            </div>
                        </div>
                        <div class="flex justify-center p-2 ">
                            <jet-button v-on:click="currentTab(2)">
                                CONTINUE
                            </jet-button>
                        </div>
                    </div>
                <div class=""   v-if="openTab===2">
                    <div class="  p-2">
                        <div class="grid grid-cols-6 gap-4">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="person_name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Name</label>
                                <jet-input type="text" v-model="form.person_name"  id="person_name" name="person_name"  />
                                <div v-if="form.errors.person_name" class="text-red-500 text-xs">{{ form.errors.person_name }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="mobile" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Contact Number</label>
                                <jet-input type="number" v-model="form.mobile"  id="mobile"  name="mobile"  />
                                <div v-if="form.errors.mobile" class="text-red-500 text-xs">{{ form.errors.mobile }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <jet-input type="text" v-model="form.email"  id="email" autocomplete="email"  />
                                <div v-if="form.errors.email" class="text-red-500 text-xs">{{ form.errors.email }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="line_1" class="block text-sm font-medium text-gray-700">
                                    Address Line 1
                                </label>
                                    <jet-input type="text"  v-model="form.line_1" name="line_1" id="line_1" />
                                    <div v-if="form.errors.line_1" class="text-red-500 text-xs">{{ form.errors.line_1 }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="landmark" class="block text-sm font-medium text-gray-700">
                                Landmark
                                </label>
                                    <jet-input type="text" v-model="form.landmark" name="landmark" id="landmark"  />
                                    <div v-if="form.errors.landmark" class="text-red-500 text-xs">{{ form.errors.landmark }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="city" class="block text-sm font-medium text-gray-700">
                                City
                                </label>
                                    <jet-input type="text" v-model="form.city" name="city" id="city"  />
                                    <div v-if="form.errors.city" class="text-red-500 text-xs">{{ form.errors.city }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="state_name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                State
                                </label>
                                <jet-input type="text" v-model="form.state_name" name="state_name" id="state_name"  />
                                <div v-if="form.errors.state_name" class="text-red-500 text-xs">{{ form.errors.state_name }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <jet-label for="zip_code" value="Zipcode" />
                                <jet-input type="number"  v-model="form.zipcode" name="zipcode" id="zipcode" />
                                <div v-if="form.errors.zipcode" class="text-red-500 text-xs">{{ form.errors.zipcode }}</div>
                            </div>
                        </div>
                    </div>
                    <div  class="flex justify-between p-2">
                        <button type="button"  @click="destroy()" v-if="$page.props.auth.user.can['delete_leads']==true" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete
                        </button>
                        <jet-button type="submit"  >
                            Update
                        </jet-button>
                    </div>
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
    import JetLabel from '@/Jetstream/Label.vue'
    import { useForm } from "@inertiajs/inertia-vue3";
    import JetInput from '@/Jetstream/Input.vue'
    import Multiselect from '@suadelabs/vue3-multiselect'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import JetButton from '@/Jetstream/Button.vue'
     import moment from "moment";
    import Swal from 'sweetalert2'

    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';
    export default ({
        components: {
            AppLayout,
            AppMenu,
            Welcome,
            Pagination,
            JetLabel,
            Multiselect,
            GrayButton,
            JetInput,
            moment,
            JetButton,
            Datepicker
        },
        remember: 'form',
        data() {
            return {
            form: this.$inertia.form({
                  }),
            openTab: 1,
            }
        },
    setup(props) {
        const form = useForm({
                id:props.lead[0].id,
                lid:props.lead[0].lid,
                cid:props.lead[0].cid,
                lead_name: props.lead[0].lead_name,
                lead_mobile: props.lead[0].lead_mobile,
                lead_email: props.lead[0].lead_email,
                description:props.lead[0].description,
                lead_value: props.lead[0].lead_value,
                lead_type:props.lead[0].lead_type,
                source: props.lead[0].source,
                assigned_to:props.userleadid[0],
                closed_at: props.lead[0].closed_at,
                lead_type_id: props.leadtypeid[0],
                lead_pipeline_stage_id: props.lead[0].lead_pipeline_stage_id,
                expected_close_date:props.lead[0].expected_close_date,

                person_name:props.lead[0].person_name,
                mobile: props.lead[0].mobile,
                email: props.lead[0].email,
                line_1: props.lead[0].line_1,
                zipcode: props.lead[0].zipcode,
                city: props.lead[0].city,
                state_name: props.lead[0].state_name,
                landmark: props.lead[0].landmark,
                mobile: props.lead[0].mobile,
                email: props.lead[0].email,
        });
            return {form};
    },
        props: {
            lead: Object,
            leadtypeid: Object,
            leadtype: Object,
            userlead:Object,
            userleadid:Object,
        },
        methods: {
            destroy() {
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
                        this.$inertia.delete(this.route('lead.destroy', this.form.lid))
                    }
                })
            },
            update() {
                Swal.fire({
                    title: 'Do you want to save the changes?',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    }).then((result) => {
                            this.form.put(this.route('lead.update', this.form.id))

                    })
            },
            currentTab: function (tabNumber) {
                this.openTab = tabNumber;
            },

            openLead:function(){
                this.addLead = true;
                this.isActive=true;
                this.addContact= false;
            },
            openContact:function(){
                this.addContact = true;
                this.isActive=false;
                this.addLead = false;
            },
            date(){
                this.form.closed_at=moment(this.form.closed_at).format('YYYY-MM-DD');
                this.form.expected_close_date=moment(this.form.expected_close_date).format('YYYY-MM-DD');
            },
        },
        mounted:function(){
            this.date();
        },
     })
 </script>
