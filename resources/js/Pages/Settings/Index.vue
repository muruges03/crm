<template>
 <app-menu />
<div class="lg:pl-64 flex flex-col bg-white  ">
<div class="grid md:grid-cols-2 sm:grid-cols-1 p-5">
  <div>
      <div class=" border-r justify-between flex px-4 py-2"  >
        <h2 class="md:text-lg sm:text-sm font-semibold flex py-2">
              <img src="/assets/lead.png" class="h-6 w-6 mr-3">LEAD TYPE
        </h2>
        <div class=" sm:mt-0 sm:ml-4">
            <jet-button type="button"  class="" >
                <a  @click="openLeadType()" >CREATE NEW</a> <!--:href="route('settings.create')"-->
            </jet-button>
        </div>
    </div>
    <div class=" overflow-x-auto ">
        <div class="p-2 align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="">
                        <tr>
                            <th class="px-3 py-3 text-md text-center" >#</th>
                            <th scope="col" class="px-3 py-3 text-md text-center">
                                <inertia-link v-bind:href="this.route('settings', {sort: 'lead_name',order:'desc'})">Lead Type </inertia-link>
                            </th>
                            <th class="px-3 py-3 text-md text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(leadtypes, index) in leadtype" :key="leadtypes.id" v-bind:class="index % 2 === 0 ? 'bg-white-100 hover:bg-blue-100' : 'tr-bg-color hover:bg-blue-100'">
                            <td  class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-900">
                                <a @click="openEditLeadType(leadtypes)">{{++index}}</a>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><a  @click="openEditLeadType(leadtypes)">{{leadtypes.lead_type }}</a></td>

                        <td class="px-3 py-3 flex text-sm justify-center text-gray-500">
                                <a class="btn btn-danger btn-sm" @click="leadtypedestroy(leadtypes.id)" >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                                <a class=""  @click="openEditLeadType(leadtypes)">
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:29px;">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
    <div class="px-2 py-2">
        <div class=" border-r justify-between flex"  >
            <h2 class="md:text-lg sm:text-sm font-semibold  flex py-2">
                  <img src="/assets/leadtype.png" class="h-6 w-6 mr-3">LEAD PIPELINE STAGE
            </h2>
            <div class=" sm:mt-0 sm:ml-4 ">
                <jet-button type="button" class="m-2">
                    <a   @click="openLeadPipeline()">CREATE NEW</a>
                </jet-button>
            </div>
        </div>
        <div class=" overflow-x-auto ">
            <div class="p-2 align-middle inline-block min-w-full ">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="">
                            <tr>
                                <th class="px-3 py-3 text-md text-center" >#</th>
                                <th scope="col" class="px-3 py-3 text-md text-center">
                                    <inertia-link v-bind:href="this.route('settings', {sort: 'lead_name',order:'desc'})">Lead Stage</inertia-link>
                                </th>
                                <th scope="col" class="px-3 py-3 text-md text-center">
                                    <inertia-link v-bind:href="this.route('settings', {sort: 'lead_name',order:'desc'})">Code</inertia-link>
                                </th>
                                <th class="px-3 py-3 text-md text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(leadstages, index) in leadstage" :key="leadstages.id"  v-bind:class="index % 2 === 0 ? 'bg-white-100 hover:bg-blue-100' : 'tr-bg-color hover:bg-blue-100'">
                                <td  class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-900">
                                    <a  @click="openEditLeadPipeline(leadstages)">{{++index}}</a>
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><a  @click="openEditLeadPipeline(leadstages)">{{leadstages.lead_stage}}</a></td>
                                <td class="px-3 py-3 whitespace-nowrap text-sm text-center text-gray-500"><a  @click="openEditLeadPipeline(leadstages)">{{leadstages.code}}</a></td>
                                <td class="px-3 py-3 flex text-sm justify-center text-gray-500">
                                    <a class="btn btn-danger btn-sm" @click="leadstagedestroy(leadstages.id)" >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" style="color:red; opacity:0.6;" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                    <a class=""   @click="openEditLeadPipeline(leadstages)" >
                                        <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:29px;">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
  </div>
