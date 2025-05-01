<template>
    <app-menu />

    <div class="lg:pl-64 flex flex-col ">
        <div class="p-5">

            <h2 class="font-semibold text-lg flex px-4 py-2">
                <inertia-link class="hover:text-black-600 flex" :href="route('user')">
                    <img src="/assets/customer.png" class="w-6 h-6 mr-3">
                    CREATE NEW USER
                </inertia-link>
            </h2>
            <form class="" @submit.prevent="store">
                <div class="px-4 py-2">
                    <div class="grid grid-cols-6 gap-4">
                        <div class="col-span-6 sm:col-span-2">
                            <label for="first-name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">First Name</label>
                            <jet-input type="text" v-model="form.first_name"  id="first_name" name="first_name"    />
                            <div v-if="form.errors.first_name" class="text-red-500 text-xs">{{ form.errors.first_name }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="last-name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <jet-input type="text" v-model="form.last_name"  id="last_name"  name="last_name"    />
                            <div v-if="form.errors.last_name" class="text-red-500 text-xs">{{ form.errors.last_name }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="last-name" class="block text-sm font-medium text-gray-700">Role</label>
                            <select
                                class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                id="role"  :searchable="true"
                                v-model="form.role">
                                <option value="null" disabled selected hidden>Choose.</option>
                                <option value="super-admin" >Super Admin</option>
                                <option value="admin" >Admin</option>
                                <option value="user" >User</option>

                            </select>
                            <div v-if="form.errors.role" class="text-red-500 text-xs">{{ form.errors.role }}</div>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="email-address" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Email Address</label>
                            <jet-input type="text" v-model="form.email"  id="email" autocomplete="email"  />
                            <div v-if="form.errors.email" class="text-red-500 text-xs">{{ form.errors.email }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="password" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Password</label>
                            <jet-input id="password" type="password"  v-model="form.password"  autocomplete="new-password"  />
                            <div v-if="form.errors.password" class="text-red-500 text-xs">{{ form.errors.password }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="password-confirmation" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Password Confirmation</label>
                            <jet-input id="passwordconfirmation" type="password" v-model="form.password_confirmation"  autocomplete="new-password" />
                            <div v-if="form.errors.password_confirmation" class="text-red-500 text-xs">{{ form.errors.password_confirmation }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="entity" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Entity</label>
                            <select class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model='form.entity'>
                                <option value="null" disabled selected hidden>Choose.</option>
                            <option v-for='data in entity' :key='data.id' :value='data.id'>{{ data.legal_name }}</option>
                            </select>
                            <div v-if="form.errors.entity" class="text-red-500 text-xs">{{ form.errors.entity }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="personnel" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                            Personnel
                            </label>
                            <Multiselect :value="personnel.id" :multiple="false" v-model="form.personnel" deselect-label="Can't remove this value" track-by="id" label="first_name" class="!block"
                                placeholder="Select one" :options="personnel" :searchable="true" :allow-empty="true">
                                <template ><strong> {{ personnel.first_name }}</strong></template>
                            </Multiselect>
                            <div v-if="form.errors.personnel" class="text-red-500 text-xs">{{ form.errors.personnel }}</div>
                        </div>
                        <div v-if="selected != 'company'" class="col-span-6 sm:col-span-4">
                            <label for="entity_access" class="block text-sm font-medium text-gray-700">
                            Entity Access
                            </label>
                            <Multiselect :value="options.id" :multiple="true" v-model="form.entity_access" deselect-label="Can't remove this value" track-by="id" label="legal_name" class="!block"
                                placeholder="Select one" :options="options" :searchable="true" :allow-empty="true">
                                <template ><strong> {{ option.legal_name }}</strong></template>
                            </Multiselect>
                            <div v-if="form.errors.entity_access" class="text-red-500 text-xs">{{ form.errors.entity_access }}</div>
                        </div>
                            <div class="col-span-6 sm:col-span-2">
                            <label for="last-name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">Owner</label>
                            <select class=" block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    id="owner"  :searchable="true"
                                    v-model="form.owner">
                                <option value="null" disabled selected hidden>Choose.</option>
                                <option :value="true" >Yes</option>
                                <option :value="false" >No</option>
                            </select>
                            <div v-if="form.errors.owner" class="text-red-500 text-xs">{{ form.errors.owner }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <label for="cover-photo" class="block text-sm font-medium text-gray-700 sm:mt-px "> Profile Upload </label>
                            <div class=" sm:mt-0 sm:col-span-4">
                                <div class=" flex justify-center   border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-6 w-6 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="photo_path" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="photo_path" name="photo_path" class="sr-only"  type="file" @change="previewImage" ref="photo_path" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="form.errors.photo_path" class="text-red-500 text-xs">{{ form.errors.photo_path }}</div>
                        </div>


                    </div>
                </div>
                <div class="flex justify-center p-2 ">
                    <jet-button type="submit" >
                        CREATE
                    </jet-button>
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
    import JetButton from '@/Jetstream/Button.vue'
        import JetInput from '@/Jetstream/Input.vue'

    export default ({
        components: {
            AppLayout,
            AppMenu,
            Welcome,
            Pagination,
            JetLabel,
            Multiselect,
            JetButton,
            JetInput
        },
        remember: 'form',
        data() {
            return {
            form: this.$inertia.form({
                first_name: null,
                last_name: null,
                role: null,
                owner:null,
                email: null,
                password: null,
                password_confirmation: null,
                entity:null,
                personnel:null,
                entity_access: null,
                photo_path:null,
            }),
            url: null,
            options: this.entity_access,
            selected:null,
            }
        },
        props: {
            entity: Object,
            entity_access: Object,
            role: Object,
            personnel: Object,
        },
        methods: {
            store() {
                if (this.$refs.photo_path) {
                    this.form.photo_path = this.$refs.photo_path.files[0];
                }
                this.form.post(this.route('user.store'))
            },
            previewImage(e) {
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
            },
        },
     })
 </script>



