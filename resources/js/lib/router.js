const urlUser = '/admin/user'
const user = {
    label: "Users",
    link: urlUser,
    icon: "fas fa-user",
    list: [
        {
            link: urlUser + '',
            label: "List User",
        },
        {
            link: urlUser + '/role',
            label: "Role",
        },
    ],
}

const urlProduct = '/admin/products'
const product = {
    label: "Products",
    link: urlProduct,
    icon: "fas fa-box",
    list: [
        {
            link: urlProduct + '',
            label: "List Product",
        },
        {
            link: urlProduct + '/category',
            label: "Category Product",
        },
    ],
}
const urlMaterial = '/admin/materials'
const material = {
    label: "Materials",
    link: urlMaterial,
    icon: "fas fa-boxes",
    list: [
        {
            link: urlMaterial + '/',
            label: "List Material",
        },
        {
            link: urlMaterial + '/category',
            label: "Category Material",
        },
        {
            link: urlMaterial + '/variant',
            label: "Entry Variant",
        },
        {
            link: urlMaterial + '/variant/category',
            label: "Category Variant",
        },
    ],
}
const urlVendor = '/admin/vendors'
const vendor = {
    label: "Vendors",
    link: urlVendor,
    icon: "fas fa-university",
    list: [
        {
            link: urlVendor + '/',
            label: "List Vendor",
        },
        {
            link: urlVendor + '/materials',
            label: "Material Vendor",
        },

    ],
}
const urlPurchase = '/admin/purchases'
const purchase = {
    label: "Purchases",
    link: urlPurchase,
    icon: "fas fa-vote-yea",
    list: [
        {
            link: urlPurchase + '/',
            label: "List Purchase",
        },
    ],
}
const urlStockMaterial = '/admin/stocks/materials'
const stockMaterial = {
    label: "Stock Materials",
    link: urlStockMaterial,
    icon: "fas fa-vote-yea",
    list: [
        {
            link: urlStockMaterial + '/',
            label: "Stock In Material",
        },
        {
            link: urlStockMaterial + '/outs',
            label: "Stock Out Material",
        },
    ],
}
const urlTender = '/admin/tenders'
const tender = {
    label: "Tenders",
    link: urlTender,
    icon: "fas fa-weight",
    list: [
        {
            link: urlTender + '/',
            label: "List Tender",
        },
        {
            link: urlTender + '/employees',
            label: "Employee",
        },
    ],
}

export { user, product, material, vendor, purchase, stockMaterial, tender }