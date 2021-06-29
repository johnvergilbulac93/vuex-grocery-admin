<template>
    <div class=" bg-gray-50 shadow-lg p-5 rounded w-1/2 ">
        <div class="flex flex-wrap  ">
            <div class="w-full h-96  overflow-y-scroll scrollbar" id="style-4">
                <ul class="text-gray-800">
                    <li>
                        <h5
                            class="flex items-center space-x-10 uppercase font-semibold tracking-wider px-1 py-2"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            SETUP
                        </h5>
                        <ul>
                            <li class="li ">
                                <router-link
                                    :to="{
                                        name: 'business_rule',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Business Rules
                                    </span>
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'bu_time',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Store Time</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'tenant',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider">Tenant</span>
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'delivery_charges',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Delivery Charges</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'minimum_delivery',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Minimum Order Delivery</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'users',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Manage Users</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'price_group'
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Price Group</span
                                    >
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="mt-8">
                        <h5
                            class="flex items-center space-x-10 uppercase   font-semibold tracking-wider px-1 py-2"
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
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                            Item
                        </h5>
                        <ul>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'central_item',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Item Masterfile</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'disable_uom',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Disable Item Unit of Measure(UOM)</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'enable_uom',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Enable Item Unit of Measure(UOM)</span
                                    >
                                </router-link>
                            </li>
                            <!-- <li class="li">
                                <router-link
                                    :to="{
                                        name: 'count',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-700 hover:text-gray-900"
                                >
                                    <span class="tracking-wider"
                                        >Available Item Count per Store</span
                                    >
                                </router-link>
                            </li> -->
                        </ul>
                    </li>
                    <li class="mt-8">
                        <h5
                            class="flex items-center space-x-10 uppercase  font-semibold tracking-wider px-1 py-2"
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
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                />
                            </svg>

                            Uploading
                        </h5>
                        <ul>
                            <li class="li ">
                                <router-link
                                    :to="{
                                        name: 'uploading',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Upload New Item and New Price</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'setting',
                                        params: { id: $root.userType }
                                    }"
                                    class="text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Upload Image filename and
                                        Category</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'multiple',
                                        params: { id: $root.userType }
                                    }"
                                    class=" text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Upload Multiple Images</span
                                    >
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="mt-8">
                        <h5
                            class="flex items-center space-x-10 uppercase text-gray-800 font-semibold tracking-wider px-1 py-2"
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
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>

                            Reports
                        </h5>
                        <ul>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'report_item',
                                        params: { id: $root.userType }
                                    }"
                                    class=" text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Item Report</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'liquidition',
                                        params: { id: $root.userType }
                                    }"
                                    class=" text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Liquidation Report</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'accountability',
                                        params: { id: $root.userType }
                                    }"
                                    class=" text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Accountability Report</span
                                    >
                                </router-link>
                            </li>
                            <li class="li">
                                <router-link
                                    :to="{
                                        name: 'transaction',
                                        params: { id: $root.userType }
                                    }"
                                    class=" text-gray-800 hover:text-black"
                                >
                                    <span class="tracking-wider"
                                        >Total Order Report - REMITTED
                                    </span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- <div class="w-3/5">
                <img
                    :src="$root.path + 'AlturushDeliveryLogoGradient.png'"
                    alt="alts"
                    class="h-96 w-full object-contain"
                />
            </div> -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    }
};
</script>
