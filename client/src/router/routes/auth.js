export default [
  {
    path: 'login',
    name: 'login',
    meta: {
      title: 'login'
    },
    component: () => import('pages/auth/Login')
  }
]
