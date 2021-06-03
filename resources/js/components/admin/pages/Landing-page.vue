<template>
    <div class="bg-gray-50 shadow-lg p-5 rounded h-96">
        <div class="flex  justify-center items-center ">
            <center class="mt-28">
                <h1 class="text-gray-500 text-6xl font-semibold ">WELCOME BACK</h1>
                <h1 class="text-lg font-semibold text-gray-500 mt-5">{{ name }}</h1>
                <h4 class="text-xs font-semibold text-gray-500 mt-5">
                   &copy; Alturush | Grocery-Admin
                </h4>
            </center>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: null
        };
    },
    mounted() {
        this.name = $("meta[name=name]").attr("content");
    }
};
</script>
