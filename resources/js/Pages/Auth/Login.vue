<template>

    <section class="h-screen bg-cover bg-center" style="background-image: url('/assets/3.jpg');">
        <div class="h-full flex items-center justify-center">
            <!-- Right column container -->
            <div class="mb-12 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-5/12">
                <jet-authentication-card>
                    <div class="rounded-2xl bg-white shadow-lg py-10 px-4">
                        <div class="flex justify-center">
                            <img src="/assets/modocrm_logo.png" alt="image" class="w-60 py-5 px-4 text-center">
                        </div>
                        <jet-validation-errors class="mb-4" />
                        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                            {{ status }}
                        </div>
                        <form @submit.prevent="submit" class="px-2">
                            <div>
                                <label for="Email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Address</label>
                                <input type="text" id="Email" v-model="form.email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Email Address" required>
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" v-model="form.password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Password" required>
                            </div>
                            <div class="block mt-4">
                                <label class="flex items-center">
                                    <jet-checkbox name="remember" v-model:checked="form.remember" />
                                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                </label>
                            </div>
                            <div class="flex items-center justify-center mt-4">
                                <jet-button class="w-full justify-center">
                                    Log in
                                </jet-button>
                            </div>
                        </form>
                    </div>
                </jet-authentication-card>
            </div>
        </div>
    </section>


</template>

<script>
    import { defineComponent, onMounted } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import {  ExternalLinkIcon } from '@heroicons/vue/solid'
import {
  SparklesIcon
} from '@heroicons/vue/outline'


const people = [
  {
    name: ' Seshasayee',
    role: 'Founder / CEO',
    imageUrl:
      'https://media.istockphoto.com/photos/portrait-of-a-smiling-and-happy-maori-man-picture-id913261346?k=20&m=913261346&s=612x612&w=0&h=dQoTZYOX28ao0U0HOR9rBwTOq4ALsbk5muhRSzR2dSY=',
    bio: 'Ultricies massa malesuada viverra cras lobortis. Tempor orci hac ligula dapibus mauris sit ut eu. Eget turpis urna maecenas cras. Nisl dictum.',
    twitterUrl: '#',
    linkedinUrl: '#',
  },
  {
    name: 'Chithra Seshasayee',
    role: 'Co-Founder / CFO',
    imageUrl:
      'https://media.istockphoto.com/photos/mid-adult-beautiful-woman-picture-id647102618?k=20&m=647102618&s=612x612&w=0&h=37EfthxabrytjznoSQOV8Do9kuvBWjy-6zFhweTW25U=',
    bio: 'Ultricies massa malesuada viverra cras lobortis. Tempor orci hac ligula dapibus mauris sit ut eu. Eget turpis urna maecenas cras. Nisl dictum.',
    twitterUrl: '#',
    linkedinUrl: '#',
  },
  {
    name: 'Gobikrishana ',
    role: 'Co-Founder / CMO',
    imageUrl:
      'https://media.istockphoto.com/photos/sometimes-i-wonder-if-we-would-be-better-off-apart-picture-id1058724200?k=20&m=1058724200&s=612x612&w=0&h=XMuVyOUx_usNOlOh3XDVMo56WlCFzcQIt8LLAvFANdQ=',
    bio: 'Ultricies massa malesuada viverra cras lobortis. Tempor orci hac ligula dapibus mauris sit ut eu. Eget turpis urna maecenas cras. Nisl dictum.',
    twitterUrl: '#',
    linkedinUrl: '#',
  },

]
    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetCheckbox,
            JetLabel,
            SparklesIcon,
            JetValidationErrors,
            Link,
            ExternalLinkIcon,

        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },
        setup() {
    return {
      people
    }

        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    })
</script>
<style>
.shadow-xl {
	--tw-shadow: -2px 5px 39px 7px rgb(80 80 80 / 29%), 0px 10px 10px 0px rgb(244 140 240 / 5%);
	box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}
.to-blue{
    --tw-gradient-to: #24d7ac !important;
}
.from-green {
    --tw-gradient-from: #ef4444 !important;
    --tw-gradient-stops: #18a1b7, var(--tw-gradient-to, rgba(239, 68, 68, 0)) !important;
}
.wave {
    bottom: 0;
    height: 100%;
    left: 0;
    position: fixed;
    z-index: -1;
}

</style>
