<template>
    <app-menu />
    <h2 class="text-3xl lg:pl-64 ml-8 sm:pt-6">
        Permissions Form
    </h2>
     <div class="lg:pl-64 flex flex-col bg-white divide-x divide-gray-200 border-2 shadow-md">
       <div class=" md:col-span-2 p-5">
         <form @submit.prevent="update" enctype="multipart/form-data" class="border-2">
           <div class="shadow overflow-hidden sm:rounded-md">
             <div class="px-2 py-3 bg-white sm:p-6">
               <div class="grid grid-cols-6 gap-4">
                 <div class="col-span-6 sm:col-span-2">
                   <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                   <input type="text" v-model="form.name"  id="name" autocomplete="given-name"  class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                     <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
                 </div>

                  <div class="col-span-6 sm:col-span-2">
                   <label for="guard_name" class="block text-sm font-medium text-gray-700">Guard Name</label>
                   <input type="text" v-model="form.guard_name"  id="guard_name" autocomplete="guard_name" required class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                     <div v-if="form.errors.guard_name" class="text-red-500">{{ form.errors.guard_name }}</div>
                 </div>
               </div>
             </div>
              <div class="flex justify-center p-2">
                   <button type="button" @click="destroy" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm text-red-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Delete
                    </button>
                    <button type="submit" @click="update" class="ml-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">
                    Update<i class="fa fa-user-o" style="padding-left: 10px;font-size: 0.9em" aria-hidden="true"></i>
                    </button>
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
     export default ({
         components: {
             AppLayout,
             AppMenu,
             Welcome,
             Pagination,
             JetLabel,
             Multiselect
             
         },
         remember: 'form',
             props: {
              permission:Object,
              },
         data() {
             return {
             form: this.$inertia.form({
                 name: this.permission.name,
                 guard_name: this.permission.guard_name,
             }), 
             }
         },
         methods: {
             update() {
                this.form.post(this.route('permissions.update',this.permission.id))
              },
            destroy() {
                if (confirm('Are you sure you want to delete this Permission?')) {
                  this.$inertia.delete(this.route('permissions.destroy', this.permission.id))
                }
           },
         },
     })
 </script>
<style>
    h2{
    color:#37577c;
    font: 16px/16px, 'Roboto Condensed', sans-serif;
    font-weight: 700;
}
</style>
