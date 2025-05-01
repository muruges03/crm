<template>
    <app-menu />
    <div class="lg:pl-64 flex flex-col ">
        <div class="px-4 py-4 ">
            <div class="shadow-lg rounded-md">
                <h2 class="text-lg font-semibold flex px-4 py-2">
                    <inertia-link class="hover:text-black-600 mt-1 flex" :href="route('defaultSetting.index')">
                        <img src="/assets/add-product.png" class="w-6 h-6 mr-3">Update Default Ledger Setting
                    </inertia-link>
                </h2>
                <div class="px-4 py-4">
                    <form  @submit.prevent="store" >

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 ">
                                    Type
                                </label>
                                <Multiselect :value="this.type"  :multiple="false" v-model="form.type" select-label="" deselect-label="" class="!block"
                                             placeholder="Select" ref="name" :options="this.type" :searchable="true" :allow-empty="true">

                                </Multiselect>
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Title
                                </label>
                                <jet-input type="text"  v-model="form.name" name="name" id="name"   />
                                <div v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Ledger
                                </label>
                                <Multiselect :value="this.ledger.id"  :multiple="false" v-model="form.ledger_id" select-label="" deselect-label="" track-by="id" label="title" class="!block"
                                             placeholder="Select" ref="name" :options="this.ledger" :searchable="true" :allow-empty="true">

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
    metaInfo: { title: 'defaultSetting' },
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
    props:['ledger','defaultSetting'],
    data() {
        return {
            type:['Invoice','Tax','Patron'],
            form: this.$inertia.form({
                id             : this.defaultSetting.id,
                type           : this.defaultSetting.type,
                ledger_id      : this.defaultSetting.ledger_id,
                name           : this.defaultSetting.name,
            }),
        }
    },
    methods: {

        store() {
            // alert();
            this.form.put(this.route('defaultSetting.update',this.defaultSetting.id))
        },
    },
}


</script>

