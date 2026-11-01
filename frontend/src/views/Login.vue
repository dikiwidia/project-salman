<script setup>
import { reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuth } from '../store/auth'

const auth = useAuth()
const route = useRoute()
const router = useRouter()

const form = reactive({ email: '', password: '' })
const errors = ref({})
const errorMessage = ref('')
const isSubmitting = ref(false)

async function submit() {
  isSubmitting.value = true
  errors.value = {}
  errorMessage.value = ''

  try {
    await auth.login(form)

    const redirect = route.query.redirect
    router.push(typeof redirect === 'string' && redirect.startsWith('/') ? redirect : '/products')
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors ?? {}
    } else if (error.response?.status === 429) {
      errorMessage.value = 'Terlalu banyak percobaan login. Coba lagi dalam 1 menit.'
    } else {
      errorMessage.value = `${error.message}. Pastikan backend berjalan di localhost:8000.`
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>

<template>
  <div class="mx-auto mt-12 max-w-sm">
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
      <h1 class="mb-1 text-2xl font-semibold">Masuk</h1>
      <p class="mb-6 text-sm text-gray-500">Gunakan akun yang sudah terdaftar.</p>

      <div v-if="errorMessage" class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ errorMessage }}
      </div>

      <form class="space-y-4" @submit.prevent="submit">
        <div>
          <label for="email" class="mb-1 block text-sm font-medium">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            autocomplete="email"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            :class="{ 'border-red-400': errors.email }"
          />
          <p v-if="errors.email" class="mt-1 text-xs text-red-600">{{ errors.email[0] }}</p>
        </div>

        <div>
          <label for="password" class="mb-1 block text-sm font-medium">Password</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            autocomplete="current-password"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            :class="{ 'border-red-400': errors.password }"
          />
          <p v-if="errors.password" class="mt-1 text-xs text-red-600">{{ errors.password[0] }}</p>
        </div>

        <button
          type="submit"
          class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
          :disabled="isSubmitting"
        >
          {{ isSubmitting ? 'Memproses...' : 'Masuk' }}
        </button>
      </form>
    </div>
  </div>
</template>
