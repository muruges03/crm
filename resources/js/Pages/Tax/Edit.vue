<template>
    <app-menu />
     <div class="lg:pl-64 flex flex-col bg-white ">
        <div class="p-4 ">
            <div class="py-2 px-4">
                <div class=" sm:mt-0 md:px-4 flex justify-between  ">
                    <h2 class="text-lg font-semibold flex">
                        <img src="/assets/tax.png" class='h-6 w-6 mr-3 mt-1'>
                        <inertia-link :href="route('tax')" class="mt-1">UPDATE TAX</inertia-link>
                        <span class="text-gray-500 font-medium">
                            <svg class="flex-shrink-0 h-9 w-9 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-gray-700 mt-1"> {{ form.tax_name }}</span>
                    </h2>
                </div>
            </div>
                <div class=" md:col-span-2 ">
                    <form @submit.prevent="update" enctype="multipart/form-data" >
                        <div class="px-4 overflow-vidible sm:rounded-md">
                            <div class="px-2 py-3 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-4">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="tax_name" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Tax</label>
                                        <jet-input type="text" name="tax_name" v-model="form.tax_name" id="tax_name" autocomplete="tax-title" class=" "
                                        placeholder="Tax Name"/>
                                        <div v-if="form.errors.tax_name" class="text-red-500 text-xs">{{ form.errors.tax_name }}</div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="title" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Tax Type</label>
                                        <Multiselect  :value="this.taxtype.id" @select=taxTypes($event) :multiple="false" v-model="form.tax_type" select-label="" deselect-label="" class="!block"
                                                    placeholder="Select Tax Type" ref="tax_type" :options="this.taxtype" :searchable="true" :allow-empty="true">
                                        </Multiselect>
                                        <div v-if="form.errors.tax_type" class="text-red-500 text-xs">{{ form.errors.tax_type }}</div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="title" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Parent Tax</label>
                                        <Multiselect  :value="this.parent.id"  :multiple="false" v-model="form.parent_id" select-label="" deselect-label="" track-by="id" class="!block"
                                                @select=taxparent($event)  :custom-label="nameWithLang"  placeholder="Select" ref="parent_id" :options="this.parent" :searchable="true" :allow-empty="true">
                                        </Multiselect>
                                        <div v-if="form.errors.parent_id" class="text-red-500 text-xs">{{ form.errors.parent_id }}</div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="tax_amount" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Tax Amount</label>
                                        <jet-input type="number" step=any name="tax_amount" v-model="form.tax_amount" id="tax_amount" autocomplete="Tax-amount"
                                                        placeholder="Tax Amount(%)"  />
                                        <div v-if="form.errors.tax_amount" class="text-red-500 text-xs">{{ form.errors.tax_amount }}</div>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="tax_group" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Tax Group</label>
                                        <select id="tax_group" name="tax_group"
                                            v-model="form.tax_group"  class="shadow-sm md:h-select focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="null" disabled selected hidden>Choose..</option>
                                            <option value="" class="" disabled>Choose..</option>
                                            <option value="GST" selected>GST</option>
                                            <option value="SGST">SGST</option>
                                            <option value="CGST" >CGST</option>
                                            <option value="IGST" >IGST</option>
                                            <option value="CST">CST</option>
                                            <option value="TCS">TCS</option>
                                            <option value="CESS">CESS</option>
                                        </select>
                                        <div v-if="form.errors.tax_group" class="text-red-500 text-xs">{{ form.errors.tax_group }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end p-2">
                                <jet-button type="submit" >
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
    import {defineComponent, ref} from "vue";
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Pagination from '@/Jetstream/Pagination'
    import {TrashIcon} from '@heroicons/vue/outline'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import Swal from 'sweetalert2'

    import JetInput from '@/Jetstream/Input.vue'
    import axios from 'axios'
    import {
        Listbox,
        ListboxLabel,
        ListboxButton,
        ListboxOptions,
        ListboxOption,
    } from '@headlessui/vue'
    import Multiselect from '@suadelabs/vue3-multiselect'

    export default ({
      components: {
        AppLayout,
        AppMenu,
        Welcome,
        Pagination,
        TrashIcon,
        JetButton,
        GrayButton,
        Multiselect,axios,
        Listbox,
        ListboxLabel,
        ListboxButton,
        ListboxOptions,
        ListboxOption,
        JetInput
      },
      props: [
          'tax'
      ],
    data() {
        return {
            form: this.$inertia.form({
              id          :   this.tax.id,
              parent_id   :   this.tax.parent_id,
              tax_name    :   this.tax.tax_name,
              tax_type    :   this.tax.tax_type,
              tax_amount  :   this.tax.tax_amount,
              tax_group   :   this.tax.tax_group,
            }),
            taxtype : ['Sales','Purchase','Others'],
            parent  : [],
        }
    },
    methods: {
        update() {
            this.form.put(this.route('tax.update',this.tax.id));
        },
        nameWithLang ({ tax_name, tax_amount }) {
            return `${tax_name} ${tax_amount} %`
        },
        taxTypes (option) {
            this.form.tax_type  = option;
            //this.form.parent_id = '';
            axios.get(this.route('taxparent', this.form.tax_type))
                .then(response => {
                    this.parent = response.data;
                    if(this.parent=='')this.form.parent_id = '';
                })
                .catch(error => {
                    console.log(error);
            })
        },
        taxparent(option){
            this.form.parent_id = option.id;
            // console.log('this.form.parent_id',this.form.parent_id);
        },

    },
    mounted() {
        if(this.form.tax_group!='GST')this.taxTypes(this.form.tax_type);
    },
  })
 </script>
