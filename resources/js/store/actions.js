import Common from "../services/Common";
import Rules from "../services/Rules";
import StoreHour from "../services/StoreHour";
import Tenant from "../services/Tenant";
import Charge from "../services/DCharges";
import MinOrder from "../services/MinOrder";
import User from "../services/User";
import Item from "../services/Item";
import StorePriceGroup from "../services/StorePriceGroup";
import axios from "axios";
import Report from "../services/Report";

export const userType = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewUserType();
        if (status === 200) {
            commit("USERTYPE", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const brgyFiltered = ({ commit }, { town }) => {
    commit("FILTERED_BRGY", town);
};
export const townFiltered = ({ commit }, { province }) => {
    commit("FILTERED_TOWN", province);
};
export const getPriceChangedInfo = async (
    { commit },
    { currentPage, filterData }
) => {
    try {
        const { status, data } = await Item.Price_changed_info(
            currentPage,
            filterData
        );
        if (status === 200) {
            commit("SET_PRICE_CHANGED_INFO", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {}
};
export const getItemNotAvailable = async (
    { commit },
    { currentPage, filterData }
) => {
    try {
        const { status, data } = await Item.Item_not_available(
            currentPage,
            filterData
        );
        if (status === 200) {
            commit("SET_ITEM_NOT_AVAILABLE", data.data);
            commit("PAGINATION", data);
            commit("TOTAL_NOT_AVAILABLE", data.total);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getPriceGroup = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewPriceGroup();
        if (status === 200) {
            commit("SET_PRICE_GROUP", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getProvince = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewProvince();
        if (status === 200) {
            commit("SET_PROVINCE", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getItemCategory = async ({ commit }) => {
    try {
        const { status, data } = await Item.ViewItemCategory();
        if (status === 200) {
            commit("SET_ITEM_CATEGORY", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getBarangay = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewBarangay();
        if (status === 200) {
            commit("SET_BARANGAY", data);
        }
    } catch (error) {
        console.log(data);
    }
};
export const getTown = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewTown();
        if (status === 200) {
            commit("SET_TOWN", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getTransportation = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewTransportation();
        if (status === 200) {
            commit("SET_TRANSPORTATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const modal = ({ commit }, { flag }) => {
    commit("MODAL_FLAG", flag);
};
export const upload_flag = ({ commit }, { flag }) => {
    commit("UPLOAD_FLAG", flag);
};
export const getPriceChanged = async ({ commit }) => {
    try {
        const { status, data } = await Item.Price_changed_count();
        if (status === 200) {
            commit("SET_PRICE_COUNT_CHANGED", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getStore = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewStore();
        if (status === 200) {
            commit("SET_STORES", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const showStoreHour = async (
    { commit },
    { currentPage, filterData }
) => {
    try {
        const { status, data } = await StoreHour.show(currentPage, filterData);
        if (status === 200) {
            commit("SET_STORE_HOUR", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const saveStoreHour = async ({ commit }, { storehour }) => {
    try {
        const { status } = await StoreHour.saveInfo(storehour);
        if (status === 200) {
            Fire.$emit("reload_time");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const deleteStoreHour = ({ commit }, { id }) => {
    try {
        swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.isConfirmed) {
                commit("REMOVE_STORE_HOUR", id);
                StoreHour.delete(id).then(() => {
                    swal.fire("Deleted!", "Successfully.", "success");
                });
            }
        });
    } catch (error) {
        console.log(error);
    }
};
export const getDepartment = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewDepartment();
        if (status === 200) {
            commit("SET_DEPARTMENTS", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const showTenant = async ({ commit }, { currentPage, filterData }) => {
    try {
        const { status, data } = await Tenant.show(currentPage, filterData);
        if (status === 200) {
            commit("SET_TENANTS", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const saveTenant = async ({ commit }, { tenant }) => {
    try {
        const { status } = await Tenant.saveInfo(tenant);
        if (status === 200) {
            Fire.$emit("reload_tenant");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const updateTenant = async ({ commit }, { tenant }) => {
    try {
        const { status } = await Tenant.updateInfo(tenant);
        if (status === 200) {
            Fire.$emit("reload_tenant");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const deleteTenant = ({ commit }, { id }) => {
    swal.fire({
        title: "Confirmation",
        text: "Are you sure you want to delete this data?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.isConfirmed) {
            Tenant.delete(id).then(() => {
                commit("REMOVE_TENANT", id);
                toast.fire({
                    icon: "success",
                    title: "Success",
                    text: "Successfully Deleted"
                });
            });
        }
    });
};
export const getDCharges = async ({ commit }, { currentPage, filterData }) => {
    try {
        const { status, data } = await Charge.show(currentPage, filterData);
        if (status === 200) {
            commit("SET_DCHARGE", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const saveCharge = async ({ commit }, { charge }) => {
    try {
        const { status } = await Charge.saveInfo(charge);
        if (status === 200) {
            Fire.$emit("reload_charge");
            commit("MODAL_FLAG", false);
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const updateCharge = async ({ commit }, { charge }) => {
    try {
        const { status } = await Charge.updateInfo(charge);
        if (status === 200) {
            Fire.$emit("reload_charge");
            commit("MODAL_FLAG", false);
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const deleteCharge = ({ commit }, { id }) => {
    swal.fire({
        title: "Confirmation",
        text: "Are you sure you want to delete this data?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.isConfirmed) {
            Charge.delete(id).then(() => {
                commit("REMOVE_CHARGE", id);
                toast.fire({
                    icon: "success",
                    title: "Success",
                    text: "Successfully Deleted"
                });
            });
        }
    });
};
export const saveMinOrder = async ({ commit }, { minorder }) => {
    try {
        const { status } = await MinOrder.saveInfo(minorder);
        if (status === 200) {
            Fire.$emit("reload_min_order");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const getMinOrder = async ({ commit }, { currentPage, filterData }) => {
    try {
        const { status, data } = await MinOrder.show(currentPage, filterData);
        if (status === 200) {
            commit("SET_MINORDER", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const updateMinOrder = async ({ commit }, { minorder }) => {
    try {
        const { status } = await MinOrder.updateInfo(minorder);
        if (status === 200) {
            Fire.$emit("reload_min_order");
            commit("MODAL_FLAG", false);
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const deleteMinOrder = ({ commit }, { id }) => {
    swal.fire({
        title: "Confirmation",
        text: "Are you sure you want to delete this data?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.isConfirmed) {
            commit("REMOVE_MIN_ORDER", id);
            MinOrder.delete(id).then(() => {
                toast.fire({
                    icon: "success",
                    title: "Success",
                    text: "Successfully Deleted"
                });
            });
        }
    });
};
export const getUser = async ({ commit }, { currentPage, filterData }) => {
    try {
        const { status, data } = await User.show(currentPage, filterData);
        if (status === 200) {
            commit("SET_USER", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getEmployee = async ({ commit }, { employee }) => {
    try {
        const { status, data } = await Common.ViewEmployee(employee);
        if (status === 200) {
            commit("SET_EMPLOYEE", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const saveUser = async ({ commit }, { user }) => {
    try {
        const { status } = await User.saveInfo(user);
        if (status === 200) {
            Fire.$emit("reload_user");
            commit("MODAL_FLAG", false);
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const deleteUser = ({ commit }, { id }) => {
    swal.fire({
        title: "Confirmation",
        text: "Are you sure you want to delete this user?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.isConfirmed) {
            commit("REMOVE_USER", id);
            User.delete(id).then(() => {
                toast.fire({
                    icon: "success",
                    title: "Success",
                    text: "Successfully Deleted"
                });
            });
        }
    });
};
export const updateUser = async ({ commit }, { user }) => {
    try {
        const { status } = await User.updateInfo(user);
        if (status === 200) {
            Fire.$emit("reload_user");
            commit("MODAL_FLAG", false);
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const getItems = async ({ commit }, { currentPage, filterData }) => {
    try {
        const { status, data } = await Item.show(currentPage, filterData);
        if (status === 200) {
            commit("SET_ITEM", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const upload_image = async ({ commit }, { formData }) => {
    try {
        const { status } = await Item.uploadImage(formData);
        if (status === 200) {
            commit("UPLOAD_FLAG", false);
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully uploaded"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const getItemEnable = async (
    { commit },
    { currentPage, filterData }
) => {
    try {
        const { status, data } = await Item.show_item_enable_per_uom(
            currentPage,
            filterData
        );
        if (status === 200) {
            commit("SET_ITEM", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const disableItemPerUOM = async ({ commit }, { itemCode }) => {
    try {
        const { status } = await Item.item_disable_per_uom(itemCode);
        if (status === 200) {
            swal.fire(
                "Success!",
                "Selected item/uom successfully disable.",
                "success"
            );
        }
    } catch (error) {
        console.log(error);
    }
};
export const getItemDisable = async (
    { commit },
    { currentPage, filterData }
) => {
    try {
        const { status, data } = await Item.show_item_disable_per_uom(
            currentPage,
            filterData
        );
        if (status === 200) {
            commit("SET_ITEM", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const enableItemPerUOM = async ({ commit }, { itemCode }) => {
    try {
        const { status } = await Item.item_enable_per_uom(itemCode);
        if (status === 200) {
            swal.fire(
                "Success!",
                "Selected item/uom successfully enable.",
                "success"
            );
        }
    } catch (error) {
        console.log(error);
    }
};
export const getStoreItem = async ({ commit }, { currentPage, filterData }) => {
    try {
        const { status, data } = await Item.store_item_masterfile(
            currentPage,
            filterData
        );
        if (status === 200) {
            commit("SET_ITEM", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getStorePriceGroup = async (
    { commit },
    { currentPage, filterData }
) => {
    try {
        const { status, data } = await StorePriceGroup.show(
            currentPage,
            filterData
        );

        if (status === 200) {
            commit("SET_STORE_PRICE_GROUP", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const saveStorePriceGroup = async ({ commit }, { storepricegroup }) => {
    try {
        const { status } = await StorePriceGroup.saveInfo(storepricegroup);
        if (status === 200) {
            Fire.$emit("reload_price_group");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const deleteStorePriceGroup = async ({ commit }, { id }) => {
    try {
        const { status } = await StorePriceGroup.delete(id);
        if (status === 200) {
            Fire.$emit("reload_price_group");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Deleted Successfully"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const userStatus = async({commit}, {filter}) => {
    
    try {
        const {status} = await User.userStatus(filter)
        if(status === 200){
            Fire.$emit("reload_user");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully changed."
            });
        }
    } catch (error) {
        console.log(error)
        
    }
}
export const storeChangeStatus = async({commit},{ filter }) => {
    
    try {
        const {status} = await StoreHour.changeStatus(filter)
        if(status === 200){
                Fire.$emit("reload_time");
                toast.fire({
                    icon: "success",
                    title: "Success",
                    text: "Successfully changed."
                });
        }
    } catch (error) {
        consol.log(error)
        
    }
}
export const userChangePass = async ({ commit }, { user }) => {
    try {
        const { status } = await User.changePassword(user);
        if (status === 200) {
            Fire.$emit("clear_field");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully change."
            });
            axios.post("/logout").then(() => {
                location.reload();
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const userChangeUsername = async ({ commit }, { user }) => {
    try {
        const { status } = await User.changeUsername(user);
        if (status === 200) {
            Fire.$emit("clear_field");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully change."
            });
            location.reload();
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const saveRule = async ({ commit }, { rule }) => {
    try {
        const { status } = await Rules.update(rule);
        if (status === 200) {
            commit("MODAL_FLAG", false);
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved."
            });
            Fire.$emit("reload_rules");
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const getRules = async ({ commit }) => {
    try {
        const { status, data } = await Rules.loadRules();
        if (status === 200) {
            commit("SET_RULES", data);
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const getInstruction = async ({commit}, {filter}) => {
    try {
        const { status, data} = await Report.store_instruction(filter)
        if(status === 200){
            commit('SET_INSTRUCTION', data)
        }
    } catch (error) {
        console.log(error)
    }
}
export const getUnfound = async ({commit}, {filter}) => {
    try {
        const { status, data} = await Report.store_unfound(filter)
        if(status === 200){
            commit('SET_UNFOUNDS', data)
        }
    } catch (error) {
        console.log(error)
    }
}
export const changeStatusItem = async ({commit}, {filter}) => {
    try {
        const { status} = await Item.change_status(filter)
        if(status === 200){
            Fire.$emit("reload_item");
        }
    } catch (error) {
        console.log(error)  
    }
}
export const changeItemStatusPerStore = async ({commit}, {filter}) => {
    try {
        const { status} = await Item.change_status_item_not_available(filter)
        if(status === 200){
            Fire.$emit("reload_item");
        }
    } catch (error) {
        console.log(error)  
    }
}
export const getLiquidation =  async ({commit}, {filter}) => {
    try {
        const { status, data } = await Report.liquidation_report(filter)
        if(status === 200){
            commit('SET_LIQUIDATION', data )
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
}
export const getTransaction = async ({commit}, {filter}) => {
    try {
        const{ status, data} = await Report.total_orders_report(filter)
        if(status === 200){
            commit('SET_TRANSACTIONS', data)
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
}
export const getAccountability = async ({commit}, {filter}) => {
    try {
        const { status, data} = await Report.accountability_report(filter)
        if(status === 200){
            commit("SET_ACCOUNTABILITY", data)
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
}