/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue').default;

import router from './routers'
import store from './store/index'


import swal from 'sweetalert2';
import moment from 'moment';
import excel from 'vue-excel-export'


import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import 'nprogress/nprogress.css'
// import Axios from 'axios';

// import VueProgressBar from 'vue-progressbar'
// 
// Vue.use(VueProgressBar, {
//   color: 'rgb(255, 128, 0)',
//   failedColor: 'red',
//   height: '4px'
// })


Vue.use(excel)

// Vue.use(DataTable);

window.swal = swal
const toast = swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000,
});

window.toast = toast
window.Fire = new Vue()

window.moment = require('moment')

Vue.use(ViewUI);



//Filters section
Vue.filter('textformat', function (data) {
    return data.charAt(0).toUpperCase() + data.slice(1)
});

Vue.filter('dateformat', function (created) {
    return moment(created).startOf().fromNow();
});

Vue.filter('formatDate', date => moment(date).format('MMMM Do YYYY, h:mm:ss a'))
Vue.filter('formatDateNoTime', date => moment(date).format('MMM DD, YYYY'))
Vue.filter('formatDateMonthOnly', date => moment(date).format('MMMM'))
Vue.filter('formatTime', date => moment(date).format('h:mm A'))
Vue.filter('formatTime2', time => moment(time, ["HH.mm"]).format('hh:mm a'))

Vue.filter('toCurrency', function (value) {
    if (typeof value !== 'number') {
        return value
    }
    var formatter = new Intl.NumberFormat()
    return formatter.format(value)
})

Vue.filter('toCurrency2', function (value) {
    var formatter = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
    })
    return formatter.format(value)
})
//End of Filters Section


// About User info
let serverDateTime = document.head.querySelector('meta[name="server-datetime"]').content
let userType = document.head.querySelector('meta[name="user-type"]').content
let id = document.head.querySelector('meta[name="id"]').content

window.serverDateTime = serverDateTime
window.userType = userType
window.id = id
//End About User info


//Global Declaration Component
Vue.component('Profile', require('./components/admin/pages/Profile-Upload.vue').default);
Vue.component('Pagination', require('./Usable/Pagination.vue').default);
Vue.component('Datatable', require('./Usable/Datatable.vue').default);
Vue.component('Breadcrumb', require('./Usable/Breadcrumb.vue').default);
Vue.component('Error', require('./Usable/Error.vue').default);
Vue.component('ErrorMessage', require('./Usable/ErrorMessage.vue').default);
Vue.component('Clock', require('./Usable/Clock.vue').default);
//End Global Declaration Component


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
    data() {
        return {
            // url: "https://admins.alturush.com/ITEM-IMAGES/",
            // path: "https://admins.alturush.com/img/",
            // url: process.env.MIX_URL_LOCAL,
            // path: process.env.MIX_URL_PATH,
            url: process.env.MIX_URL_ITEM_IMAGES,
            path: process.env.MIX_URL_RESOURCES,
            serverDateTime,
            userType,
            id,
            logo_path: 'https://apanel.alturush.com/',
            open: false,
            openMenu: false,
            upload_profile: false,
            showPassword: false,
            password: '',
            messageIdle: ''
        }
    },
    
    methods: {
        handleBlur(e) {
            setTimeout(() => {
                this.open = false
            }, 100)
        },
        toggleMenu() {
            setTimeout(() => {
                this.openMenu = false
            }, 100)
        },
        showUpload() {
            this.upload_profile = true
        },
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
    },  

});
