<template>
    <section class="flex items-center gap-4">
        <!-- <h1 v-text="message"></h1> -->
        <h1 v-text="currentTime"></h1>
    </section>
</template>

<script>
export default {
    data() {
        return {
            message: "Time:",
            currentTime: null
        };
    },
    methods: {
        updateCurrentTime() {
            this.currentTime = moment().format("LLLL");
        }
    },
    created() {
        this.currentTime = moment().format("LL");
        setInterval(() => this.updateCurrentTime(), 1 * 1000);
    }
};
</script>
