<template>
    <app-menu />
    <h2 class="text-xl lg:pl-64 ml-8 sm:pt-6">
        Update Role Form
    </h2>
       <div class="lg:pl-64 flex flex-col bg-white divide-x divide-gray-200 border-2 shadow-md">
            <div class=" md:col-span-2 p-5">
                <form @submit.prevent="update" enctype="multipart/form-data" class="border-2">
                    <div class="shadow overflow-visible sm:rounded-md">
                        <div class="px-2 py-3 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-4">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" v-model="form.name"  id="name" autocomplete="given-name"  class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                    <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="guard_name" class="block text-sm font-medium text-gray-700">Guard Name</label>
                                    <input type="text" v-model="form.guard_name"  id="guard_name" autocomplete="guard_name" required class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly/>
                                    <div v-if="form.errors.guard_name" class="text-red-500">{{ form.errors.guard_name }}</div>
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="Permissions" class="block text-sm font-medium text-gray-700">Available Permissions</label>
                                    <Multiselect  :value="options.id" :multiple="true" v-model="form.permissions" deselect-label="Can't remove this value" track-by="id" label="name" class="!block"
                                        placeholder="Select one" :options="options" :searchable="true" :allow-empty="false">
                                        <template ><strong> {{ option.name }}</strong></template>
                                    </Multiselect>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center p-2">
                            <button type="submit" class="ml-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500">
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
    import GreenButton from '@/Jetstream/GreenButton.vue'
     export default ({
         components: {
             AppLayout,
             AppMenu,
             Welcome,
             Pagination,
             JetLabel,
             Multiselect,
             GreenButton

         },
         remember: 'form',
             props: {
              role:Object,
              unassignedPermissions: Object,
              assignedPermissions: Object,
              },
         data() {
             return {
             form: this.$inertia.form({
                 name: this.role.name,
                 guard_name: this.role.guard_name,
                 permissions:this.assignedPermissions,
             }),
               url: null,
               options: this.unassignedPermissions,
             }
         },
         methods: {
             update() {
                this.form.post(this.route('roles.update',[this.role.id,this.assignedPermissions]))
              },
            assignPermission(permisi){
              const indexpermisi=this.unassignedPermissions.indexOf(permisi);
              this.assignedPermissions.push({id:permisi.id,name:permisi.name});
              this.unassignedPermissions.splice(indexpermisi,1);
            },
            unassignPermission(permisi){
              const indexpermisi=this.assignedPermissions.indexOf(permisi);
              this.unassignedPermissions.push({id:permisi.id,name:permisi.name});
              this.assignedPermissions.splice(indexpermisi,1);
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
