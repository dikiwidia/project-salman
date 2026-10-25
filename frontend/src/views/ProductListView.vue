<script setup>
import { onMounted, ref } from 'vue'
import { fetchProducts } from '../api/products'

const products = ref([])
const meta = ref(null)
const isLoading = ref(false)
const errorMessage = ref('')

const priceFormatter = new Intl.NumberFormat('id-ID', {
  style: 'currency',
  currency: 'IDR',
  maximumFractionDigits: 0,
})

const dateFormatter = new Intl.DateTimeFormat('id-ID', { dateStyle: 'medium' })

function formatDate(value) {
  return value ? dateFormatter.format(new Date(value)) : '-'
}

function isExpired(value) {
  return value ? new Date(value) < new Date() : false
}

async function loadProducts(page = 1) {
  isLoading.value = true
  errorMessage.value = ''

  try {
    const response = await fetchProducts(page)
    products.value = response.data
    meta.value = response.meta
  } catch (error) {
    errorMessage.value = error.message
  } finally {
    isLoading.value = false
  }
}

onMounted(() => loadProducts())
</script>

<template>
  <div>
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold">Daftar Produk</h1>
        <p v-if="meta" class="text-sm text-gray-500">Total {{ meta.total }} produk</p>
      </div>
      <button
        type="button"
        class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm hover:bg-gray-100 disabled:opacity-50"
        :disabled="isLoading"
        @click="loadProducts(meta?.current_page ?? 1)"
      >
        Muat ulang
      </button>
    </div>

    <div v-if="errorMessage" class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
      {{ errorMessage }}. Pastikan backend berjalan di localhost:8000.
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
      <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
          <tr>
            <th class="px-4 py-3">Kode</th>
            <th class="px-4 py-3">Nama</th>
            <th class="px-4 py-3 text-right">Harga</th>
            <th class="px-4 py-3">Kedaluwarsa</th>
            <th class="px-4 py-3">Supplier</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr v-if="isLoading">
            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Memuat data...</td>
          </tr>
          <tr v-else-if="products.length === 0">
            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada produk.</td>
          </tr>
          <template v-else>
            <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
              <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ product.code }}</td>
              <td class="px-4 py-3 font-medium">{{ product.name }}</td>
              <td class="px-4 py-3 text-right tabular-nums">{{ priceFormatter.format(product.price) }}</td>
              <td class="px-4 py-3">
                <span :class="isExpired(product.expired_date) ? 'text-red-600' : ''">
                  {{ formatDate(product.expired_date) }}
                </span>
              </td>
              <td class="px-4 py-3 text-gray-600">{{ product.supplier_name }}</td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <div v-if="meta && meta.last_page > 1" class="mt-4 flex items-center justify-between text-sm">
      <span class="text-gray-500">Halaman {{ meta.current_page }} dari {{ meta.last_page }}</span>
      <div class="flex gap-2">
        <button
          type="button"
          class="rounded-md border border-gray-300 bg-white px-3 py-1.5 hover:bg-gray-100 disabled:opacity-50"
          :disabled="isLoading || meta.current_page <= 1"
          @click="loadProducts(meta.current_page - 1)"
        >
          Sebelumnya
        </button>
        <button
          type="button"
          class="rounded-md border border-gray-300 bg-white px-3 py-1.5 hover:bg-gray-100 disabled:opacity-50"
          :disabled="isLoading || meta.current_page >= meta.last_page"
          @click="loadProducts(meta.current_page + 1)"
        >
          Berikutnya
        </button>
      </div>
    </div>
  </div>
</template>
