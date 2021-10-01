<template>
    <div class="space-y-2">
        <Breadcrumb
            :routes="UploadingMenu"
            title="uploading"
            v-if="$root.userType == 12"
        />
        <div class=" text-black">
            <div class=" bg-gray-50 shadow-lg p-2 rounded">
                <div class="mb-2 bg-gray-100 p-2">
                    <label for="" class="font-semibold text-lg "
                        >Upload Image filename and Category</label
                    >
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class=" p-2">
                        <div class="relative  rounded">
                            <div
                                class="absolute inset-0 bg-white p-5 text-center"
                                v-if="loading"
                            >
                                <div
                                    class="flex flex-col items-center justify-between space-y-4"
                                >
                                    <label for="" class="mt-3  "
                                        >Please be patient, the file is being
                                        uploaded. Details about the upload are
                                        not available.</label
                                    >
                                    <LoopingRhombusesSpinner
                                        :animation-duration="2500"
                                        :rhombus-size="20"
                                        color="#ff1d5e"
                                    />
                                </div>
                            </div>
                            <transition
                                enter-active-class="ease-out duration-500"
                                enter-class="opacity-0"
                                enter-to-class="opacity-100"
                                leave-active-class="ease-in duration-500"
                                leave-class="opacity-100"
                                leave-to-class="opacity-0"
                            >
                                <div
                                    class="mb-1 rounded bg-red-500 bg-opacity-75 px-2 py-1 flex justify-between items-center  hover:bg-red-600 transition duration-500"
                                    v-if="errors.file_category"
                                >
                                    <small class="text-white text-sm ">
                                        {{ errors.file_category[0] }}
                                    </small>
                                    <button
                                        class="focus:outline-none text-white"
                                        @click="clearErrorMessage"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </transition>
                            <label
                                class="flex flex-col items-center px-4 py-5 border bg-white uppercase  cursor-pointer hover:text-yellow-500 hover:border-yellow-500 transistion duration-500"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10"
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
                                <span class="mt-2 "
                                    >Uploading for item category</span
                                >
                                <small>(Click here to select file)</small>
                                <input
                                    type="file"
                                    id="file_category"
                                    ref="file_category"
                                    class="hidden"
                                    @change="handleFileCategory"
                                />
                            </label>
                        </div>
                        <transition
                            enter-active-class="ease-out duration-500"
                            enter-class="opacity-0"
                            enter-to-class="opacity-100"
                            leave-active-class="ease-in duration-500"
                            leave-class="opacity-100"
                            leave-to-class="opacity-0"
                        >
                            <div
                                v-if="filenameCategory"
                                class="flex justify-between items-center mt-2 bg-white p-2 border border-gray-400 border-opacity-30 shadow-lg "
                            >
                                <label
                                    for=""
                                    class="text-green-500 font-bold text-xs"
                                    >{{ filenameCategory }}</label
                                >
                                <div class=" text-white font-bold text-sm ">
                                    <button
                                        @click="upload_selected_file_category"
                                        class="bg-green-500 px-2 py-1 w-20 focus:outline-none hover:bg-green-600 transition duration-300 rounded "
                                    >
                                        Upload
                                    </button>
                                    <button
                                        @click="cancel_selected_file_category"
                                        class="bg-red-500 px-2 py-1 w-20 focus:outline-none hover:bg-red-600 transition duration-300 rounded"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </transition>
                    </div>
                    <div class="p-2">
                        <div class="relative rounded">
                            <div
                                class="absolute inset-0 bg-white p-5 text-center"
                                v-if="loading2"
                            >
                                <div
                                    class="flex flex-col items-center justify-between space-y-4"
                                >
                                    <label for="" class="mt-3  "
                                        >Please be patient, the file is being
                                        uploaded. Details about the upload are
                                        not available.</label
                                    >
                                    <LoopingRhombusesSpinner
                                        :animation-duration="2500"
                                        :rhombus-size="20"
                                        color="#ff1d5e"
                                    />
                                </div>
                            </div>
                            <transition
                                enter-active-class="ease-out duration-500"
                                enter-class="opacity-0"
                                enter-to-class="opacity-100"
                                leave-active-class="ease-in duration-500"
                                leave-class="opacity-100"
                                leave-to-class="opacity-0"
                            >
                                <div
                                    class="mb-1 rounded bg-red-500 bg-opacity-75 px-2 py-1 flex justify-between items-center  hover:bg-red-600 transition duration-500"
                                    v-if="errors.image_filename"
                                >
                                    <small class="text-white text-sm ">
                                        {{ errors.image_filename[0] }}
                                    </small>
                                    <button
                                        class="focus:outline-none text-white"
                                        @click="clearErrorMessage"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </transition>
                            <label
                                class="flex flex-col items-center px-4 py-5 border bg-white  uppercase  cursor-pointer hover:text-yellow-500 hover:border-yellow-500 transistion duration-500"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10"
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
                                <span class="mt-2 "
                                    >Uploading for image filename</span
                                >
                                <small>(Click here to select file)</small>
                                <input
                                    type="file"
                                    id="image_filename"
                                    ref="image_filename"
                                    class="hidden"
                                    @change="handleFileImageName"
                                />
                            </label>
                        </div>
                        <transition
                            enter-active-class="ease-out duration-500"
                            enter-class="opacity-0"
                            enter-to-class="opacity-100"
                            leave-active-class="ease-in duration-500"
                            leave-class="opacity-100"
                            leave-to-class="opacity-0"
                        >
                            <div
                                v-if="filenameImageName"
                                class="flex justify-between items-center mt-2 bg-white p-2 border border-gray-400 border-opacity-30 shadow-lg "
                            >
                                <label
                                    for=""
                                    class="text-green-500 font-bold text-xs whitespace-pre-wrap"
                                    >{{ filenameImageName }}</label
                                >
                                <div class=" text-white font-bold text-sm ">
                                    <button
                                        @click="upload_selected_file_image_name"
                                        class="bg-green-500 px-2 py-1 w-20 focus:outline-none hover:bg-green-600 transition duration-300 rounded "
                                    >
                                        Upload
                                    </button>
                                    <button
                                        @click="cancel_selected_file_image_name"
                                        class="bg-red-500 px-2 py-1 w-20 focus:outline-none hover:bg-red-600 transition duration-300 rounded"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Upload from "../../../services/Uploading";
