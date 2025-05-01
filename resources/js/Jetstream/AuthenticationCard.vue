<template>
    <div class=" flex flex-col sm:justify-center items-center sm:pt-0 " >
        <div>
            <slot name="logo" />
        </div>
        <div class="w-full sm:max-w-md py-4 px-4 overflow-hidden">
            <slot />
        </div>

    </div>

</template>

<style>
/* .back-color{
    background: url('/public/assets/crm.jpg');
    background-repeat: no-repeat;
  background-size: 1440px 500px;
} */
.shadow-xl {
	--tw-shadow: -2px 5px 39px 7px rgb(80 80 80 / 29%), 0px 10px 10px 0px rgb(244 140 240 / 5%);
	box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}
</style>
