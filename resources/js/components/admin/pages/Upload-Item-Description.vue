<template>
    <div class="space-y-2">
        <Breadcrumb
            :routes="routes"
            title="uploading"
            v-if="$root.userType == 12"
        />
        <div class="container bg-gray-50 shadow-lg p-5 rounded text-black">
            <div class="mb-5 bg-gray-100 p-2">
                <label for="" class="font-semibold text-lg "
                    >Update Item Description</label
                >
                <div class="w-full ">
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
                                <!-- <div
                                    class="mb-1 bg-red-500 bg-opacity-75 px-2 py-1 flex justify-between items-center  hover:bg-red-600 transition duration-500"
                                    v-if="errors.file_item"
                                >
                                    <small class="text-white text-sm ">
                                        {{ errors.file_item[0] }}
                                    </small>
                                    <button
                                        class="focus:outline-none"
                                    >
                                        <i
                                            class="fas fa-times text-gray-50 hover:text-white"
                                        ></i>
                                    </button>
                                </div> -->
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
                                    >Update item description</span
                                >
                                <small>(Click here to select file)</small>
                                <input
                                    type="file"
                                    id="update_item_desc"
                                    ref="update_item_desc"
                                    class="hidden"
                                    @change="handleFileOnchange"
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
                                v-if="filename"
                                class="flex justify-between items-center mt-2 bg-white p-2 border border-gray-400 border-opacity-30 shadow-lg "
                            >
                                <label for="" class="text-green-500 "
                                    >{{ filename }}
                                    <span
                                        ><a
                                            href="#"
                                            v-if="!loading"
                                            class="underline"
                                            @click="removeFile"
                                            >remove file</a
                                        ></span
                                    >
                                </label>
                                <div class=" text-white font-bold text-sm ">
                                    <button
                                        @click="uploadFile"
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
        let routes = [
            {
                label: "Upload New Item and Price Update",
                route: "/uploading"
            },
            {
                label: "Upload Image filename and Category",
                route: "/setting"
            },
            {
                label: "Upload Multiple Images",
                route: "/multiple"
            },
            {
                label: "Update Item Description",
                route: "/update_item_description"
            }
        ];
        return {
            routes: routes,
            loading: false,
            file: "",
            filename: "",
            open: false,
            request: null
        };
    },
    computed: {
        ...mapState(["errors"])
    },
    methods: {
        ...mapMutations(["SET_ERRORS"]),
        handleFileOnchange() {
            this.file = this.$refs.update_item_desc.files[0];
            this.filename = this.$refs.update_item_desc.files[0].name;
        },
        removeFile() {
            this.filename = "";
            this.file = "";
        },
        cancelRequest() {
            if (this.request) {
                this.request.cancel("File upload has been cancelled.");
                this.loading = false;
            }
        },
        uploadFile() {
            let formData = new FormData();
            formData.append("file", this.file);
            this.loading = true;

            let axiosSource = axios.CancelToken.source();
            this.request = { cancel: axiosSource.cancel };

            Upload.update_item_description(formData, axiosSource)
                .then(() => {
                    this.filename = "";
                    this.file = "";
                    this.loading = false;
                    toast.fire({
                        icon: "success",
                        title: "Success",
                        text: "Uploaded successfully"
                    });
                })
                .catch(error => {
                    this.loading = false;
                    NProgress.done();
                    if (error.response.status === 422) {
                        this.SET_ERRORS(error.response.data.errors);
                    }
                });
        }
    }
};
</script>
