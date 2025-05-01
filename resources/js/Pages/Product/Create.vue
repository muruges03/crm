<template>
  <app-menu />
    <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <h2 class="text-lg font-semibold flex px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('product')">
                        <img src="/assets/add-product.png" class="w-6 h-6 mr-3">Create Product
                    </inertia-link>
                </h2>
                <div class="px-4 py-4">
                    <form  @submit.prevent="store" >

                    <div class="grid grid-cols-6 gap-4">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                Name
                                </label>
                                <jet-input type="text"  v-model="form.name" name="name" id="name"   />
                                <div v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="tax" class="block text-sm font-medium text-gray-700">
                                Tax
                                </label>
                                <div class="">
                                    <select v-model='form.tax_id' class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                                        <option value="null"  selected>Choose.</option>
                                        <option v-for='data in tax' :key='data.id' :value='data.id' > {{data.tax_name}} {{ data.tax_amount }} %</option>
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
                                    <jet-input type="number" step=any  v-model="form.sale_price" name="sale_price" id="sale_price"  />
                                    <div v-if="form.errors.sale_price" class="text-xs text-red-500">{{ form.errors.sale_price }}</div>
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="purchase_price" class="block text-sm font-medium text-gray-700">
                                Purchase Price
                                </label>
                                <div class="">
                                    <jet-input type="number" step=any  v-model="form.purchase_price" name="purchase_price" id="purchase_price"  />
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
                        <div class="p-2" v-if="$page.props.auth.user.can['create_products']==true">
                            <div class="flex justify-end ">
                                <jet-button type="submit">
                                    CREATE
                                </jet-button>
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
            JetInput
    },
    props:[
        'tax'
    ],
  data() {
    return {
        form: this.$inertia.form({
            name: null,
            code: null,
            description: null,
            sale_price: null,
            purchase_price: null,
            quantity: null,
            category_id: null,
            tax_id: null,
        }),
    }
},
    methods: {

        store() {
            // alert();
        this.form.post(this.route('product.store'))
        },
  },
}


</script>

