<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <h2 class="text-lg font-semibold flex px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('accounts.index')">
                        <img src="/assets/add-product.png" class="w-6 h-6 mr-3">Update Account Type
                    </inertia-link>
                </h2>
                <div class="px-4 py-4">
                    <form  @submit.prevent="store" >

                        <div class="grid grid-cols-6 gap-4">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Type Name
                                </label>
                                <jet-input type="text"  v-model="form.type_name" name="name" id="name"   />
                                <div v-if="form.errors.type_name" class="text-xs text-red-500">{{ form.errors.type_name }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Account Name
                                </label>
                                <Multiselect class="!block" :value="this.account.id"  :multiple="false" v-model="form.account_id" select-label="" deselect-label="" track-by="id" label="name"
                                             placeholder="Select" ref="name" :options="this.account" :searchable="true" :allow-empty="true">
                                    <template ><strong> {{ this.account.name }}</strong></template>
                                </Multiselect>
                            </div>

                        </div>
                        <!--                        v-if="$page.props.auth.user.can['create_account']==true"-->
                        <div class="p-2" >
                            <div class="flex justify-end ">
                                <jet-button type="submit">
                                    Update
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
import Multiselect from '@suadelabs/vue3-multiselect'
export default {
    metaInfo: { title: 'Account Type' },
    remember: 'form',
    components: {
        AppLayout,
        AppMenu,
        Welcome,
        Pagination,
        GrayButton,
        JetButton,
        JetInput,Multiselect
    },
    props:['account','accountType'],
    data() {
        return {
            form: this.$inertia.form({
                id         : this.accountType.id,
                type_name  : this.accountType.type_name,
                account_id : this.accountType.account_id,
            }),
        }
    },
    methods: {
        store() {
            this.form.put(this.route('accountType.update',this.accountType.id))
        },
    },
}


</script>

