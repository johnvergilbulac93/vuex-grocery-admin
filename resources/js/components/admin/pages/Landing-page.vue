<template>
    <div class="bg-gray-50 shadow-lg p-5 rounded h-96 text-black" >
        <div class="flex  justify-center items-center ">
            <center class="mt-28 ">
                <h1 class=" text-6xl  ">Welcome Back</h1>
                <h1 class="text-lg  mt-5">{{ name }}</h1>
                <h4 class="text-sm  mt-5">
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
