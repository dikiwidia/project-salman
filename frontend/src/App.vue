<script setup>
import { useRouter } from 'vue-router'
import { useAuth } from './store/auth'

const auth = useAuth()
const router = useRouter()

async function logout() {
  await auth.logout()
  router.push('/login')
}
</script>

<template>
  <div class="min-h-screen bg-gray-50 text-gray-800">
    <header class="border-b border-gray-200 bg-white">
      <nav class="mx-auto flex max-w-6xl items-center gap-6 px-4 py-4">
        <span class="text-lg font-semibold">Project Salman</span>
        <template v-if="auth.isLoggedIn">
          <RouterLink
            to="/products"
            class="text-sm text-gray-600 hover:text-gray-900"
            active-class="font-medium text-indigo-600"
          >
            Produk
          </RouterLink>
          <div class="ml-auto flex items-center gap-4">
            <span v-if="auth.user" class="text-sm text-gray-600">{{ auth.user.name }}</span>
            <button
              type="button"
              class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm hover:bg-gray-100"
              @click="logout"
            >
              Keluar
            </button>
          </div>
        </template>
      </nav>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8">
      <RouterView />
    </main>
  </div>
</template>
