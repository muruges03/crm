<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <h2 class="text-lg font-semibold flex px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('accounts.index')">
                        <img src="/assets/add-product.png" class="w-6 h-6 mr-3">Create Account
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

                        </div>
<!--                        v-if="$page.props.auth.user.can['create_account']==true"-->
                        <div class="p-2" >
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
    metaInfo: { title: 'Account' },
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

    data() {
        return {
            form: this.$inertia.form({
                name: null,
            }),
        }
    },
    methods: {

        store() {
            // alert();
            this.form.post(this.route('accounts.store'))
        },
    },
}


</script>