</div>
    </div>
     <!-- new lead Type -->
            <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" v-if="addLeadType" >
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div>
                                <form class="bg-white"  @submit.prevent="leadTypeStore">
                                    <h3 class="text-xl text-gray-700 flex">  <img src="/assets/lead.png" class="h-6 w-6 mr-3">ADD LEAD TYPE</h3>
                                    <div class="grid grid-cols-6 gap-2 md:gap-6">
                                        <div class="col-span-6 sm:col-span-6">
                                            <label for="lead_type" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Lead Type</label>
                                                <input type="text"  v-model="leadForm.lead_type" name="lead_type" id="lead_type" autocomplete="off"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                <div v-if="leadForm.errors.lead_type" class="text-red-500 text-xs">{{ leadForm.errors.lead_type }}</div>
                                        </div>
                                    </div>
                                    <div class="p-2 ">
                                        <div class="flex justify-center ">
                                            <jet-button type="submit" class="mr-2">
                                                Create
                                            </jet-button>
                                            <gray-button @click="addLeadType=false"  type="button" >
                                                Cancel
                                            </gray-button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- edit lead Type -->
            <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" v-if="editLeadType" >
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div>
                                <form class="bg-white">
                                    <h3 class="text-xl text-gray-700 flex">  <img src="/assets/lead.png" class="h-6 w-6 mr-3">UPDATE LEAD TYPE</h3>
                                    <div class="grid grid-cols-6 gap-2 md:gap-6">
                                        <div class="col-span-6 sm:col-span-6">
                                            <label for="lead_type" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Lead Type</label>
                                                <input type="hidden"  v-model="leadForm.id" name="id" id="id" autocomplete="off"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                <div v-if="leadForm.errors.id" class="text-red-500 text-xs">{{ leadForm.errors.id }}</div>
                                                <input type="text"  v-model="leadForm.lead_type" name="lead_type" id="lead_type" autocomplete="off"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md " />
                                                <div v-if="leadForm.errors.lead_type" class="text-red-500 text-xs">{{ leadForm.errors.lead_type }}</div>
                                            </div>
                                    </div>
                                    <div class="p-2 ">
                                        <div class="flex justify-center ">
                                            <jet-button type="button"  @click="leadEditTypeupdate(leadForm)" class="mr-2">
                                                Update
                                            </jet-button>
                                            <gray-button @click="editLeadType=false"  type="button" >
                                                Cancel
                                            </gray-button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" v-if="addLeadPipeline" >
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div>
                            <form class="bg-white"  @submit.prevent="leadStageStore">
                                <h3 class="text-xl text-gray-700 flex">  <img src="/assets/leadtype.png" class="h-6 w-6 mr-3">ADD PIPELINE STAGE</h3>
                                <div class="grid grid-cols-6 gap-2 md:gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="lead_stage" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Lead Stage</label>
                                        <input type="text"  v-model="leadStageForm.lead_stage" name="lead_stage" id="lead_stage" autocomplete="off"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  " />
                                        <div v-if="leadStageForm.errors.lead_stage" class="text-red-500 text-xs">{{ leadStageForm.errors.lead_stage }}</div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="code" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Lead Code</label>
                                        <input type="text"  v-model="leadStageForm.code" name="code" id="code" autocomplete="off"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  " />
                                        <div v-if="leadStageForm.errors.code" class="text-red-500 text-xs">{{ leadStageForm.errors.code }}</div>
                                    </div>
                                </div>

                                <!-- <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"> -->
                                <div class="p-2 ">
                                    <div class="flex justify-center ">
                                        <jet-button type="submit" class="mr-2">
                                            Create
                                        </jet-button>
                                        <gray-button @click="addLeadPipeline=false"  type="button" >
                                            Cancel
                                        </gray-button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<!-- Edit lead stage -->
            <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" v-if="editLeadPipeline" >
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div>
                            <form class="bg-white">
                                <h3 class="text-xl text-gray-700 flex">
                                    <img src="/assets/leadtype.png" class="h-6 w-6 mr-3">
                                    UPDATE PIPELINE STAGE
                                </h3>
                                <div class="grid grid-cols-6 gap-2 md:gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="lead_stage" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Lead Stage</label>
                                        <div class="">
                                                <input type="hidden"  v-model="leadStageForm.id" name="id" id="id" autocomplete="off"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                <div v-if="leadStageForm.errors.id" class="text-red-500 text-xs">{{ leadStageForm.errors.id }}</div>
                                            </div>
                                        <div class="">
                                            <input type="text"  v-model="leadStageForm.lead_stage" name="lead_stage" id="lead_stage" autocomplete="off"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            <div v-if="leadStageForm.errors.lead_stage" class="text-red-500 text-xs">{{ leadStageForm.errors.lead_stage }}</div>
                                        </div>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="code" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Lead Stage</label>
                                            <div class="">
                                                <input type="text"  v-model="leadStageForm.code" name="code" id="code" autocomplete="off"  class=" md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                                <div v-if="leadStageForm.errors.code" class="text-red-500 text-xs">{{ leadStageForm.errors.code }}</div>
                                            </div>
                                        </div>
                                </div>
                                <div class="p-2 ">
                                    <div class="flex justify-center ">
                                        <jet-button type="button"  @click="leadEditStageupdate(leadStageForm)" class="mr-2">
                                            Update
                                        </jet-button>
                                        <gray-button @click="editLeadPipeline=false"  type="button" >
                                            Cancel
                                        </gray-button>
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
    import {TrashIcon} from '@heroicons/vue/outline'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import JetButton from '@/Jetstream/Button.vue'
     import Swal from 'sweetalert2'
    export default ({
        components: {
            AppLayout,
            AppMenu,
            Welcome,
            Pagination,
            TrashIcon,
            GrayButton,
            JetButton
        },
        remember: 'form',
        props: [
            "leadtype",
            "leadstage",
            "leadedittype"
            // "filters",
            // "firstItem",
            // "lastItem",
            // "total",
        ],
        data() {
        return {
            leadForm: this.$inertia.form({
                lead_type: null,
                status:1,
             }),
             leadStageForm: this.$inertia.form({
                lead_stage: null,
                code: null,
                status:1,

             }),
            addLeadType:false,
            editLeadType:false,
            addLeadPipeline:false,
            editLeadPipeline:false,
        }
    },
    methods: {
        openLeadType:function(){
                this.addLeadType = true;
                this.leadForm.lead_type=''
            },
        openEditLeadType: function (data) {
                this.leadForm.lead_type=data.lead_type
                this.leadForm.id=data.id
                this.editLeadType=true;
            },
        openLeadPipeline:function(){
                this.addLeadPipeline = true;
                this.leadStageForm.lead_stage=''
                this.leadStageForm.code=''
            },
        openEditLeadPipeline: function (data) {
                this.leadStageForm.lead_stage=data.lead_stage
                this.leadStageForm.id=data.id
                this.leadStageForm.code=data.code
                this.editLeadPipeline=true;
            },
            leadstagedestroy(id) {
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
                    this.$inertia.get(this.route('leadstage.destroy', id))
                }
            })
        },
        leadtypedestroy(id) {
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
                this.$inertia.get(this.route('leadtype.destroy', id))
            }
            })
        },

          leadTypeStore() {
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
                }).then((result) => {
                if (result.isConfirmed) {
                    this.leadForm.post(this.route('settings.leadtypestore'), {
                        preserveScroll: true,
                        onSuccess: () => {
                              location.reload();
                        },
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
                })
            },

             leadEditTypeupdate(data){
                Swal.fire({
                    title: 'Do you want to update the changes?',
                    showDenyButton: true,
                    confirmButtonText: 'Update',
                    denyButtonText: `Don't Update`,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        data._method = "PUT";
                        this.$inertia.post("settings/leadtypeupdate", data);
                        this.editLeadType = false;
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not updated', '', 'info')
                    }
                    })
                },

             leadStageStore() {
                Swal.fire({
                    title: 'Do you want to a save the changes?',
                    showDenyButton: true,
                    confirmButtonText: 'Save',
                    denyButtonText: `Don't Save`,
                    }).then((result) => {
                    if (result.isConfirmed) {
                    this.leadStageForm.post(this.route('settings.leadstagestore'), {
                            preserveScroll: true,
                            onSuccess: () => {
                                location.reload();
                            },
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not Save', '', 'info')
                    }
                    })
                },

            leadEditStageupdate(data) {
                Swal.fire({
                    title: 'Do you want to Update the changes?',
                    showDenyButton: true,
                    confirmButtonText: 'Update',
                    denyButtonText: `Don't Update`,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        data._method = "PUT";
                        this.$inertia.post("settings/leadstageupdate", data);
                        this.editLeadPipeline=false;
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not updated', '', 'info')
                    }
                    })
                },

    },
 })
</script>
