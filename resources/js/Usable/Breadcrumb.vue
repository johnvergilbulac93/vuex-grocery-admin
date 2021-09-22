<template>
    <div class="container bg-gray-50 shadow-lg p-2 font-inter sm:w-full overflow-x-auto">
        <div class="flex items-center  gap-4">
            <router-link to="/menu" class="flex items-center gap-4  text-black uppercase"
                ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
                    /></svg
            > <span>{{ title }} </span></router-link>
            <span class="text-black"> >> </span>
            <router-link
                :to="route.route"
                v-for="(route, i) in routes"
                :key="i"
                class="text-black  "
                v-bind:class="{ 'text-blue-500': $route.path === route.route }"
            >
                {{ route.label }} 
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    props: ["routes", "title"]
};
</script>
