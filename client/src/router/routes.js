import AuthRoutes from './routes/auth'

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: AuthRoutes
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
