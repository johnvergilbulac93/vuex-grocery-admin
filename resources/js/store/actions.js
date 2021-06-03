import Common from '../services/Common'
import Rules from '../services/Rules'
import StoreHour from '../services/StoreHour'
import Tenant from '../services/Tenant'
import Charge from '../services/DCharges'
import MinOrder from '../services/MinOrder'
import User from '../services/User'
import Item from  '../services/Item'

export const userType = ({commit}) => {
     Common.ViewUserType()
     .then( res => {
          commit('USERTYPE', res.data)
     })
}
export const brgyFiltered = ({commit},{town}) => {
     commit('FILTERED_BRGY', town)
}
export const townFiltered = ({commit},{province}) => {
     commit('FILTERED_TOWN', province)
}
export const getPriceChangedInfo = ({commit},{currentPage, filterData}) => {
     Common.Price_changed_info(currentPage, filterData)
     .then( res=> {
          commit('SET_PRICE_CHANGED_INFO', res.data.data)
          commit('PAGINATION', res.data)
     })
}
export const getItemNotAvailable = ({commit},{currentPage, filterData}) => {
     Common.Item_not_available(currentPage, filterData)
     .then( res=> {
          commit('SET_ITEM_NOT_AVAILABLE', res.data.data)
          commit('PAGINATION', res.data)
          commit('TOTAL_NOT_AVAILABLE',res.data.total)
     })
}
export const getProvince = ({commit}) => {
     Common.ViewProvince()
     .then( res => {
          commit('SET_PROVINCE', res.data)
     })
}
export const getItemCategory = ({commit}) => {
     Common.ViewItemCategory()
     .then( res => {
          commit('SET_ITEM_CATEGORY', res.data)
     })
}
export const getBarangay = ({commit}) => {
     Common.ViewBarangay()
     .then( res => {
          commit('SET_BARANGAY', res.data)
     })
}
export const getTown = ({commit}) => {
     Common.ViewTown()
     .then( res => {
          commit('SET_TOWN', res.data)
     })
}
export const getTransportation = ({commit}) => {
     Common.ViewTransportation()
     .then( res => {
          commit('SET_TRANSPORTATION', res.data)
     })
}      
export const modal = ({commit}, {flag}) => {
     commit('MODAL_FLAG', flag)
}
export const upload_flag = ({commit}, {flag}) => {
     commit('UPLOAD_FLAG', flag)
}
export const getPriceChanged = ({commit}) => {
     Common.Price_changed_count()
     .then( res => {
          commit('SET_PRICE_COUNT_CHANGED',res.data)
     })
     
}
export const minamount = ({commit}, {minAmount}) => {
     Rules.minAmount(minAmount)
     .then(()=> {
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const pickupCharge = ({commit}, {chargeAmount}) => {
     Rules.pickupCharge(chargeAmount)
     .then(()=> {
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const orderTimeCutoff = ({commit}, {timeCutoff}) => {
     Rules.orderTimeCutoff(timeCutoff)
     .then(()=> {
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const maxOrder = ({commit}, {maxOrder}) => {
     Rules.maxOrder(maxOrder)
     .then(()=> {
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const servingTime = ({commit}, {timeCutoff}) => {
     Rules.servingTimeCutoff(timeCutoff)
     .then(()=> {
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const getStore = ({commit}) => {
     Common.ViewStore()
     .then( res => {
          commit('SET_STORES',res.data)
     })
}
export const showStoreHour = ({commit},{currentPage,filterData}) => {
     StoreHour.show(currentPage,filterData)
     .then( res =>{
          commit('SET_STORE_HOUR', res.data.data)
          commit('PAGINATION', res.data)
     })
}
export const saveStoreHour = ({commit},{storehour}) => {
     StoreHour.saveInfo(storehour)
     .then( ()=> {
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}

export const deleteStoreHour = ({commit},{id}) => {
     swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
               commit('REMOVE_STORE_HOUR',id)
               StoreHour.delete(id)
               .then( () => {
                    swal.fire("Deleted!", "Successfully.", "success"); 
               })
          }
        });
}
export const getDepartment = ({commit}) => {
     Common.ViewDepartment()
     .then( res => {
          commit('SET_DEPARTMENTS', res.data)
     })
}
export const showTenant = ({commit},{currentPage,filterData}) => {
     Tenant.show(currentPage,filterData)
     .then( res =>{
          commit('SET_TENANTS', res.data.data)
          commit('PAGINATION', res.data)
     })
}
export const saveTenant = ({commit}, {tenant}) => {
     Tenant.saveInfo(tenant)
     .then( res => {
          if (res.data.error === true) {
               swal.fire(
                   "Double Entry",
                   "Please check your data.",
                   "warning"
               );
           }
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const updateTenant = ({commit}, {tenant}) => {
     Tenant.updateInfo(tenant)
     .then( () => {
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const deleteTenant = ({commit}, {id}) => {
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
              Tenant.delete(id)
              .then( ()=> {
                    commit('REMOVE_TENANT',id)
                    toast.fire({
                         icon: "success",
                         title: "Success",
                         text: "Successfully Deleted"
                    });
              })
          }
      });
}
export const getDCharges = ({commit}, {currentPage,filterData}) => {
     Charge.show(currentPage, filterData)
     .then( res => {
          commit('SET_DCHARGE', res.data.data)
          commit('PAGINATION', res.data)
     })
}
export const saveCharge = ({commit},{charge}) => {
     Charge.saveInfo(charge)
     .then( res => {

          if (res.data.error === true) {
               swal.fire(
                   "Double Entry",
                   "Please check your data.",
                   "warning"
               );
           }else if(res.data.error === false){
               commit('MODAL_FLAG', false)
               toast.fire({
                    icon: "success",
                    title: "Success",
                    text: "Successfully saved"
               });
           }
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const updateCharge = ({commit}, {charge}) => {
     Charge.updateInfo(charge)
     .then( () => {
          commit('MODAL_FLAG', false)
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const deleteCharge = ({commit}, {id}) => {
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
              Charge.delete(id)
              .then( ()=> {
                    commit('REMOVE_CHARGE',id)
                    toast.fire({
                         icon: "success",
                         title: "Success",
                         text: "Successfully Deleted"
                    });
              })
          }
      });
}
export const saveMinOrder = ({commit}, {minorder}) => {
     MinOrder.saveInfo(minorder)
     .then( res => {
          if (res.data.error === true) {
               swal.fire(
                   "Double Entry",
                   "Please check your data.",
                   "warning"
               );
           }else if(res.data.error === false){
               commit('MODAL_FLAG', false)
               toast.fire({
                    icon: "success",
                    title: "Success",
                    text: "Successfully saved"
               });
           }
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const getMinOrder = ({commit},{currentPage,filterData}) => {
     MinOrder.show(currentPage, filterData)
     .then( res => {
          commit('SET_MINORDER', res.data.data)
          commit('PAGINATION', res.data)
     })
}
export const updateMinOrder = ({commit},{minorder}) => {
     MinOrder.updateInfo(minorder)
     .then( () => {
          commit('MODAL_FLAG', false)
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })

}
export const deleteMinOrder = ({commit},{id}) => {
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
              commit('REMOVE_MIN_ORDER',id)
              MinOrder.delete(id)
              .then( ()=> {
                    toast.fire({
                         icon: "success",
                         title: "Success",
                         text: "Successfully Deleted"
                    });
              })
          }
      });
}
export const getUser = ({commit},{currentPage,filterData}) => {
     User.show(currentPage, filterData)
     .then( res => {
          commit('SET_USER', res.data.data)
          commit('PAGINATION', res.data)
     })
}
export const getEmployee = ({commit}, {employee}) => {
     Common.ViewEmployee(employee)
     .then( res => {
          commit('SET_EMPLOYEE', res.data)
     })
}
export const saveUser = ({commit}, {user}) => {
     User.saveInfo(user)
     .then(()=> {
          commit('MODAL_FLAG', false)
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const deleteUser = ({commit},{id}) => {
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
              commit('REMOVE_USER',id)
              User.delete(id)
              .then( ()=> {
                    toast.fire({
                         icon: "success",
                         title: "Success",
                         text: "Successfully Deleted"
                    });
              })
          }
      });

}
export const updateUser = ({commit},{user}) => {
     User.updateInfo(user)
     .then( ()=> {
          commit('MODAL_FLAG', false)
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully saved"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const getItems = ({commit}, {currentPage, filterData}) => {
     Item.show(currentPage, filterData)
     .then( res => {
          commit('SET_ITEM', res.data.data)
          commit('PAGINATION', res.data)
     })
}
export const upload_image = ({commit},{formData}) => {
     Item.uploadImage(formData)
     .then( ()=> {
          commit('UPLOAD_FLAG', false)
          toast.fire({
               icon: "success",
               title: "Success",
               text: "Successfully uploaded"
          });
     })
     .catch( error => {
          if(error.response.status === 422) {
               commit('SET_ERRORS',error.response.data.errors )
          } 
     })
}
export const item_inactive = ({commit}, {itemCode}) => {
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
               Item.item_inactive(itemCode)
               .then( () => {

                    toast.fire({
                         icon: "success",
                         title: "Success",
                         text: "Successfully changed"
                    });
               })

          }
      });
}
export const item_active = ({commit}, {itemCode}) => {
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
               Item.item_active(itemCode)
               .then( () => {
                    toast.fire({
                         icon: "success",
                         title: "Success",
                         text: "Successfully changed"
                    });
               })

          }
      });
}
export const getItemEnable = ({commit}, {currentPage, filterData}) => {
     Item.show_item_enable_per_uom(currentPage, filterData)
     .then( res => {
          commit('SET_ITEM', res.data.data)
          commit('PAGINATION', res.data)
     })
}
export const disableItemPerUOM = ({commit},{itemCode}) => {
     Item.item_disable_per_uom(itemCode,)
     .then( () => {
          swal.fire(
               "Success!",
               "Selected item/uom successfully disable.",
               "success"
           );
     })
}
export const getItemDisable = ({commit}, {currentPage, filterData}) => {
     Item.show_item_disable_per_uom(currentPage, filterData)
     .then( res => {
          commit('SET_ITEM', res.data.data)
          commit('PAGINATION', res.data)
     })
}
export const enableItemPerUOM = ({commit},{itemCode}) => {
     Item.item_enable_per_uom(itemCode,)
     .then( () => {
          swal.fire(
               "Success!",
               "Selected item/uom successfully enable.",
               "success"
           );
     })
}
export const getStoreItem = ({commit},{currentPage,filterData}) => {
     Item.store_item_masterfile(currentPage,filterData)
     .then( res =>{
          commit('SET_ITEM', res.data.data)
          commit('PAGINATION', res.data)
     })
}