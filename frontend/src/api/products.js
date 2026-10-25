import client from './client'

export async function fetchProducts(page = 1) {
  try {
    const { data } = await client.get('/products', { params: { page } })

    return data
  } catch (error) {
    const status = error.response?.status

    throw new Error(status ? `Gagal memuat produk (HTTP ${status})` : 'Tidak dapat terhubung ke server')
  }
}
