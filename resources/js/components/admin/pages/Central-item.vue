<template>
    <div class="space-y-2">
        <Breadcrumb :routes="ItemMenu" title="item" />
        <div class=" text-gray-800">
            <div class=" bg-gray-50 shadow-lg p-2 rounded overflow-x-auto">
                <div class="mb-2 bg-gray-100 p-2">
                    <label for="" class="text-lg font-semibold"
                        >Item Masterfile</label
                    >
                </div>
                <div
                    class="flex sm:flex-wrap sm:space-y-2 md:space-y-0 lg:justify-between sm:justify-start items-center mb-2"
                >
                    <div
                        class=" flex sm:flex-col lg:flex-row gap-1 items-center sm:space-y-2 md:space-y-2 lg:space-y-0 "
                    >
                        <div class="w-72 flex items-center gap-0.5">
                            <div class="relative w-full flex items-center  ">
                                <input
                                    type="text"
                                    class="form-search "
                                    placeholder="Search...."
                                    v-model="tableData.search"
                                    @keyup.enter="search"
                                />
                                <button
                                    @click="clear"
                                    v-if="tableData.search.length"
                                    class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded  flex items-center justify-center focus:outline-none "
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5  hover:text-red-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <button @click="search" class="button-search">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 "
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </button>
                        </div>
                        <div class=" w-72">
                            <select
                                class="form  "
                                v-model="tableData.category"
                                @change="fetch()"
                            >
                                <option value="">Filter by Category</option>
                                <option
                                    v-for="(category, index) in ItemCategory"
                                    :key="index"
                                    :value="category.category_name"
                                >
                                    {{ category.category_name }}
                                </option>
                            </select>
                        </div>
                        <div class="w-40">
                            <select
                                class="form "
                                v-model="tableData.price_group"
                                @change="fetch()"
                            >
                                <option value="">Choose Price Group</option>
                                <option value="TAGB">TAGBILARAN</option>
                                <option value="TALB">TALIBON</option>
                            </select>
                        </div>
                        <div class="w-48">
                            <select
                                class="form"
                                v-model="tableData.store"
                                @change="fetch()"
                            >
                                <option value="">Choose Store</option>
                                <option
                                    :value="store.bunit_code"
                                    v-for="(store, i) in Stores"
                                    :key="i"
                                    >{{ store.business_unit }}</option
                                >
                            </select>
                        </div>
                    </div>

                    <div class="text-sm">
                        <span>Show</span>
                        <select
                            class="form-sort "
                            v-model="tableData.length"
                            @change="fetch()"
                        >
                            <option
                                v-for="(records, index) in perPage"
                                :key="index"
                                :value="records"
                            >
                                {{ records }}
                            </option>
                        </select>
                        <span>Entries</span>
                    </div>
                </div>
                <Datatable
                    :columns="columns"
                    :sortKey="sortKey"
                    :sortOrders="sortOrders"
                    @sort="sortBy"
                >
                    <tbody class="tbody ">
                        <tr class="tr" v-if="!Items.length">
                            <td colspan="7" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(item, i) in Items" :key="i" class="tr">
                            <td class="td uppercase">{{ item.itemcode }}</td>
                            <td class="td ">
                                {{ item.product_name }}
                            </td>
                            <td class="td">{{ item.category_name }}</td>
                            <td class="text-center td">
                                <select
                                    v-if="item.item_price != 0"
                                    class="form"
                                    @change="getPrice($event, i)"
                                >
                                    <option
                                        v-for="(data, index) in item.item_price"
                                        :key="index"
                                        :value="data.price_with_vat"
                                    >
                                        {{ data.UOM }}
                                    </option>
                                </select>

                                <span v-else class="text-xs text-red-500">
                                    NO PRICE AVAILABLE</span
                                >
                            </td>
                            <td class="td text-center">
                                <span :id="`price-${i}`" class="text-blue-500 ">
                                    {{
                                        !item.item_price.length
                                            ? "0.00"
                                            : item.item_price[0].price_with_vat
                                              | toCurrency2
                                    }}</span
                                >
                            </td>
                            <td class="td text-center">
                                <a href="#" @click="changeStatus(item)">
                                    <span
                                        class=" px-2 py-1 rounded-full text-gray-50  text-xs  hover:text-white transition duration-500"
                                        :class="
                                            item.status === 'active'
                                                ? 'bg-green-400 hover:bg-green-500'
                                                : 'bg-red-500 hover:bg-red-600'
                                        "
                                    >
                                        {{
                                            item.status === "active"
                                                ? "Active"
                                                : "Inactive"
                                        }}</span
                                    >
                                </a>
                            </td>
                            <td class="td text-center">
                                <button
                                    @click="changeStatusPerStore(item)"
                                    class=" px-2 py-1 bg-red-500 rounded-full text-gray-50 focus:outline-none  text-xs  hover:text-white transition duration-500"
                                    :class="
                                        item.item_not_available === null
                                            ? 'bg-green-400 hover:bg-green-500'
                                            : 'bg-red-500 hover:bg-red-600'
                                    "
                                >
                                    {{
                                        item.item_not_available === null
                                            ? "Active"
                                            : "Inactive"
                                    }}
                                </button>
                            </td>
                            <td class="text-center td">
                                <button
                                    class="focus:outline-none"
                                    @click="showUpload(item)"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Upload image"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-700 hover:text-blue-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                                        />
                                    </svg>
                                </button>
                                <button
                                    class="focus:outline-none"
                                    @click="showImage(item)"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="View image"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-700 hover:text-blue-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </Datatable>
                <Pagination
                    :pagination="pagination"
                    @prev="previousPage(pagination.prevPageUrl)"
                    @next="nextPage(pagination.nextPageUrl)"
                />

                <transition
                    enter-active-class="ease-out duration-500"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-300"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-if="viewImage"
                        class="bg-black bg-opacity-40 fixed top-0 left-0 z-50 flex justify-center items-center w-full min-h-screen"
                        @click="closeDialog"
                    >
                        <transition
                            enter-active-class="ease-out duration-500"
                            enter-class="opacity-0"
                            enter-to-class="opacity-100"
                            leave-active-class="ease-in duration-300"
                            leave-class="opacity-100"
                            leave-to-class="opacity-0"
                        >
                            <div v-if="!loadingImage" class="transition duration-300 transform hover:scale-150">
                                <img
                                    :src="imgsrc"
                                    v-if="imgsrc"
                                    alt="item-image"
                                    class="h-96 w-full object-contain "
                                />

                                <img
                                    :src="$root.url + 'noimage.png'"
                                    v-if="!imgsrc"
                                    alt="item-image"
                                    class="h-96 w-full object-contain"
                                />
                                <div class="flex justify-center"></div>
                            </div>
                        </transition>
                        <div v-if="loadingImage">
                            <span class="text-white mb-2">Loading..</span>
                            <FulfillingSquareSpinner
                                :animation-duration="4000"
                                :size="60"
                                color="#F9FAFB"
                            />
                        </div>
                    </div>
                </transition>

                <transition
                    enter-active-class="ease-out duration-500"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-300"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-if="isUpload"
                        class="bg-black bg-opacity-40 fixed top-0 left-0 z-50 flex  justify-center items-center w-full min-h-screen"
                    >
                        <div class=" bg-white w-1/2  relative">
                            <div
                                class="border-b flex justify-between items-center p-2"
                            >
                                <label for="" class="text-lg tracking-wider"
                                    >Upload Image</label
                                >
                                <button
                                    class="focus:outline-none "
                                    @click="closeDialog"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-gray-700 hover:text-red-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <transition
                                    enter-active-class="ease-out duration-500"
                                    enter-class="opacity-0"
                                    enter-to-class="opacity-100"
                                    leave-active-class="ease-in duration-500"
                                    leave-class="opacity-100"
                                    leave-to-class="opacity-0"
                                >
                                    <div
                                        class="mb-1 bg-red-500 bg-opacity-75 px-2 py-1 flex justify-between items-center transition duration-500"
                                        v-if="errors.item_image"
                                    >
                                        <small class="text-white text-sm ">
                                            {{ errors.item_image[0] }}
                                        </small>
                                        <button
                                            class="focus:outline-none"
                                            @click="clearErrorMessage"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6 text-gray-100 hover:text-white"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </transition>

                                <label
                                    class="flex flex-col items-center px-4 py-6 border bg-white  uppercase  cursor-pointer hover:text-yellow-500 hover:border-yellow-500 transition duration-500"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-gray-700"
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
                                        >Click here to select image</span
                                    >
                                    <input
                                        type="file"
                                        id="item_image"
                                        ref="item_image"
                                        class="hidden"
                                        @change="handleFileUploadItem()"
                                    />
                                </label>
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
                                        class="flex justify-between items-center mt-1 bg-white p-2 border border-gray-400 border-opacity-30  shadow-lg"
                                    >
                                        <label for="" class="text-green-500 ">{{
                                            filename
                                        }}</label>
                                        <div class=" text-white ">
                                            <button
                                                @click="upload"
                                                class="bg-green-500 px-2 py-1 w-20 focus:outline-none hover:bg-green-600 transition duration-300"
                                            >
                                                Upload
                                            </button>
                                            <button
                                                @click="cancelImage"
                                                class="bg-red-500 px-2 py-1 w-20 focus:outline-none hover:bg-red-600 transition duration-300"
                                            >
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import { FulfillingSquareSpinner } from "epic-spinners";
export default {
    name: "Central-Item",
    components: { FulfillingSquareSpinner },
    data() {
        let sortOrders = {};
        let columns = [
            {
                width: "10%",
                label: "Code",
                name: "itemcode",
                class: "text-left"
            },
            {
                width: "20%",
                label: "Description",
                name: "description",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Category",
                name: "category",
                class: "text-left"
            },
            {
                width: "8%",
                label: "UOM",
                name: "uom",
                class: "text-center"
            },
            {
                width: "10%",
                label: "Price",
                name: "price",
                class: "text-center"
            },
            {
                width: "12%",
                label: "Status",
                name: "status",
                class: "text-center"
            },
            {
                width: "12%",
                label: "Status Per Store",
                name: "sstatus",
                class: "text-center"
            },
            {
                width: "12%",
                label: "Action",
                name: "upload",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            viewImage: false,
            uploadImage: false,
            columns: columns,
            sortKey: "itemcode",
            sortOrders: sortOrders,
            file: "",
            filename: "",
            itemcode: "",
            imgsrc: "",
            loadingImage: false,
            tableData: {
                draw: 0,
                length: 10,
                search: "",
                column: 1,
                dir: "desc",
                category: "",
                price_group: "TAGB",
                store: ""
            },
            form: {
                product_id: "",
                itemcode: "",
                quantity: "",
                product_name: "",
                image: "",
                status: "",
                previewImage: ""
            },
            currentPage: 1
        };
    },
    computed: {
        ...mapState([
            "Stores",
            "perPage",
            "isModal",
            "errors",
            "pagination",
            "ItemCategory",
            "Items",
            "isUpload",
            "ItemMenu"
        ])
    },
    methods: {
        ...mapActions([
            "getStore",
            "modal",
            "getItemCategory",
            "getItems",
            "upload_image",
            "upload_flag",
            "changeStatusItem",
            "changeItemStatusPerStore"
        ]),
        reset() {
            this.errors.item_image = "";
            (this.filename = ""), (this.file = ""), (this.itemcode = "");
        },
        clearErrorMessage() {
            this.errors.item_image = "";
        },
        upload() {
            let formData = new FormData();

            formData.append("item_image", this.file);
            formData.append("itemcode", this.itemcode);

            this.upload_image({
                formData: formData
            });
            this.itemcode = "";
            setTimeout(() => {
                this.fetch();
            }, 1000);
        },
        cancelImage() {
            this.filename = "";
            this.reset();
        },
        showUpload(item) {
            this.filename = "";
            this.itemcode = item.itemcode;
            if (item.image != null) {
                swal.fire({
                    title: "IMAGE",
                    text: "Item has already an image.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, change it!"
                }).then(result => {
                    if (result.isConfirmed) {
                        this.upload_flag({
                            flag: true
                        });
                    }
                });
            } else {
                this.upload_flag({
                    flag: true
                });
            }
        },
        handleFileUploadItem() {
            this.file = this.$refs.item_image.files[0];
            this.filename = this.$refs.item_image.files[0].name;
        },
        closeDialog() {
            this.upload_flag({
                flag: false
            });
            this.viewImage = false;
            this.reset();
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        showImage(item) {
            this.viewImage = true;
            if (item.image) {
                let myImage = new Image();
                myImage.src = this.$root.url + item.image;
                myImage.onload = () => {
                    this.imgsrc = myImage.src;
                    this.loadingImage = false;
                };
                this.imgsrc = "";
                this.loadingImage = true;
            }
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                category: this.tableData.category,
                price_group: this.tableData.price_group,
                store: this.tableData.store
            };
            this.getItems({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        search() {
            this.fetch();
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        getPrice(e, i) {
            $("#price-" + i).text(e.target.value);
        },
        changeStatusPerStore(item) {
            if (this.tableData.store === "") {
                swal.fire(
                    "Information",
                    "Please select store to continue",
                    "info"
                );
                return;
            }

            if (item.item_not_available === null) {
                swal.fire({
                    title: "Are you sure?",
                    text: "you want to set to inactive this item.",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Change it!"
                }).then(result => {
                    if (result.isConfirmed) {
                        let filter = {
                            store: this.tableData.store,
                            itemcode: item.itemcode,
                            status: 1
                        };
                        this.changeItemStatusPerStore({ filter });
                    }
                });
            } else {
                swal.fire({
                    title: "Are you sure?",
                    text: "you want to set to active this item.",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Change it!"
                }).then(result => {
                    if (result.isConfirmed) {
                        let filter = {
                            store: this.tableData.store,
                            itemcode: item.itemcode,
                            status: 0
                        };
                        this.changeItemStatusPerStore({ filter });
                    }
                });
            }
        },
        changeStatus(item) {
            let filter = {
                itemcode: item.itemcode,
                status: item.status
            };
            if (item.status === "active") {
                swal.fire({
                    title: "Do you want",
                    text: "to change the status to inactive this item?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, change it!"
                }).then(result => {
                    if (result.isConfirmed) {
                        this.changeStatusItem({ filter });
                    }
                });
            } else {
                swal.fire({
                    title: "Do you want",
                    text: "to change the status to active this item?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, change it!"
                }).then(result => {
                    if (result.isConfirmed) {
                        this.changeStatusItem({ filter });
                    }
                });
            }
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, "name", key);
            this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
            this.fetch();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        }
    },
    mounted() {
        Fire.$on("reload_item", () => {
            this.fetch();
        });
        this.fetch();
        this.getItemCategory();
        this.getStore();
    }
};
</script>
