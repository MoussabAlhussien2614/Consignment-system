// Simple route helper - replace with Ziggy if needed
export function route(name, params = {}) {
  const routes = {
    'login': '/login',
    'register': '/register',
    'logout': '/logout',
    'dashboard': '/dashboard',
  }

  let url = routes[name] || '/'

  // Simple parameter replacement
  Object.keys(params).forEach(key => {
    url = url.replace(`{${key}}`, params[key])
  })

  return url
}

