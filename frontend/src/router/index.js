import { createRouter, createWebHistory } from 'vue-router'
import { useAuth } from '../store/auth'
import Login from '../views/Login.vue'
import ProductListView from '../views/ProductListView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: '/products' },
    { path: '/login', name: 'login', component: Login, meta: { guestOnly: true } },
    {
      path: '/products',
      name: 'products.index',
      component: ProductListView,
      meta: { requiresAuth: true },
    },
  ],
})

router.beforeEach(async (to) => {
  const auth = useAuth()

  if (to.meta.requiresAuth && !auth.isLoggedIn) {
    return { name: 'login', query: { redirect: to.fullPath } }
  }

  if (to.meta.guestOnly && auth.isLoggedIn) {
    return { name: 'products.index' }
  }

  if (auth.isLoggedIn && !auth.user) {
    try {
      await auth.fetchUser()
    } catch {
      return { name: 'login' }
    }
  }
})

export default router
