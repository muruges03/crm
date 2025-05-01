<template>
    <div>
  <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" v-if="addProduct" >
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>           
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                            
        <form class="space-y-1 divide-y bg-white-300" @submit.prevent="productstore">
            <div class="space-y-1 divide-y divide-gray-200">

                <div class="pt-1">
                    <!-- <div>
                    </div> -->
                    <div class=" md:flex xl:flex p-2">
                        <fieldset class="ml-2 p-1 flex-1 border-gray-900" >
                            <!-- <legend >Product</legend> -->
                            <div class=" grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">



                                <div class="sm:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700">
                                    Title
                                    </label>
                                    <div class="">
                                        <input type="text"  v-model="productform.title" name="title" id="title" autocomplete="title" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="productform.errors.title" class="text-red-500">{{ productform.errors.title }}</div>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="uom" class="block text-sm font-medium text-gray-700">
                                    UOM
                                    </label>
                                    <div class="">
                                        <select id="uom" name="uom" v-model="productform.uom" autocomplete="uom" class="shadow-sm md:h-select focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option  :value="null" />
                                            <option value="M3">M3</option>
                                            <option value="SQM">SQM</option>
                                            <option value="NOS">NOS</option>
                                            <option value="KG">KG</option>
                                            <option value="M">M</option>
                                            <option value="CFT">CFT</option>
                                            <option value="G">G</option>
                                            <option value="LOAD">LOAD</option>
                                            <option value="MT">MT</option>
                                            <option value="FT">FT</option>
                                            <option value="BOX">BOX</option>
                                            <option value="LTS">LTS</option>
                                            <option value="OZ">OZ</option>
                                            <option value="LBS">LBS</option>
                                            <option value="UNIT">UNIT</option>
                                            <option value="ROLL">ROLL</option>
                                            <option value="SET">SET</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="amount_per_uom" class="block text-sm font-medium text-gray-700">
                                    Amount Per Uom
                                    </label>
                                    <div class="">
                                        <input type="number" step=any  v-model="productform.amount_per_uom" name="amount_per_uom" id="amount_per_uom" autocomplete="amount_per_uom" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="productform.errors.amount_per_uom" class="text-red-500">{{ productform.errors.amount_per_uom }}</div>
                                    </div>
                                </div>

                            </div>


                            <div class=" grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">



                                <div class="sm:col-span-2">
                                    <label for="amount" class="block text-sm font-medium text-gray-700">
                                       Amount
                                    </label>
                                    <div class="">
                                        <input type="number"  step=any v-model="productform.amount" name="amount" id="amount" autocomplete="amount" class="shadow-sm md:h-textbox focus:ring-indigo-500 focus:border-indigo-300 block w-full sm:text-sm border-gray-300 rounded-md" />
                                        <div v-if="productform.errors.amount" class="text-red-500">{{ productform.errors.amount }}</div>
                                    </div>
                                </div>

                            </div>

                        </fieldset>

                      </div>
                 </div>
             </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button  type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" >
                                Save
                              </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                              <button @click="closeProduct()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancel
                              </button>
                            </span>
                        </div> 
                         </form>     
                     </div>
                       
                </div>
        </div>
    </div>

    </div>
</template>

<script>

    export default ({
                 data() {
                    return {           
                    productform:this.$inertia.form({
                        lot: null,
                        title: null,
                        code: null,
                        alias: null,
                        slug: null,
                        metadata: null,
                        quantity: null,
                        uom: null,
                        amount: null,
                        amount_per_uom: null,
                        discount: 0.00,
                    }),
                    addProduct:false,
                    }
         },
         methods:{
             productstore(){
               //alert();
                this.productform.post(this.route('product.store'))
             },
             openProduct:function(e){
                if(this.form.product_id==null||this.form.product_id==''){
                    this.addProduct = true;
                }               
            },
            closeProduct: function () {
                this.addProduct = false;
            },
         },

    })
</script>
