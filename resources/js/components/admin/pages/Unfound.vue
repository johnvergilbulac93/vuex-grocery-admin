<template>
    <div class="bg-gray-100 w-full mt-2 p-3">
        <div class="flex justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <div class="w-60">
                    <label class="block ">Store</label>
                    <select class="form" v-model="filter.store">
                        <option value="">Choose Store</option>
                        <option
                            :value="store.bunit_code"
                            v-for="(store, i) in stores"
                            :key="i"
                            >{{ store.business_unit }}</option
                        >
                    </select>
                </div>

                <div class="w-56">
                    <label>Date From</label>
                    <input type="date" class="form" v-model="filter.dateFrom" />
                </div>
                <div class="w-56">
                    <label>Date To</label>
                    <input type="date" class="form" v-model="filter.dateTo" />
                </div>
            </div>
            <div class="flex items-center gap-1">
                <button
                    class="bg-blue-500 text-white px-3 py-2 rounded focus:outline-none focus:bg-blue-600 flex gap-1 items-center"
                    @click="fetch"
                >
                    Generate
                </button>
                <button
                    class="bg-green-500 text-white px-3 py-2 rounded focus:outline-none focus:bg-green-600 flex gap-1 items-center disabled:opacity-50"
                    v-if="Unfounds.b_unit != null"
                    @click="exportToExcel('xlsx')"
                    :disabled="!Unfounds.data.length"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                    <span>Excel</span>
                </button>
                <button
                    class="bg-green-500 text-white px-3 py-2 rounded focus:outline-none focus:bg-green-600 flex gap-1 items-center disabled:opacity-50"
                    v-if="Unfounds.b_unit != null"
                    @click="printBtn"
                    :disabled="!Unfounds.data.length"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                        />
                    </svg>
                    <span>Print</span>
                </button>
            </div>
        </div>
        <hr class="mt-2" />
        <div class="mt-2" id="print_this">
            <section v-if="Unfounds.b_unit != null">
                <div class="flex justify-center items-center mb-2">
                    <center>
                        <img
                            class="text-center items-center h-36"
                            :src="$root.logo_path + '' + Unfounds.b_unit.logo"
                        />
                        <h2 class="text-xl ">ALTURUSH GOODS ORDERING</h2>
                        <h2 class="text-lg">Comments & Suggestions</h2>
                        <h2 class="text-xs">{{ filter.dateFrom | formatDateNoTime }} to {{ filter.dateTo | formatDateNoTime }}</h2>
                    </center>
                </div>
                <table
                    class="min-w-full divide-y divide-gray-300"
                    id="unfound-items"
                >
                    <thead class="border bg-gray-100 tracking-normal">
                        <tr class="tracking-wide">
                            <th class="p-3 border text-left  bg-gray-200 w-44">
                                Ticket No.
                            </th>
                            <th class="p-3 border text-left  bg-gray-200 w-64">
                                Customer Name
                            </th>
                            <th class="p-3 border text-left  bg-gray-200 w-44">
                                Order From
                            </th>
                            <th class="p-3 border text-left  bg-gray-200 w-44">
                                Mode of Order
                            </th>
                            <th class="p-3 border text-left  bg-gray-200">
                                Remarks
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr class="tr" v-if="!Unfounds.data.length">
                            <td class="td text-center" colspan="5">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            v-for="(unfound, i) in Unfounds.data"
                            :key="i"
                            class="tr"
                        >
                            <td class="td">{{ unfound.ticket }}</td>
                            <td class="td">{{ unfound.customer }}</td>
                            <td class="td">{{ unfound.source }}</td>
                            <td class="td">
                                {{
                                    unfound.mode_of_order == 1
                                        ? "Pick-up"
                                        : "Delivery"
                                }}
                            </td>
                            <td class="td">
                                <li class="list-disc">{{ unfound.remarks }}</li>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <small class="text-xs flex justify-end mt-2"
                    >Run Time: {{ filter.dateNow }}</small
                >
            </section>
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";

export default {
    props: ["stores"],
    data() {
        return {
            filter: {
                store: "",
                dateFrom: "",
                dateTo: "",
                dateNow: ""
            }
        };
    },
    computed: {
        ...mapState(["Unfounds"])
    },
    methods: {
        ...mapActions(["getUnfound"]),
        ...mapMutations(["CLEAR_UNFOUNDS"]),
        fetch() {
            let filter = {
                store: this.filter.store,
                start: this.filter.dateFrom,
                end: this.filter.dateTo
            };
            this.getUnfound({ filter });
        },
        printBtn() {
            window.print();
        },
        exportToExcel(type, fn, dl) {
            const xlsName =
                "COMMENTS-AND-SUGGESTIONS-" +
                this.Unfounds.b_unit.business_unit +
                ".";
            const elt = document.getElementById("unfound-items");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "COMMENTS & SUGGESTIONS"
            });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
        }
    },
    mounted() {
        this.filter.dateFrom = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.dateTo = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    },
    destroyed() {
        this.CLEAR_UNFOUNDS();
    }
};
</script>
