<template>
    <div class="mx-auto">
        <table class="min-w-full">
            <thead
                class="border bg-gray-100 tracking-normal"
            >
                <tr class="tracking-wide">
                    <th
                        v-for="column in columns"
                        :key="column.name"
                        @click="$emit('sort', column.name)"
                        class="p-3 border"
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
