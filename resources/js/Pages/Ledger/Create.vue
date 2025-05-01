<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <h2 class="text-lg font-semibold flex px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('accounts.index')">
                        <img src="/assets/add-product.png" class="w-6 h-6 mr-3">Create Ledger
                    </inertia-link>
                </h2>
                <div class="px-4 py-4">
                    <form  @submit.prevent="store" >

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Title
                                </label>
                                <jet-input type="text"  v-model="form.title" name="title" id="title"   />
                                <div v-if="form.errors.title" class="text-xs text-red-500">{{ form.errors.title }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <label for="account_type_id" class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Account Type
                                </label>
                                <Multiselect :value="this.accountType.id"  :multiple="false" v-model="form.account_type_id" select-label="" deselect-label="" track-by="id" label="type_name" class="!block"
                                             placeholder="Select" ref="name" :options="this.accountType" :searchable="true" :allow-empty="true">
                                    <template ><strong> {{ this.accountType.type_name }}</strong></template>
                                </Multiselect>
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <label for="type" class="block text-sm font-medium text-gray-700 ">
                                    Type
                                </label>
                                <Multiselect :value="this.type"  :multiple="false" v-model="form.type" select-label="" deselect-label="" class="!block"
                                             placeholder="Select" ref="name" :options="this.type" :searchable="true" :allow-empty="true">

                                </Multiselect>
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <label for="opening_balance" class="block text-sm font-medium ">
                                    Opening Balance
                                </label>
                                <jet-input type="number"  v-model="form.opening_balance" name="opening_balance" id="opening_balance"   />
                                <div v-if="form.errors.opening_balance" class="text-xs text-red-500">{{ form.errors.opening_balance }}</div>
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
import Multiselect from '@suadelabs/vue3-multiselect'
export default {
    metaInfo: { title: 'Ledger' },
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
    props:['accountType'],
    data() {
        return {
            type:['Credit','Debit'],
            form: this.$inertia.form({
                title           : null,
                account_type_id : null,
                notes           : null,
                type            : null,
                opening_balance : 0.00,
            }),
        }
    },
    methods: {

        store() {
            // alert();
            this.form.post(this.route('ledger.store'))
        },
    },
}


</script>

