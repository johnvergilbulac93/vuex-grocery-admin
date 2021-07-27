<template>
    <div class="space-y-2">
        <Breadcrumb :routes="routes" title="Uploading" />
        <div class="container text-black">
            <div class=" bg-gray-50 shadow-lg p-5 rounded">
                <div class="mb-5 bg-gray-100 p-2">
                    <label for="" class="text-lg tracking-wider"
                        >Upload Multiple Images</label
                    >
                </div>
                <span class="text-blue-500 ">NOTE:</span> Limit of images is
                100.
                <div class="mt-2">
                    <Upload
                        ref="upload"
                        :show-upload-list="false"
                        :format="['jpg', 'jpeg', 'png']"
                        :on-error="handleError"
                        :on-success="handleSuccess"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }"
                        multiple
                        type="drag"
                        action="/api/upload/multiple"
                        style="display: inline-block; width: 150px"
                    >
                        <div
                            style="width: 150px; height: 120px; line-height: 130px"
                        >
                            <Icon type="ios-camera" size="50"></Icon>
                        </div>
                    </Upload>
                    <div
                        class="demo-upload-list"
                        v-for="(item, i) in uploadList"
                        :key="i"
                    >
                        <template v-if="item.status === 'finished'">
                            <img :src="item.url" />
                            <div class="demo-upload-list-cover">
                                <Icon
                                    type="ios-trash-outline"
                                    @click.native="handleRemove(item)"
                                ></Icon>
                            </div>
                        </template>
                        <template v-else>
                            <Progress
                                v-if="item.showProgress"
                                :percent="item.percentage"
                                hide-info
                            ></Progress>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Breadcrumb from "./../../../Usable/Breadcrumb";

export default {
    components: { Breadcrumb },
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
            }
        ];
        return {
            routes: routes,
            token: "",
            uploadList: [],
            imgName: "",
            visible: false
        };
    },
    methods: {
        handleRemove(file) {
            const fileList = this.$refs.upload.fileList;
            this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
        },
        handleSuccess(res, file) {
            file.url = file.response;
            file.name = file.name;
        },
        handleError(res, file) {
            swal.fire(
                "Warning",
                `${
                    file.errors.file.length
                        ? file.errors.file[0]
                        : "Something went wrong!"
                }`,
                "warning"
            );
        }
    },
    mounted() {
        this.token = $("meta[name=csrf-token]").attr("content");
        this.uploadList = this.$refs.upload.fileList;
    }
};
</script>

<style scoped>
.demo-upload-list {
    display: inline-block;
    width: 150px;
    height: 120px;
    text-align: center;
    line-height: 130px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.2);
    margin-right: 4px;
}
.demo-upload-list img {
    width: 150px;
    height: 120px;
    object-fit: scale-down;
    padding: 5px 5px;
}
.demo-upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.4);
}
.demo-upload-list:hover .demo-upload-list-cover {
    display: block;
}
.demo-upload-list-cover i {
    color: #fff;
    font-size: 40px;
    cursor: pointer;
    margin: 0 2px;
}
</style>
