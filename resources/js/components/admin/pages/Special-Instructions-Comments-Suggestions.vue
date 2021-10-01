<template>
    <div class="space-y-2">
        <Breadcrumb :routes="ReportMenu" title="Reports" />
        <div class=" text-gray-800">
            <div class=" bg-gray-50 shadow-lg p-2 rounded ">
                <div class="mb-2 bg-gray-100 p-2">
                    <label class="font-semibold text-lg"
                        >Special Instruction, Comments & Suggestions</label
                    >
                </div>
                <ul class="flex items-center text-base font-rubik ">
                    <li>
                        <a
                            href="#"
                            @click="unfoundTab"
                            class="px-3 py-2  text-gray-800 hover:text-yellow-500  transition duration-300 "
                            v-bind:class="
                                unfoundFlag
                                    ? '  border-b-4 border-yellow-500 '
                                    : ''
                            "
                            >Comments & Suggestions</a
                        >
                    </li>
                    <li>
                        <a
                            href="#"
                            @click="instructionTab"
                            class="px-3 py-2 text-gray-800 hover:text-yellow-500  transition duration-300 "
                            v-bind:class="
                                instructionFlag
                                    ? '  border-b-4 border-yellow-500'
                                    : ''
                            "
                            >Special Instruction</a
                        >
                    </li>
                </ul>
                <section>
                    <Instruction v-if="instructionFlag" :stores="Stores" />
                    <Unfound v-if="unfoundFlag" :stores="Stores" />
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import Instruction from "./Special-Instruction.vue";
import Unfound from "./Unfound.vue";
import { mapActions, mapState } from "vuex";

export default {
    name: "Special-Instruction-Unfound-Items",
    components: {
        Instruction,
        Unfound
    },
    data() {
        return {
            instructionFlag: false,
            unfoundFlag: true
        };
    },
    computed: {
        ...mapState(["Stores", "errors","ReportMenu"])
    },
    methods: {
        ...mapActions(["getStore"]),

        instructionTab() {
            this.instructionFlag = true;
            this.unfoundFlag = false;
        },
        unfoundTab() {
            this.instructionFlag = false;
            this.unfoundFlag = true;
        }
    },
    created() {
        this.getStore();
    }
};
</script>
