<template>
  <app-menu />
    <div class="lg:pl-64 flex flex-col">
        <div class="p-5">
            <h2 class="font-semibold flex text-lg px-4 py-2">
                <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('product')"><img src="/assets/add-product.png" class="w-6 h-6 mr-3">UPDATE PRODUCT</inertia-link>
                <span class="text-gray-500 font-medium mt-1">
                    <svg class="flex-shrink-0 h-7 w-7 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                <span class="text-gray-700 mt-1">{{ form.name }}</span>
            </h2>
            <form @submit.prevent="update" >
                <div class="  p-4">
                    <div class="grid grid-cols-6 gap-4">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                Name
                                </label>
                                <div class="">
                                    <jet-input type="text"  v-model="form.name" name="name" id="name" />
                                    <div v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="tax" class="block text-sm font-medium text-gray-700">
                                Tax
                                </label>
                                <div class="">
                                    <select v-model='form.tax_id' class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                                        <option value="null" selected>Choose.</option>
                                        <option v-for='data in tax' :key='data.id' :value='data.id'>{{data.tax_name}} {{ data.tax_amount }}%</option>
                                    </select>
                                </div>
                                    <div v-if="form.errors.uom" class="text-xs text-red-500">{{ form.errors.uom }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="code" class="block text-sm font-medium text-gray-700">
                                Code
                                </label>
                                <div class="">
                                    <jet-input type="number"  v-model="form.code" name="code" id="code" />
                                    <div v-if="form.errors.code" class="text-xs text-red-500">{{ form.errors.code }}</div>
                                </div>
                            </div>
                                <div class="col-span-6 sm:col-span-2">
                                <label for="Description" class="block text-sm font-medium text-gray-700">
                                Description
                                </label>
                                <div class="">
                                    <textarea  v-model="form.description" name="description" id="description"  class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.description" class=" text-xs text-red-500">{{ form.errors.description }}</div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="sale_price" class="block text-sm font-medium text-gray-700">
                                    Sale Price
                                </label>
                                <div class="">
                                    <jet-input type="number" step=any  v-model="form.sale_price" name="sale_price" id="sale_price" />
                                    <div v-if="form.errors.sale_price" class="text-xs text-red-500">{{ form.errors.sale_price }}</div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="purchase_price" class="block text-sm font-medium text-gray-700">
                                Purchase Price
                                </label>
                                <div class="">
                                    <jet-input type="number" step=any  v-model="form.purchase_price" name="purchase_price" id="purchase_price"/>
                                    <div v-if="form.errors.purchase_price" class="text-xs text-red-500">{{ form.errors.purchase_price }}</div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="quantity" class="block text-sm font-medium text-gray-700">
                                    Quantity
                                </label>
                                <div class="">
                                    <jet-input type="number"  step=any v-model="form.quantity" name="quantity" id="quantity"  />
                                    <div v-if="form.errors.quantity" class="text-xs text-red-500">{{ form.errors.quantity }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between ">
                            <button type="button" tabindex="-1" @click="destroy()" v-if="$page.props.auth.user.can['delete_products']==true" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                            </button>
                            <jet-button type="button" @click="update" v-if="$page.props.auth.user.can['edit_products']==true">
                            Update
                            </jet-button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    <!-- </div> -->
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Pagination from '@/Jetstream/Pagination'
    import TrashedMessage from '../TrashedMessage'
    import { useForm } from "@inertiajs/inertia-vue3";
    import JetButton from '@/Jetstream/Button.vue'
        import Swal from 'sweetalert2'

     import JetInput from '@/Jetstream/Input.vue'
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
            JetButton,JetInput
    },
    setup(props) {
        const form = useForm({
            id:props.product[0].id,
            name:props.product[0].name,
            code:props.product[0].code,
            description:props.product[0].description,
            sale_price:props.product[0].sale_price,
            purchase_price:props.product[0].purchase_price,
            quantity:props.product[0].quantity,
            category_id:props.product[0].category_id,
            tax_id:props.product[0].tax_id,
        });
        return { form };
    },
    props: {
        product: Object,
        tax: Object,
    },
    methods: {
        update(){
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
                }).then((result) => {
                if (result.isConfirmed) {
                    this.form.put(this.route('product.update', this.form.id))
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
                })
            },
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
                    this.form.get(this.route('product.destroy', this.form.id))
                }
            })
        },

        // update() {
        //     if (confirm('Are you sure you want to update this Product?')) {
        //      this.form.put(this.route('product.update', this.form.id))
        //     }
        // },
        // destroy() {
        //     if (confirm('Are you sure you want to delete this Product?')) {
        //         this.form.get(this.route('product.destroy', this.form.id))
        //     }
        // },

    },
    }
</script>

