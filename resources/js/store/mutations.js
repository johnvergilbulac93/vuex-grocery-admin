export const PAGINATION = (state, pagination) => {
     state.pagination = {
          lastPage : pagination.last_page,
          currentPage: pagination.current_page,
          total: pagination.total,
          lastPageUrl: pagination.last_page_url,
          nextPageUrl: pagination.next_page_url,
          prevPageUrl: pagination.prev_page_url,
          from: pagination.from,
          to: pagination.to
     }
}
export const SET_ERRORS  = (state, payload) => {
     state.errors = payload
}
export const MODAL_FLAG = (state, flag) => {
     state.isModal = flag
}
export const SET_ITEM_CATEGORY = (state, payload) => {
     state.ItemCategory = payload
}
export const SET_PRICE_CHANGED_INFO  = (state, payload) => {
     state.PriceChangeInfo = payload
}
export const SET_ITEM_NOT_AVAILABLE  = (state, payload) => {
     state.ItemsNotAvailable = payload
}
export const SET_PRICE_COUNT_CHANGED  = (state, payload) => {
     state.priceCount = payload
}
export const SET_STORES  = (state, payload) => {
     state.Stores = payload
}
export const SET_PROVINCE  = (state, payload) => {
     state.Provinces = payload
}
export const SET_BARANGAY  = (state, payload) => {
     state.Barangays = payload
}
export const SET_TOWN  = (state, payload) => {
     state.Towns = payload
}
export const SET_TRANSPORTATION  = (state, payload) => {
     state.Transportations = payload
}
export const SET_STORE_HOUR = (state, payload) => {
     state.StoreHourList = payload
}
export const USERTYPE = (state, payload) => {
     state.UserTypes = payload
}
export const REMOVE_STORE_HOUR = (state, id) => {
     state.StoreHourList = state.StoreHourList.filter( storehour => {
         return storehour.id != id
     })
}
export const SET_DEPARTMENTS = (state, payload) => {
     state.Departments = payload
}
export const SET_TENANTS = (state, payload) => {
     state.Tenants = payload
}
export const REMOVE_TENANT = (state, id) => {
     state.Tenants = state.Tenants.filter( tenant => {
         return tenant.tenant_id != id
     })
}
export const SET_DCHARGE = (state, payload) => {
     state.DCharges = payload
}
export const FILTERED_BRGY = (state, town) => {
     state.filterBarangays = state.Barangays.filter(brgy => {
         return brgy.town_id === town.town_id
     })
}
export const FILTERED_TOWN = (state, province) => {
     state.filterTowns = state.Towns.filter(town => {
         return town.prov_id === province.prov_id
     })
}
export const REMOVE_CHARGE = (state, id) => {
     state.DCharges = state.DCharges.filter( charge => {
         return charge.chrg_id != id
     })
}
export const SET_MINORDER= (state, payload) => {
     state.MinOrders = payload
}
export const REMOVE_MIN_ORDER = (state, id) => {
     state.MinOrders = state.MinOrders.filter( order => {
         return order.min_id != id
     })
}
export const SET_USER = (state, payload) => {
     state.Users = payload
}
export const SET_EMPLOYEE = (state, payload) => {
     state.Employees = payload
}
export const CLEAR_EMPLOYEE = (state) => {
     state.Employees = []
} 
export const REMOVE_USER = (state, id) => {
     state.Users = state.Users.filter( user => {
          return user.id != id
      })
}
export const SET_ITEM = (state, payload) => {
     state.Items = payload
}
export const UPLOAD_FLAG = (state, flag) => {
     state.isUpload = flag
}
export const TOTAL_NOT_AVAILABLE = (state, payload) => {
     state.TotalItemNotAvailable = payload
}