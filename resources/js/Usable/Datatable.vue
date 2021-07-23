<template>
    <div class="mx-auto">
        <table class="min-w-full divide-y divide-gray-300">
            <thead
                class="border-t-2 border-gray-300 bg-gray-100 tracking-normal"
            >
                <tr class="tracking-wide">
                    <th
                        v-for="column in columns"
                        :key="column.name"
                        @click="$emit('sort', column.name)"
                        class="p-2"
                        :class="[sortKey === column.name ? sortOrders[column.name] > 0
                                    ? 'sorting_up'
                                    : 'sorting_down'
                                    : 'sorting_both', column.class ]
                        "
                        style="cursor:pointer;"
                    >
                        {{ column.label }}

                    </th>
                </tr>
            </thead>
            <slot></slot>
        </table>
    </div>
</template>

<script>
export default {
    props: ["columns", "sortKey", "sortOrders"]
};
</script>