import { mapState, mapMutations } from "vuex";
import { LoopingRhombusesSpinner } from "epic-spinners";

export default {
    components: { LoopingRhombusesSpinner },
    data() {
        return {
            loading: false,
            loading2: false,
            fileCategory: "",
            fileImageName: "",
            filenameCategory: "",
            filenameImageName: ""
        };
    },
    computed: {
        ...mapState(["errors", "UploadingMenu"])
    },
    methods: {
        ...mapMutations(["SET_ERRORS", "CLEAR_ERRORS"]),

        clearErrorMessage() {
            this.errors.file_category = "";
            this.errors.image_filename = "";
        },
        handleFileImageName() {
            this.fileImageName = this.$refs.image_filename.files[0];
            this.filenameImageName = this.$refs.image_filename.files[0].name;
            this.errors.image_filename = "";
        },
        upload_selected_file_image_name() {
            let formData = new FormData();
            formData.append("image_filename", this.fileImageName);
            this.loading2 = true;
            Upload.upload_image_filename(formData)
                .then(() => {
                    this.filenameImageName = "";
                    this.loading2 = false;
                })
                .catch(error => {
                    this.loading2 = false;
                    if (error.response.status === 422) {
                        this.SET_ERRORS(error.response.data.errors);
                        setTimeout(() => {
                            this.CLEAR_ERRORS();
                        }, 5000);
                    }
                });
        },
        cancel_selected_file_image_name() {
            this.filenameImageName = "";
            this.errors.image_filename = "";
        },
        handleFileCategory() {
            this.fileCategory = this.$refs.file_category.files[0];
            this.filenameCategory = this.$refs.file_category.files[0].name;
            this.errors.file_category = "";
        },
        upload_selected_file_category() {
            let formData = new FormData();
            formData.append("file_category", this.fileCategory);
            this.loading = true;
            Upload.upload_category(formData)
                .then(() => {
                    this.filenameCategory = "";
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    if (error.response.status === 422) {
                        this.SET_ERRORS(error.response.data.errors);
                        setTimeout(() => {
                            this.CLEAR_ERRORS();
                        }, 5000);
                    }
                });
        },
        cancel_selected_file_category() {
            this.filenameCategory = "";
            this.errors.file_category = "";
        }
    }
};
</script>
