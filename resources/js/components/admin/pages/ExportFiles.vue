<template>
    <div class="container">
        <div class=" bg-gray-50 shadow-lg p-5 rounded">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="text-gray-500 text-lg font-semibold">
                    Exporting</label
                >
            </div>
            <div class="flex flex-col justify-center items-center space-y-4">
                <span class="uppercase font-mono font-semibold">This page is under maintainance</span>
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
