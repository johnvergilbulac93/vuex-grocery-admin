import BaseApi from './BaseApi';

export default {
    upload_new_item(formData,axiosSource) {
        return BaseApi.post('/upload/item', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            cancelToken: axiosSource.token
        })
    },
    upload_price_update(formData, axiosSource) {
        return BaseApi.post('/upload/price', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            cancelToken: axiosSource.token
        })
    },
    upload_category(formData) {
        return BaseApi.post('/upload/category', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },
    upload_image_filename(formData) {
        return BaseApi.post('/upload/item/filename', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },
    batch_disable_item(formData) {
        return BaseApi.post('/upload/disable', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    },
    update_item_description(formData,axiosSource) {
        return BaseApi.post('/upload/item_description', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            cancelToken: axiosSource.token
        })
    }
}
