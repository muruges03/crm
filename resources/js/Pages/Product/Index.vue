
<template>
 <app-menu />
   <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <div class="py-4 px-4 md:px-6">
                    <div class="mt-4 sm:mt-0 flex  md:px-6 justify-between">
                        <h2 class="text-lg font-semibold flex"><img src="/assets/add-product.png" class="w-6 h-6 mr-3">PRODUCT LIST</h2>
                        <jet-button type="button" >
                            <inertia-link :href="route('product.create')" v-if="$page.props.auth.user.can['create_products']==true">Create</inertia-link>
                        </jet-button>
                    </div>
                </div>
                <div class=" px-4 py-2 flex sm:items-center justify-between sm:px-6 ">
                    <div class="block flex">

                        <select id="" style="height:40px !important;" v-model="length" @change="resetPagination(length)" name="" autocomplete="country-name" class=" block focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <input
                            name="table_search"
                            v-model="term"
                            @keyup="search"
                            type="text"
                            autocomplete="off"
                            class=" focus:ring-indigo-500 focus:border-indigo-500 ml-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            placeholder="Search Product ..."
                        />
                    </div>
                </div>
                <div class=" overflow-x-auto px-4">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-4">
                        <div class=" overflow-hidden  border-gray-200 ">
                            <Table
                                :on-update="setQueryBuilder"
                                :meta="products"
                                class="min-w-full divide-y divide-gray-200"
                            >
                                <template #head>
                                <tr>
                                    <th class=" px-3 py-3.5 text-left text-sm font-semibold text-gray-900" @click.prevent="sortBy('name')">Name</th>
                                    <th class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell" @click.prevent="sortBy('sale_price')">Sale Price</th>
                                    <th class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell" @click.prevent="sortBy('quantity')">Quantity</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </template>
                                <template #body>
                                <tr v-for="(product,index ) in products.data" :key="product.id" v-bind:class="index % 2 === 0 ? 'transition ease-in-out delay-100 hover:-translate-y-2 duration-100 hover:bg-gray-100 bg-white' : 'transition ease-in-out delay-100 hover:-translate-y-2 duration-100 hover:bg-gray-50 bg-gray-100'">
                                    <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                                        <inertia-link  v-bind:href="route('product.edit', product.id)" >{{ product.name }}</inertia-link>
                                        <dl class="font-normal lg:hidden">
                                            <dt class="sr-only sm:hidden">Amount</dt>
                                            <dd class="mt-1 truncate text-gray-500 sm:hidden"><inertia-link v-bind:hef="route('product.edit', product.id)" >{{ product.sale_price }}</inertia-link></dd>
                                            <dt class="sr-only sm:hidden">Quantity</dt>
                                            <dd class="mt-1 truncate text-gray-500 sm:hidden"><inertia-link v-bind:hef="route('product.edit', product.id)" >{{ product.quantity }}</inertia-link></dd>
                                        </dl>
                                    </td>
                                    <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"><inertia-link v-bind:href="route('product.edit', product.id)" >{{ product.sale_price }}</inertia-link></td>
                                    <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"><inertia-link v-bind:href="route('product.edit', product.id)" >{{ product.quantity }}</inertia-link></td>
                                    <td class="py-4 pl-3 pr-4 flex justify-center text-sm font-medium sm:pr-6">

                                        <inertia-link class="" v-bind:href="route('product.edit', product.id)" v-if="$page.props.auth.user.can['edit_products']==true">
                                            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:29px;">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </inertia-link>
                                    </td>
                                </tr>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
   // import { ref } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Pagination from '@/Jetstream/Pagination'
    import {TrashIcon} from '@heroicons/vue/outline'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';
        import Swal from 'sweetalert2'
    export default ({
        mixins: [InteractsWithQueryBuilder],
        components: {
            AppLayout,
            AppMenu,
            Welcome,
            Pagination,
            TrashIcon,
            GrayButton,
            JetButton,
            Table: Tailwind2.Table
        },
       props: [
            "products",
        ],
    data() {
        return {
            keyword: null,
            length:10,
            term:null,
        }
    },

    methods: {
        destroy(id) {
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
                        this.$inertia.get(this.route('product.destroy', id))
                    }
                })
            },
         search() {
            this.$inertia.replace(this.route('product', {term: this.term}))
          },
          resetPagination(length){
            //console.log(length);
            this.$inertia.replace(this.route('product', {length: this.length}))
          },
    },
    })
</script>
