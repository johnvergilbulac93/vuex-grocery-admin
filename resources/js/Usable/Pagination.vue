<template>
    <div class="flex justify-between items-center mt-2">
        <span class="text-sm"
            >Showing {{ !pagination.from ? 0 : pagination.from }} to
            {{ !pagination.to ? 0 : pagination.to }} of
            {{ pagination.total }} entries</span
        >
        <div class="flex flex-row space-x-1">
            <button
                :disabled="!pagination.prevPageUrl"
                @click="$emit('prev')"
                class="footer-btn flex items-center"
            >
                <svg
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
                        d="M15 19l-7-7 7-7"
                    /></svg
                >Prev
            </button>
            <button
                :disabled="!pagination.nextPageUrl"
                @click="$emit('next')"
                class="footer-btn flex items-center"
            >
                Next
                <svg
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
                        d="M9 5l7 7-7 7"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["pagination"]
};
</script>
