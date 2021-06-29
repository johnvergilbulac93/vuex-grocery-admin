<template>
    <div class="container text-gray-800">
        <div class=" bg-gray-50 shadow-lg p-5 rounded">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="tracking-wide text-lg ">
                    Exporting</label
                >
            </div>
            <div class="flex flex-col justify-center items-center space-y-4">
                <span class="uppercase font-mono ">This page is under maintainance</span>
                <img :src="$root.path + 'bug_fixing.svg'" class="h-80" />
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "Export",
    created() {},
    data() {
        return {};
    },
    props: {},
    methods: {}
};
</script>
