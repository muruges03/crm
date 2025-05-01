<template>
    <app-menu />
    <h2 class="text-2xl font-bold lg:pl-64 ml-8 sm:pt-6">
        Lead Create
    </h2>
    <div class="lg:pl-64 flex flex-col  shadow-md">
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" v-if="addLeadType" >
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div>
                            <div class=" md:col-span-6 p-5">
                                <div class="flex overflow-auto-x">
                                    <ul class="flex ">
                                        <li class="-mb-px mr-1">
                                            <a  class="bg-white inline-block py-2 border-t border-l border-r rounded-t px-4 text-blue-500 hover:text-blue-800 font-semibold"  @click="openLead()">Details</a>
                                        </li>
                                        <li class="mr-1">
                                            <a class="bg-white inline-block py-2 border-t border-l border-r rounded-t px-4 text-blue-500 hover:text-blue-800 font-semibold" @click="openContact()">Contact Person</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="grid grid-cols-3 gap-2 ">
                                    <div class=" bg-blue-200 ml-4">
                                        <h3 class="text-blue-700 text-xl pl-8">Lead Details</h3>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Lead Name </label>
                                            <p class="p-4 text-md">{{form.lead_name}}</p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Lead Type </label>
                                            <p class="p-4 text-md"  v-for="leadtypes in leadtype" :value="leadtypes.id">
                                            {{ leadtypes.lead_type }}</p>
                                        </div>

                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Description </label>
                                            <p class="p-4 text-md">{{form.description}}</p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Lead Value </label>
                                            <p class="p-4 text-md">{{form.lead_value}}</p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Source </label>
                                            <p class="p-4 text-md">{{form.source}}</p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Assigned To </label>
                                            <p class="p-4 text-md">{{form.assigned_to}} Hello world</p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Expected Closed At </label>
                                            <p class="p-4 text-md">{{form.expected_close_date}}</p>
                                        </div>

                                    </div>

                                    <div class=" bg-blue-200 ml-4">
                                        <h3 class="text-blue-700 text-xl pl-8">Contact Details</h3>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Contact Person </label>
                                            <p class="p-4 text-md">{{form.person_name}}</p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Contact Number </label>
                                            <p class="p-4 text-md">{{form.lead_mobile}}</p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4"> Contact Email </label>
                                            <p class="p-4 text-md">{{form.lead_email}}</p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Address </label>
                                            <p class="p-4 text-md">{{form.line_1}} </p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">City </label>
                                            <p class="p-4 text-md">{{form.city}}</p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">State </label>
                                            <p class="p-4 text-md">{{form.state_name}} </p>
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 inline-flex ">
                                            <label for="lead_name" class="block text-md font-medium text-gray-700 p-4">Zipcode </label>
                                            <p class="p-4 text-md">{{form.zipcode}}</p>
                                        </div>
                                    </div>
                                    <div class="fleex-auto">

                                    </div>
                                </div>
                            </div>
                        </div>
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
    import JetLabel from '@/Jetstream/Label.vue'
    import { useForm } from "@inertiajs/inertia-vue3";
    import JetInput from '@/Jetstream/Input.vue'
    import Multiselect from '@suadelabs/vue3-multiselect'
    import GrayButton from '@/Jetstream/GrayButton.vue'
     import moment from "moment";

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
            moment
        },
        remember: 'form',
        data() {
            return {
            form: this.$inertia.form({
                  }),
             addLead:true,
              addContact:false,
              isActive: true,

            }
        },
                 setup(props) {
        const form = useForm({
            id:props.lead[0].id,
                lead_name: props.lead[0].lead_name,
                lead_mobile: props.lead[0].lead_mobile,
                lead_email: props.lead[0].lead_email,
                description:props.lead[0].description,
                lead_value: props.lead[0].lead_value,
                lead_type:props.lead[0].lead_type,
                source: props.lead[0].source,
                assigned_to: props.lead[0].assigned_to,
                closed_at: props.lead[0].closed_at,
                lead_type_id: props.lead[0].lead_type_id,
                lead_pipeline_stage_id: props.lead[0].lead_pipeline_stage_id,
                expected_close_date:props.lead[0].expected_close_date,

                person_name:props.lead[0].person_name,
                line_1: props.lead[0].line_1,
                zipcode: props.lead[0].zipcode,
                city: props.lead[0].city,
                state_name: props.lead[0].state_name,
                landmark: props.lead[0].landmark,

                });
                return {form};
             },

        props: {
            lead: Object,
            leadtype: Object,
        },
        methods: {
             update() {
              if (confirm('Are you sure you want to update this machine? ')) {

                this.form.put(this.route('lead.update', this.form.id))
              }
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
