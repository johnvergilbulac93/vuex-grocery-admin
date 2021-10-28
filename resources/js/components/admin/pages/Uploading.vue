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
                        >Upload New Item and New Price</label
                    >
                </div>

                <div class="w-full flex flex-wrap">
                    <div class=" w-full lg:w-1/2 ">
                        <div class=" p-2">
                            <div class="relative rounded">
                                <div
                                    class="absolute inset-0 bg-white p-5 text-center"
                                    v-if="loading"
                                >
                                    <div
                                        class="flex flex-col items-center justify-between space-y-4"
                                    >
                                        <label for="" class="mt-3 "
                                            >Please be patient, the file is
                                            being uploaded. Details about the
                                            upload are not available.</label
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
                                        v-if="errors.file_item"
                                    >
                                        <small class="text-white text-sm ">
                                            {{ errors.file_item[0] }}
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
                                        >Uploading for new item</span
                                    >
                                    <small>(Click here to select file)</small>
                                    <input
                                        type="file"
                                        id="file_new_item"
                                        ref="file_new_item"
                                        class="hidden"
                                        @change="handleFileNewItem"
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
                                    v-if="filenameNewItem"
                                    class="flex justify-between items-center mt-2 bg-white p-2 border border-gray-400 border-opacity-30 shadow-lg "
                                >
                                    <label for="" class="text-green-500 "
                                        >{{ filenameNewItem }}
                                        <span
                                            ><a
                                                v-if="!loading"
                                                @click="
                                                    cancel_selected_file_new_item
                                                "
                                                class="underline "
                                                >remove file</a
                                            ></span
                                        >
                                    </label>
                                    <div class=" text-white font-bold text-sm ">
                                        <button
                                            @click="
                                                upload_selected_file_new_item
                                            "
                                            class="bg-green-500 px-2 py-1 w-20 focus:outline-none hover:bg-green-600 transition duration-300 rounded "
                                        >
                                            Upload
                                        </button>
                                        <button
                                            @click="cancelRequest"
                                            class="bg-red-500 px-2 py-1 w-20 focus:outline-none hover:bg-red-600 transition duration-300  rounded"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>
                    <div class=" w-full lg:w-1/2 ">
                        <div class="p-2">
                            <div class="relative  rounded">
                                <div
                                    class="absolute inset-0 bg-white p-5 text-center"
                                    v-if="loading2"
                                >
                                    <div
                                        class="flex flex-col items-center justify-between space-y-4"
                                    >
                                        <label for="" class="mt-3"
                                            >Please be patient, the file is
                                            being uploaded. Details about the
                                            upload are not available.</label
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
                                        v-if="errors.file_price"
                                    >
                                        <small class="text-white text-sm ">
                                            {{ errors.file_price[0] }}
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
                                        >Uploading for price update</span
                                    >
                                    <small>(Click here to select file)</small>
                                    <input
                                        type="file"
                                        id="file_price_update"
                                        ref="file_price_update"
                                        class="hidden"
                                        @change="handleFilePriceUpdate"
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
                                    v-if="filenamePriceUpdate"
                                    class="flex justify-between items-center mt-2 bg-white p-2 border border-gray-400 border-opacity-30 shadow-lg "
                                >
                                    <label for="" class="text-green-500 "
                                        >{{ filenamePriceUpdate }}
                                        <span
                                            ><a
                                                v-if="!loading2"
                                                @click="
                                                    cancel_selected_file_price_update
                                                "
                                                class="underline "
                                                >remove file</a
                                            ></span
                                        >
                                    </label>
                                    <div class=" text-white font-bold text-sm ">
                                        <button
                                            @click="
                                                upload_selected_file_price_update
                                            "
                                            class="bg-green-500 px-2 py-1 w-20 focus:outline-none hover:bg-green-600 transition duration-300 rounded "
                                        >
                                            Upload
                                        </button>
                                        <button
                                            @click="cancelRequest"
                                            class="bg-red-500 px-2 py-1 w-20 focus:outline-none hover:bg-red-600 transition duration-300 rounded "
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
    </div>
</template>

<script>
import Upload from "../../../services/Uploading";
import { mapState, mapMutations } from "vuex";
import { LoopingRhombusesSpinner } from "epic-spinners";
import axios from "axios";
import NProgress from "nprogress";

export default {
    components: { LoopingRhombusesSpinner },
    data() {
        return {
            loading: false,
            loading2: false,
            fileNewItem: "",
            filePriceUpdate: "",
            filenameNewItem: "",
            filenamePriceUpdate: "",
            open: false,
            open2: false,
            request: null
        };
    },
    computed: {
        ...mapState(["errors", "UploadingMenu"])
    },
    methods: {
        ...mapMutations(["SET_ERRORS", "CLEAR_ERRORS"]),
        exitImage() {
            this.open = false;
            this.open2 = false;
        },
        clearErrorMessage() {
            this.errors.file_item = "";
            this.errors.file_price = "";
        },
        upload_selected_file_new_item() {
            let formData = new FormData();
            formData.append("file_item", this.fileNewItem);
            this.loading = true;

            let axiosSource = axios.CancelToken.source();
            this.request = { cancel: axiosSource.cancel };

            Upload.upload_new_item(formData, axiosSource)
                .then(() => {
                    this.filenameNewItem = "";
                    this.fileNewItem = "";
                    this.loading = false;
                    swal.fire(
                        "Hoooray!",
                        "Uploaded successfully.",
                        "success"
                    );
                })
                .catch(error => {
                    this.loading = false;
                    NProgress.done();
                    if (error.response.status === 422) {
                        this.SET_ERRORS(error.response.data.errors);
                        setTimeout(() => {
                            this.CLEAR_ERRORS();
                        }, 5000);
                    }
                });
        },
        cancel_selected_file_new_item() {
            this.filenameNewItem = "";
            this.fileNewItem = "";
            this.errors.file_item = "";
        },
        upload_selected_file_price_update() {
            let formData = new FormData();
            formData.append("file_price", this.filePriceUpdate);
            this.loading2 = true;

            let axiosSource = axios.CancelToken.source();
            this.request = { cancel: axiosSource.cancel };

            Upload.upload_price_update(formData, axiosSource)
                .then(() => {
                    this.filenamePriceUpdate = "";
                    this.filePriceUpdate = "";
                    this.loading2 = false;
                    swal.fire(
                        "Hoooray!",
                        "Uploaded successfully.",
                        "success"
                    );
                })
                .catch(error => {
                    this.loading2 = false;
                    NProgress.done();
                    if (error.response.status === 422) {
                        this.SET_ERRORS(error.response.data.errors);
                        setTimeout(() => {
                            this.CLEAR_ERRORS();
                        }, 5000);
                    }
                });
        },
        cancelRequest() {
            if (this.request) {
                this.request.cancel("File upload has been cancelled.");
                this.loading2 = false;
            }
        },
        cancel_selected_file_price_update() {
            this.filenamePriceUpdate = "";
            this.filePriceUpdate = "";
            this.errors.file_price = "";
        },
        handleFilePriceUpdate() {
            this.filePriceUpdate = this.$refs.file_price_update.files[0];
            this.filenamePriceUpdate = this.$refs.file_price_update.files[0].name;
            this.errors.file_price = "";
        },
        handleFileNewItem() {
            this.fileNewItem = this.$refs.file_new_item.files[0];
            this.filenameNewItem = this.$refs.file_new_item.files[0].name;
            this.errors.file_item = "";
        }
    }
};
</script>
