export default {
    perPage: ["10", "25", "50", "100"],
    pagination: {
        lastPage: "",
        currentPage: "",
        total: "",
        lastPageUrl: "",
        nextPageUrl: "",
        prevPageUrl: "",
        from: "",
        to: ""
    },
    SetupMenu: [
        {
            label: "Business Rules",
            route: "/business_rules"
        },
        {
            label: "Store time",
            route: "/bu_time"
        },
        {
            label: "Tenant",
            route: "/tenant"
        },
        {
            label: "Delivery Charges",
            route: "/delivery_charges"
        },
        {
            label: "Minimum Order Delivery",
            route: "/minimum_delivery"
        },
        {
            label: "Manage User",
            route: "/users"
        },
        {
            label: "Price Group",
            route: "/price_group"
        }
    ],
    ItemMenu: [
        {
            label: "Item Masterfile",
            route: "/central_item"
        },
        {
            label: "Disable Item Unit of Measure(UOM)",
            route: "/disable_uom"
        },
        {
            label: "Enable Item Unit of Measure(UOM)",
            route: "/enable_uom"
        }
    ],
    UploadingMenu: [
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
    ],
    ReportMenu: [
        {
            label: "Item ",
            route: "/reports"
        },
        {
            label: "Liquidation ",
            route: "/liquidition"
        },
        {
            label: "Accountability ",
            route: "/accountability"
        },
        {
            label: "Total Order - REMITTED",
            route: "/transaction"
        },
        {
            label: "Special Instruction, Comments & Suggestions",
            route: "/special_instruction_comments_suggestions"
        }
    ],
    isSuccess: false,
    TotalItemNotAvailable: 0,
    isModal: false,
    isLoading: false,
    isUpload: false,
    waiting: false,
    checkSession: false,
    errors: {},
    priceCount: "",
    PriceChangeInfo: [],
    ItemsNotAvailable: [],
    Stores: [],
    Barangays: [],
    Towns: [],
    Provinces: [],
    Transportations: [],
    Departments: [],
    StoreHourList: [],
    Tenants: [],
    DCharges: [],
    filterTowns: [],
    filterBarangays: [],
    MinOrders: [],
    Users: [],
    UserTypes: [],
    Employees: [],
    Items: [],
    ItemCategory: [],
    PriceGroup: [],
    StorePriceGroup: [],
    Rules: [],
    Unfounds: [],
    Instructions: [],
    Liquidation: [],
    Transactions: [],
    Accountability: []
};
