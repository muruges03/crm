<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col  shadow-md">
        <div class="p-5">
        <h2 class=" font-semibold text-lg flex px-4 py-2 ">
            <inertia-link class="hover:text-black-600 flex px-3" :href="route('user')">  <img src="/assets/customer.png" class="w-6 h-6 mr-3">UPDATE USER</inertia-link>
            <span class="text-gray-500 font-medium">
                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </span>
        <span class="text-gray-700">{{ form.first_name }} {{ form.last_name }}</span>
        </h2>

        <div class=" md:col-span-2 p-5">
            <form @submit.prevent="update">
                <div class="grid grid-cols-6 gap-4">
                    <div class="col-span-6 sm:col-span-2">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">First Name</label>
                        <jet-input type="text" v-model="form.first_name"  id="first_name" name="first_name" />
                        <div v-if="form.errors.first_name" class="text-red-500 text-xs">{{ form.errors.first_name }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <jet-input type="text" v-model="form.last_name"  id="last_name" />
                        <div v-if="form.errors.last_name" class="text-red-500 text-xs">{{ form.errors.last_name }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="last-name" class="block text-sm font-medium text-gray-700 ">Role</label>
                        <select
                            class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            id="role"  :searchable="true"
                            v-model="form.role">
                            <option value="null" disabled selected hidden>Choose.</option>
                            <option value="super-admin" v-if="$page.props.auth.user.can['delete_entity']==true">Super Admin</option>
                            <option value="admin" >Admin</option>
                            <option value="user" >User</option>
                        </select>
                        <div v-if="form.errors.roles" class="text-red-500 text-xs">{{ form.errors.roles }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="last-name" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Owner</label>
                        <select class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="owner"  :searchable="true"
                                v-model="form.owner">
                            <option value="null" disabled selected hidden>Choose.</option>
                            <option :value="true" >Yes</option>
                            <option :value="false" >No</option>
                        </select>
                        <div v-if="form.errors.owner" class="text-red-500 text-xs">{{ form.errors.owner }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="email-address" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Email Address</label>
                        <jet-input type="text" v-model="form.email"  id="email" autocomplete="email"   />
                        <div v-if="form.errors.email" class="text-red-500 text-xs">{{ form.errors.email }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="password" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Password</label>
                        <jet-input id="password" type="password"  v-model="form.password"  autocomplete="new-password"  />
                        <div v-if="form.errors.password" class="text-red-500 text-xs">{{ form.errors.password }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="password-confirmation" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Password Confirmation</label>
                        <jet-input id="passwordconfirmation" type="password" v-model="form.password_confirmation"  autocomplete="new-password" />
                        <div v-if="form.errors.password_confirmation" class="text-red-500 text-xs">{{ form.errors.password_confirmation }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="personnel" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Personnel</label>
                        <jet-input id="personnel" type="text"  v-model="this.personnel[0].first_name"  readonly autocomplete="Personnel" />
                        <div v-if="form.errors.personnel" class="text-red-500 text-xs">{{ form.errors.personnel }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="entity" class="block text-sm font-medium text-gray-700  after:content-['*'] after:ml-0.5 after:text-red-500">Entity</label>
                            <select v-model='form.entity' v-if="$page.props.auth.user.roles=='admin'" class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" disabled>
                                    <option value="null" disabled selected hidden>Choose.</option>
                                <option v-for='data in entityusers' :key='data.id' :value='data.id'>{{ data.legal_name }}</option>
                            </select>
                            <select v-model='form.entity' v-if="$page.props.auth.user.roles=='super-admin'" class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                                    <option value="null" disabled selected hidden>Choose.</option>
                                <option v-for='data in entityusers' :key='data.id' :value='data.id'>{{ data.legal_name }}</option>
                            </select>
                        <div v-if="form.errors.entity" class="text-red-500 text-xs">{{ form.errors.entity }}</div>
                    </div>
                        <div v-if="selected != 'company'" class="col-span-6 sm:col-span-6">
                        <label for="entity_access" class="block text-sm font-medium text-gray-700 ">
                        Entity Access
                        </label>
                        <Multiselect :value="options.id" :multiple="true" v-model="form.entity_access" deselect-label="Can't remove this value" track-by="id" label="legal_name" class="!block"
                            placeholder="Select one" :options="options" :searchable="true" :allow-empty="true">
                            <template ><strong> {{ option.legal_name }}</strong></template>
                        </Multiselect>
                    </div>
                    <div  class="col-span-6 sm:col-span-2">
                        <label for="File" class="block text-sm font-medium text-gray-700  ">File Upload</label>
                        <input
                            type="file"
                            @change="previewImage"
                            ref="photo"
                            class="  w-full  md:htextbox  px-2  py-1 text-sm border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"/>
                        <img v-if="url" :src="url" class="w-full mt-2 h-20"/>
                        <div v-if="form.errors.photo" class="text-red-500 text-xs">{{ form.errors.photo }}</div>
                    </div>
                    <div  class="col-span-6 sm:col-span-2 md:mt-5">
                            <gray-button type="button"  @click="image(images)" >
                                Update Image<i class="fa fa-user-o" style="padding-left: 10px;font-size: 0.9em" aria-hidden="true"></i>
                            </gray-button>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label for="images" class="mb-2 block text-sm font-medium text-gray-700">Image</label>
                        <img
                            :src="showImage() + form.photo"
                            class="object-cover h-25 w-40"
                        />
                    </div>
                </div>

                <div class="flex justify-between p-2">
                    <gray-button v-if="!user.deleted_at"  tabindex="-1"  @click="destroy" class="text-red-800" type="submit">Delete </gray-button>
                    <jet-button :loading="form.processing" @click="update"  type="submit">Update </jet-button>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import AppMenu from '@/Layouts/Appmenu.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Pagination from '@/Jetstream/Pagination'
    import Multiselect from '@suadelabs/vue3-multiselect'
    import GrayButton from '@/Jetstream/GrayButton.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import Swal from 'sweetalert2'
    import JetInput from '@/Jetstream/Input.vue'

export default {
  metaInfo() {
    return {
      title: `${this.form.first_name} ${this.form.last_name}`,
    }
  },
  components: {
      AppLayout,
      AppMenu,
      Welcome,
      Pagination,
      Multiselect,
      GrayButton,
      JetButton,
      JetInput

  },
  props: {
    user: Object,
    roles:Array,
    entyuser:Object,
    entityusers:Object,
    enitycompany:Object,
    personnel:Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        first_name: this.user.first_name,
        last_name: this.user.last_name,
        email: this.user.email,
        entity: this.user.entity,
        password: null,
        owner: this.user.owner,
        photo: this.user.photo,
        role:this.user.roles[0].name,
        entity_access:[this.entyuser],
        password_confirmation:null,
      }),
        images: this.$inertia.form({
            photo: null,
        }),
       options: this.enitycompany,
       url:null,
       selected:null,
    }
  },
  methods: {

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
                  this.$inertia.delete(this.route('users.destroy', this.user.id))
                }
            })
        },
    update() {
        this.form.post(this.route('users.update', this.user.id), {
            onSuccess: () => this.form.reset('password', 'photo'),
        })
    },

    image() {
        if (this.$refs.photo) {
            this.images.photo = this.$refs.photo.files[0];
            }
            this.images.post(this.route('user.updateimage', this.user.id))
        },
    previewImage(e) {
        const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
    showImage() {
        this.img='/storage/public/';
        //console.log('',this.img,this.legal_name);
        return this.img;
    },
    entityuserdata(){
        var n = [this.entyuser];
            n.forEach(i=>{
                var merged = [].concat.apply([], i);
                this.form.entity_access=merged;
            })
        }
    },
  mounted(){
      this.entityuserdata();
  }
}
</script>

