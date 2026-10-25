import { createRouter, createWebHistory } from 'vue-router'
import ProductListView from '../views/ProductListView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: '/products' },
    { path: '/products', name: 'products.index', component: ProductListView },
  ],
})

export default router
