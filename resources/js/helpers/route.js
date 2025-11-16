// Simple route helper - replace with Ziggy if needed
export function route(name, params = {}) {
  const routes = {
    'login': '/login',
    'register': '/register',
    'logout': '/logout',
    'dashboard': '/dashboard',
    'consignments': '/consignments',
    'vendors.index': '/vendors',
    'vendors.create': '/vendors/create',
    'vendors.show': '/vendors/:vendor',
    'vendors.edit': '/vendors/:vendor/edit',
    'vendors.store': '/vendors',
    'vendors.update': '/vendors/:vendor',
    'vendors.destroy': '/vendors/:vendor',
    'invoices': '/invoices',
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

