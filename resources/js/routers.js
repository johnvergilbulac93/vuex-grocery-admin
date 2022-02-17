import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store";

// Vue.use(VueRouter)

import landing_page from "./components/admin/pages/Landing-page";
import item from "./components/admin/pages/Item-masterfile";
import disabled_item_batch from "./components/admin/pages/Item-disabled-batch";
import home from "./components/admin/pages/Dashboard";
import users from "./components/admin/pages/Users";
import central_item from "./components/admin/pages/Central-item";
import business_rule from "./components/admin/pages/Business-rule";
import Mbusiness_rule from "./components/admin/pages/Mbusiness-rule";
import uploading from "./components/admin/pages/Uploading";
import setting from "./components/admin/pages/Setting";
import reports_store from "./components/admin/pages/Reports-store";
import reports from "./components/admin/pages/Reports";
import transaction from "./components/admin/pages/Transactions";
import accountability from "./components/admin/pages/Accountability-Report";
import exporting from "./components/admin/pages/ExportFiles";
import liquidition from "./components/admin/pages/Liquidition-Report";
import bu_time from "./components/admin/pages/Business-time";
import Mbu_time from "./components/admin/pages/Mbusiness-time";
import tenant from "./components/admin/pages/Tenants";
import count from "./components/admin/pages/Available-item-store";
import disable_uom from "./components/admin/pages/Item-disable-per-uom";
import enable_uom from "./components/admin/pages/Item-enable-per-uom";
import minimum_delivery from "./components/admin/pages/Minimum-order-delivery";
import delivery_charges from "./components/admin/pages/Delivery-charges";
import multiple from "./components/admin/pages/Multiple-images";
import liquidition_store from "./components/admin/pages/Liquidition-Report-Store";
import accountability_store from "./components/admin/pages/Accountability-Report-Store";
import menu from "./components/admin/pages/Menu";
import price_group from "./components/admin/pages/Price-Group";
import change_password from "./components/admin/pages/Change-Password";
import change_username from "./components/admin/pages/Change-Username";
import special_instruction_comments_suggestions from "./components/admin/pages/Special-Instructions-Comments-Suggestions.vue";
import update_item_description from "./components/admin/pages/Upload-Item-Description.vue";
import PageNotFound from "./Usable/Page-not-found.vue";
Vue.use(VueRouter);

let router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "main-page",
            component: landing_page
        },
        {
            path: "/change_password",
            name: "change_password",
            component: change_password
        },
        {
            path: "/change_username",
            name: "change_username",
            component: change_username
        },
        {
            path: "/home",
            name: "home",
            component: home,
            beforeEnter: (to, from, next) => {
                if (from.params.id != 12) {
                    next();
                } else {
                    next("/");
                }
            }
        },
        {
            path: "/item",
            name: "item",
            component: item
        },
        {
            path: "/uploading",
            name: "uploading",
            component: uploading
        },
        {
            path: "/business_rules",
            name: "business_rule",
            component: business_rule
        },
        {
            path: "/business_rules/:id",
            name: "Mbusiness_rule",
            component: Mbusiness_rule
        },
        {
            path: "/users",
            name: "users",
            component: users
        },
        {
            path: "/central_item",
            name: "central_item",
            component: central_item
        },
        {
            path: "/disabled_item_batch",
            name: "disabled_item",
            component: disabled_item_batch
        },
        {
            path: "/setting",
            name: "setting",
            component: setting
        },
        {
            path: "/reports",
            name: "report_item",
            component: reports
        },
        {
            path: "/reports_store",
            name: "reports_store",
            component: reports_store
        },
        {
            path: "/transaction",
            name: "transaction",
            component: transaction
        },
        {
            path: "/exporting",
            name: "export",
            component: exporting
        },
        {
            path: "/accountability",
            name: "accountability",
            component: accountability
        },
        {
            path: "/liquidition",
            name: "liquidition",
            component: liquidition
        },
        {
            path: "/bu_time",
            name: "bu_time",
            component: bu_time
        },
        {
            path: "/bu_time/:id",
            name: "Mbu_time",
            component: Mbu_time
        },
        {
            path: "/tenant",
            name: "tenant",
            component: tenant
        },
        {
            path: "/count",
            name: "count",
            component: count
        },
        {
            path: "/disable_uom",
            name: "disable_uom",
            component: disable_uom
        },
        {
            path: "/enable_uom",
            name: "enable_uom",
            component: enable_uom
        },
        {
            path: "/minimum_delivery",
            name: "minimum_delivery",
            component: minimum_delivery
        },
        {
            path: "/delivery_charges",
            name: "delivery_charges",
            component: delivery_charges
        },
        {
            path: "/multiple",
            name: "multiple",
            component: multiple
        },
        {
            path: "/liquidition_store",
            name: "liquidition_store",
            component: liquidition_store
        },
        {
            path: "/accountability_store",
            name: "accountability_store",
            component: accountability_store
        },
        {
            path: "/menu",
            name: "menu",
            component: menu
        },
        {
            path: "/price_group",
            name: "price_group",
            component: price_group
        },
        {
            path: "/special_instruction_comments_suggestions",
            name: "special_instruction_comments_suggestions",
            component: special_instruction_comments_suggestions
        },
        {
            path: "/update_item_description",
            name: "update_item_description",
            component: update_item_description
        },
        {
            path: "/contact_us",
            name: "contact_us",
            component: () => import("./components/admin/pages/Contact-Us.vue")
        },
        { path: "*", component: PageNotFound },

    ]
});
router.beforeEach((to, from, next) => {
    if (store.state.checkSession) {
        alert("Session expired. You'll be take to the login page.");
        location.reload();
    } else {
        store.commit("CLEAR_ERRORS");
        next();
    }
});
export default router;
