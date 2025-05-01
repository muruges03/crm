<template>
    <app-menu />

    <!-- {{$page.props.auth}} -->
<div  class="lg:pl-64 flex flex-col bg-white mt-8 " v-if="$page.props.auth.user.can['is_admin']==true">
          <div class="ml-2" v-if="$page.props.auth.user.can['delete_entity']==true">
              <h2 class="text-gray-800 text-xs md:text-xl font-medium uppercase tracking-wide">All Organization </h2>
              <ul  role="list" class=" ml-2 mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
               <li class="col-span-1 flex shadow-sm rounded-md" v-for="(orginations , index) in orgination" :key="orginations.id">
                  <div  v-bind:class="index % 2 === 0 ? 'flex-shrink-0 flex items-center rounded-full justify-center w-16 bg-blue-600 text-white text-sm font-medium rounded-l-md' : 'flex-shrink-0 flex items-center rounded-full justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md'">
                    {{orginations.legal_name.split(' ').map(x => x[0].toUpperCase()).join('')}}
                  </div>
                  <div @click="data(orginations.id)" class="flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                      <div class="flex-1 px-4 py-2 text-sm truncate">
                      <a href="#" class="text-gray-900 font-medium hover:text-gray-600">  {{orginations.legal_name}}</a>
                      </div>
                  </div>
                  </li>
              </ul>

              <h2 class="text-gray-800 text-xs md:text-xl font-medium uppercase tracking-wide mt-5">All Company </h2>
              <ul role="list" class="ml-2 mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
               <li class="col-span-1 flex shadow-sm rounded-md" v-for="(companys, index) in company" :key="companys.id">
                  <div  v-bind:class="index % 2 === 0 ? 'flex-shrink-0 flex items-center rounded-full justify-center w-16 bg-blue-600 text-white text-sm font-medium rounded-l-md' : 'flex-shrink-0 flex items-center rounded-full justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md'">
                       {{companys.legal_name.split(' ').map(x => x[0].toUpperCase()).join('')}}
                  </div>
                  <div @click="data(companys.id)" class="flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                      <div class="flex-1 px-4 py-2 text-sm truncate">
                      <a href="#" class="text-gray-900 font-medium hover:text-gray-600"> {{companys.legal_name}}</a>
                      </div>
                  </div>
                  </li>
              </ul>
        </div>
          <div class="ml-2 mt-5" v-if="$page.props.auth.user.can['delete_users']==true">
              <h2 class="text-gray-800 md:text-xl text-xs font-medium uppercase tracking-wide">Company</h2>
              <ul role="list" class=" ml-2 mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
               <li class="col-span-1 flex shadow-sm rounded-md" v-for="(entitia, index) in adminentitys" :key="entitia.id">
                  <div  v-bind:class="index % 2 === 0 ? 'flex-shrink-0 flex items-center rounded-full justify-center w-16 bg-blue-600 text-white text-sm font-medium rounded-l-md' : 'flex-shrink-0 flex items-center rounded-full justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md'">
                    {{entitia['legal_name'].split(' ').map(x => x[0].toUpperCase()).join('')}}
                  </div>
                  <div  @click="data(entitia['id'])" class="flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                      <div class="flex-1 px-4 py-2 text-sm truncate">
                      <a href="#" class="text-gray-900 font-medium hover:text-gray-600">{{entitia['legal_name']}}</a>
                      </div>
                  </div>
                  </li>
              </ul>
          </div>

  </div>
</template>

<script>
  import { defineComponent } from 'vue'
  import AppLayout from '@/Layouts/AppLayout.vue'
  import AppMenu from '@/Layouts/Appmenu.vue'
  import Welcome from '@/Jetstream/Welcome.vue'

  export default defineComponent({

      components: {
          AppLayout,
          AppMenu,
          Welcome,
      },
      props: {
          orgination: Object,
          adminentity: Object,
          company: Object,
      },
      data() {
          return {
          // adminentity:this.adminentity,
          adminentitys:[],
          }
      },
      methods: {
           data(id) {
              //  alert(id);
                 this.$inertia.get(this.route('home.entity',id))
           },
          entityadmin(){
              var n = [this.adminentity];
                  n.forEach(i=>{
                      var merged = [].concat.apply([], i);
                      this.adminentitys=merged;
                  })
          }
      },
      mounted(){
          this.entityadmin();
      }
  })
</script>
