// Simple route helper - replace with Ziggy if needed
export function route(name, params = {}) {
  const routes = {
    'login': '/login',
    'register': '/register',
    'logout': '/logout',
    'dashboard': '/dashboard',
    'vendors.index': '/vendors',
    'vendors.create': '/vendors/create',
    'vendors.show': '/vendors/:vendor',
    'vendors.edit': '/vendors/:vendor/edit',
    'vendors.store': '/vendors',
    'vendors.update': '/vendors/:vendor',
    'vendors.destroy': '/vendors/:vendor',
    'invoices': '/invoices',
    'invoices.show': '/invoices/:invoice',
    'invoices.print': '/invoices/:invoice/print',
    'vehicles.index': '/vehicles',
    'vehicles.create': '/vehicles/create',
    'vehicles.show': '/vehicles/:vehicle',
    'vehicles.edit': '/vehicles/:vehicle/edit',
    'vehicles.store': '/vehicles',
    'vehicles.update': '/vehicles/:vehicle',
    'vehicles.destroy': '/vehicles/:vehicle',
    'categories.index': '/categories',
    'categories.create': '/categories/create',
    'categories.show': '/categories/:category',
    'categories.edit': '/categories/:category/edit',
    'categories.store': '/categories',
    'categories.update': '/categories/:category',
    'categories.destroy': '/categories/:category',
    'consignments.index': '/consignments',
    'consignments.create': '/consignments/create',
    'consignments.show': '/consignments/:consignment',
    'consignments.edit': '/consignments/:consignment/edit',
    'consignments.store': '/consignments',
    'consignments.update': '/consignments/:consignment',
    'consignments.destroy': '/consignments/:consignment',
    'sales.index': '/sales',
    'sales.create': '/sales/create',
    'sales.show': '/sales/:sale',
    'sales.edit': '/sales/:sale/edit',
    'sales.store': '/sales',
    'sales.update': '/sales/:sale',
    'sales.destroy': '/sales/:sale',
    'consignments.receipt': '/consignments/:consignment/receipt',
    'vehicles.invoice': '/vehicles/:vehicle/invoice',
    'vendors.quick-store': '/vendors/quick-store',
    'vehicles.quick-store': '/vehicles/quick-store',
  }

  let url = routes[name] || '/'

  // Handle both model name and id parameters
  if (params.id) {
    // If id is provided, use it for any parameter
    url = url.replace(/:[a-z_]+/, params.id)
  } else {
    // Otherwise, replace named parameters
    Object.keys(params).forEach(key => {
      url = url.replace(`:${key}`, params[key])
    })
  }

  return url
}

