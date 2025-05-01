<template>
    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300"
                    leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
                </TransitionChild>
                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                    enter-from="-translate-x-full" enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                    leave-to="-translate-x-full">
                    <div
                        class="relative flex-1 flex flex-col max-w-xs w-full  pb-4 linear-gradient(90deg, #000000 0%, #e5008d 50%, #ff070b 100%)">
                        <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                            enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                            leave-to="opacity-0">
                            <div class="absolute top-0 right-0 -mr-12 pt-2">
                                <button type="button"
                                    class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                    @click="sidebarOpen = false">
                                    <span class="sr-only">Close sidebar</span>
                                    <XIcon class="h-6 w-6 " aria-hidden="true" />
                                </button>
                            </div>
                        </TransitionChild>

                        <div v-for="(entitydatas) in entitydata" :key="entitydatas.id"
                            class="flex-shrink-0 p-3 flex bg-white items-center px-4">
                            <img v-if="!!entitydatas.logo_file" :src="showImage() + entitydatas.logo_file"
                                class="object-cover lg:h-25  w-auto" />
                            <img class="h-15 w-auto"
                                v-if="entitydatas.logo_file === null || entitydatas.logo_file === ''"
                                src="https://onemodo.com/wp-content/uploads/2020/11/onemodo_v3.3.svg" alt="Workflow" />
                        </div>
                        <div class="mt-5 flex-1 h-0 overflow-y-auto">
                            <nav class="px-2 space-y-1">
                                <div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_dashboard'] == true">
                                        <inertia-link :href="route('dashboard')"
                                            :class="[isUrl('dashboard') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('dashboard') ? 'text-white ' : 'text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Dashboard
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_home'] == true">
                                        <inertia-link :href="route('home')"
                                            :class="[isUrl('home') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('home') ? 'text-white ' : 'text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Home
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_entity'] == true">
                                        <inertia-link :href="route('entities')"
                                            :class="[isUrl('entities') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('entities') ? 'text-white' : 'text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            Entity
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_user'] == true">
                                        <inertia-link :href="route('user')"
                                            :class="[isUrl('user') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('user') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            User
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_setting'] == true">
                                        <inertia-link :href="route('settings')"
                                            :class="[isUrl('settings') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('settings') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-width="2"
                                                    d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                                            </svg>
                                            Settings
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_lead'] == true">
                                        <inertia-link :href="route('lead')"
                                            :class="[isUrl('lead') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('lead') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            Lead
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_personnel'] == true">
                                        <inertia-link :href="route('personnel')"
                                            :class="[isUrl('personnel') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('personnel') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Personnel
                                        </inertia-link>
                                    </div>
                                    <!-- v-if="$page.props.auth.user.can['create_']==true" -->
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_invoice'] == true">
                                        <inertia-link :href="route('invoice')"
                                            :class="[isUrl('invoice') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('invoice') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Invoice
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_patron'] == true">
                                        <inertia-link :href="route('patron')"
                                            :class="[isUrl('patron') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('patron') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Customer
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_tax'] == true">
                                        <inertia-link :href="route('tax')"
                                            :class="[isUrl('tax') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('tax') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                                            </svg>
                                            Tax
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_product'] == true">
                                        <inertia-link :href="route('product')"
                                            :class="[isUrl('product') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('product') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            Product
                                        </inertia-link>
                                    </div>
                                    <div class="mb-4" v-if="$page.props.auth.user.can['menu_account'] == true">
                                        <inertia-link :href="route('accounts')"
                                            :class="[isUrl('accounts') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :class="[isUrl('accounts') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                            Account
                                        </inertia-link>
                                    </div>

                                </div>
                            </nav>
                        </div>
                        <div class="flex-shrink-0  border-t bg-white p-2">
                            <img class="ml-4 " width="150" height="" src="/assets/modocrm_logo.png" alt="" />
                        </div>
                    </div>
                </TransitionChild>
                <div class="flex-shrink-0 w-14" aria-hidden="true">
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 bg-gradient-to-r from-[#f80759] to-[#bc4e9c]">
                <div v-for="(entitydatas) in entitydata" :key="entitydatas.id"
                    class="flex items-center h-16 flex-shrink-0 px-4 bg-white">
                    <img v-if="!!entitydatas.logo_file" :src="showImage() + entitydatas.logo_file"
                        class="object-cover lg:h-15 w-auto" />
                    <img class="h-15 w-auto" v-if="entitydatas.logo_file === null || entitydatas.logo_file === ''"
                        src="https://onemodo.com/wp-content/uploads/2020/11/onemodo_v3.3.svg" alt="Workflow" />
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="px-2 space-y-1">
                        <div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_dashboard'] == true">
                                <inertia-link :href="route('dashboard')"
                                    :class="[isUrl('dashboard') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('dashboard') ? 'text-white ' : 'text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_home'] == true">
                                <inertia-link :href="route('home')"
                                    :class="[isUrl('home') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" :class="[isUrl('home') ? 'text-white ' : 'text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                                    </svg>

                                    Home
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_entity'] == true">
                                <inertia-link :href="route('entities')"
                                    :class="[isUrl('entities') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('entities') ? 'text-white' : 'text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Entity
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_user'] == true">
                                <inertia-link :href="route('user')"
                                    :class="[isUrl('user') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('user') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    User
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_leave'] == true">
                                <inertia-link :href="route('leave')"
                                    :class="[isUrl('leave') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('leave') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    User
                                </inertia-link>

                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_setting'] == true">
                                <inertia-link :href="route('settings')"
                                    :class="[isUrl('settings') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('settings') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-width="2"
                                            d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                                    </svg>
                                    Settings
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_lead'] == true">
                                <inertia-link :href="route('lead')"
                                    :class="[isUrl('lead') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('lead') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    Lead
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_personnel'] == true">
                                <inertia-link :href="route('personnel')"
                                    :class="[isUrl('personnel') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('personnel') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Personnel
                                </inertia-link>
                            </div>
                            <!-- v-if="$page.props.auth.user.can['create_']==true" -->
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_invoice'] == true">
                                <inertia-link :href="route('invoice')"
                                    :class="[isUrl('invoice') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('invoice') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Invoice
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_patron'] == true">
                                <inertia-link :href="route('patron')"
                                    :class="[isUrl('patron') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('patron') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Customer
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_tax'] == true">
                                <inertia-link :href="route('tax')"
                                    :class="[isUrl('tax') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('tax') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                                    </svg>
                                    Tax
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_product'] == true">
                                <inertia-link :href="route('product')"
                                    :class="[isUrl('product') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('product') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Product
                                </inertia-link>
                            </div>
                            <!--                        <div class="mb-4" v-if="$page.props.auth.user.can['menu_account']==true">-->
                            <!--                            <inertia-link :href="route('accounts')" :class="[isUrl('accounts') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">-->
                            <!--                                <svg xmlns="http://www.w3.org/2000/svg" :class="[isUrl('accounts') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">-->
                            <!--                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />-->
                            <!--                                </svg>-->
                            <!--                                Account-->
                            <!--                            </inertia-link>-->
                            <!--                        </div>-->
                           
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_accounts'] == true">
                                <inertia-link :href="route('accounts.index')"
                                    :class="[isUrl('accounts') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('accounts') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    Account
                                </inertia-link>
                            </div>

                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_accountType'] == true">
                                <inertia-link :href="route('accountType.index')"
                                    :class="[isUrl('accountType') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('accountType') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    Account Type
                                </inertia-link>
                            </div>

                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_ledger'] == true">
                                <inertia-link :href="route('ledger.index')"
                                    :class="[isUrl('ledger') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('ledger') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    Ledger
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_payment'] == true">
                                <inertia-link :href="route('payment.index')"
                                    :class="[isUrl('payment') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('payment') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                    </svg>

                                    Payment
                                </inertia-link>
                            </div>
                            <!--                        <div class="mb-4" v-if="$page.props.auth.user.can['menu_journal']==true">-->
                            <!--                            <inertia-link :href="route('journals.index')" :class="[isUrl('accounts') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">-->
                            <!--                                <svg xmlns="http://www.w3.org/2000/svg" :class="[isUrl('accounts') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">-->
                            <!--                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />-->
                            <!--                                </svg>-->
                            <!--                                Journal Entries-->
                            <!--                            </inertia-link>-->
                            <!--                        </div>-->
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_expense'] == true">
                                <inertia-link :href="route('expense.index')"
                                    :class="[isUrl('expense') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('expense') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    Expense
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_defaultSetting'] == true">
                                <inertia-link :href="route('defaultSetting.index')"
                                    :class="[isUrl('defaultSetting') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('defaultSetting') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    Default Setting
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_report'] == true">
                                <inertia-link :href="route('report.index')"
                                    :class="[isUrl('report') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        :class="[isUrl('report') ? 'text-white' : ' text-white group-hover:text-white', 'mr-3 flex-shrink-0 h-6 w-6']"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    Report
                                </inertia-link>
                            </div>
                            <div class="mb-4" v-if="$page.props.auth.user.can['menu_support'] == true">
                                <inertia-link :href="route('support.index')"
                                    :class="[isUrl('support') ? 'bg-active text-white' : 'text-white hover:bg-active hover:bg-opacity-75 hover:text-white', 'group flex items-center px-2 py-2 text-md font-medium rounded-md']">
                                    <SupportIcon />
                                    Support Ticket
                                </inertia-link>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="flex-shrink-0  border-t bg-white p-2">
                    <img class="ml-4 " width="150" height="" src="/assets/modocrm_logo.png" alt="" />
                </div>
            </div>
        </div>
        <div class="lg:pl-64 flex flex-col">
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button type="button"
                    class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white lg:hidden"
                    @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <MenuAlt2Icon class="h-6 w-6" aria-hidden="true" />
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <div v-for="(entitydatas) in entitydata" :key="entitydatas.id"
                            class="relative w-full mt-5 sm:text-md md:text-lg  font-medium uppercase focus-within:text-gray-600 text-gray-600">
                            {{ entitydatas.legal_name }}
                        </div>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <Menu as="div" class="ml-3 relative">
                            <div>
                                <MenuButton
                                    class="max-w-xs bg-white flex items-center text-md rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="/assets/profile.png" />
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <MenuItems
                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-2 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">

                                    <div class="px-4 py-3 text-sm text-gray-700 font-sans border-b">
                                        {{ $page.props.auth.user.roles?.[0] ?? 'No Role' }}
                                    </div>
                                    <hr>
                                    <div class="py-1">
                                        <form @submit.prevent="logout" class=" hover:bg-indigo-200 text-gray-500">
                                            <button type="submit"
                                                class="flex items-center w-full px-4 py-3 text-sm text-gray-700 text-left transition hover:bg-cyan-200 focus:bg-cyan-100 focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                                                </svg>
                                                <span class="ml-3 text-gray-700 text-sm font-medium">Log Out</span>
                                            </button>
                                        </form>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import {
    Dialog,
    DialogOverlay,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    BellIcon,
    CalendarIcon,
    ChartBarIcon,
    FolderIcon,
    HomeIcon,
    InboxIcon,
    MenuAlt2Icon,
    UsersIcon,
    ViewListIcon,
    ClockIcon,
    CollectionIcon,
    XIcon,
} from '@heroicons/vue/outline'
import { SearchIcon } from '@heroicons/vue/solid'
import SupportIcon from "@/Pages/SupportTicket/Svg.vue";


import JetDropdownLink from '@/Jetstream/DropdownLink.vue'

const userNavigation = [
    { name: 'Your Profile', href: '#' },
    { name: 'settingss', href: '#' },
]
export default {
    components: {
        Dialog,
        DialogOverlay,
        SupportIcon,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        TransitionChild,
        TransitionRoot,
        BellIcon,
        MenuAlt2Icon,
        SearchIcon,
        XIcon,
        JetDropdownLink,
        // component
    },
    setup() {
        const sidebarOpen = ref(false)

        return {
            // navigation,
            userNavigation,
            sidebarOpen,
        }
    },
    data() {
        return {
            entitydata: []
        }
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)
            console.log(currentUrl, ...urls);
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.includes(currentUrl) || urls.some(url => currentUrl.startsWith(url))

        },
        enitydata() {
            axios.get(this.route('entitydata'))
                .then(response => {
                    this.entitydata = response.data
                    // console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        showImage() {
            this.img = '/storage/';
            return this.img;
        },
    },
    mounted() {
        this.enitydata();
    }
}

</script>
<style></style>
