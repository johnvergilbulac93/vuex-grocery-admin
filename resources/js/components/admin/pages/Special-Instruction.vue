<template>
    <div class="bg-gray-100  w-full mt-2 p-3">
        <div class="flex justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <div class="w-60">
                    <label class="block ">Store</label>
                    <select class="form" @change="fetch" v-model="filter.store">
                        <option value="">Choose Store</option>
                        <option
                            :value="store.bunit_code"
                            v-for="(store, i) in stores"
                            :key="i"
                            >{{ store.business_unit }}</option
                        >
                    </select>
                </div>
            </div>
            <div
                class="flex items-center gap-2"
                v-if="Instructions.b_unit != null"
            >
                <button
                    class="bg-green-500 text-white px-3 py-2 rounded focus:outline-none focus:bg-green-600 flex gap-1 items-center"
                    @click="exportToExcel('xlsx')"
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
                    class="bg-green-500 text-white px-3 py-2 rounded focus:outline-none focus:bg-green-600 flex gap-1 items-center"
                    @click="printBtn"
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
            <section v-if="Instructions.b_unit != null">
                <div class="flex justify-center items-center mb-2">
                    <center>
                        <h6 class="text-lg ">
                            {{
                                Instructions.hasOwnProperty("b_unit") &&
                                    Instructions.b_unit.business_unit
                            }}
                        </h6>
                        <p>ALTURUSH GOODS ORDERING</p>
                        <p>SPECIAL INSTRUCTION REPORT</p>
                    </center>
                </div>
                <table
                    class="min-w-full divide-y divide-gray-300"
                    id="instruction"
                >
                    <thead class="border bg-gray-100 tracking-normal">
                        <tr class="tracking-wide">
                            <th
                                class="p-3 border text-left text-lg bg-gray-200"
                            >
                                Remarks
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr class="tr" v-if="!Instructions.data.length">
                            <td class="td">NO REMARKS FOUND</td>
                        </tr>
                        <tr
                            v-for="(instruction, i) in Instructions.data"
                            :key="i"
                            class="tr"
                        >
                            <td class="td">
                                <li class="list-disc">
                                    {{ instruction.remarks }}
                                </li>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                store: ""
            }
        };
    },
    computed: {
        ...mapState(["Instructions"])
    },
    methods: {
        ...mapActions(["getInstruction"]),
        ...mapMutations(["CLEAR_INSTRUCTION"]),
        fetch() {
            let filter = {
                store: this.filter.store
            };
            this.getInstruction({ filter });
        },
        printBtn() {
            window.print();
        },
        exportToExcel(type, fn, dl) {
            const xlsName =
                "SPECIAL-INSTRUCTION-" + this.Instructions.b_unit.business_unit + ".";
            const elt = document.getElementById("instruction");
            const wb = XLSX.utils.table_to_book(elt, { sheet: "REMARKS" });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
        }
    },
    destroyed() {
        this.CLEAR_INSTRUCTION();
    }
};
</script>
