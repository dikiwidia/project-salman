<template>
  <div class="min-h-screen bg-gray-50 text-gray-800">
    <header class="border-b border-gray-200 bg-white">
      <nav class="mx-auto flex max-w-6xl items-center gap-6 px-4 py-4">
        <span class="text-lg font-semibold">Project Salman</span>
        <RouterLink
          to="/products"
          class="text-sm text-gray-600 hover:text-gray-900"
          active-class="font-medium text-indigo-600"
        >
          Produk
        </RouterLink>
      </nav>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8">
      <RouterView />
    </main>
  </div>
</template>
