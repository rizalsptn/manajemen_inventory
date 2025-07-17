<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>

<div class="flex-1 flex flex-col overflow-auto">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-end">
            <div class="relative">
                <button id="userMenuButton"
                    class="flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-green-500 rounded">
                    <img src="https://storage.googleapis.com/a1aa/image/f8df228e-6160-42a2-0665-9b60144fc1cb.jpg"
                        class="rounded-full w-8 h-8" alt="Admin profile" />
                    <span class="font-medium text-gray-700 hidden sm:block">Admin</span>
                    <i class="fas fa-chevron-down text-gray-500"></i>
                </button>
                <div id="userDropdown"
                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100">
                            <i class="fas fa-cog mr-2"></i> Pengaturan Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section class="mb-16" id="daftar-produk">
            <h2 class="text-3xl font-semibold text-gray-800 mb-8">Daftar Produk</h2>
            <div class="flex flex-col md:flex-row md:justify-start md:items-center mb-6 gap-4">
                <button
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-md shadow-md flex items-center gap-2 w-full md:w-auto justify-center"
                    id="modalTableKategori">
                    <i class="fas fa-tags"></i>
                </button>
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-md shadow-md flex items-center gap-2 w-full md:w-auto justify-center"
                    id="btnTambahProduk">
                    <i class="fas fa-plus">
                    </i>
                    Tambah Produk
                </button>
                <input
                    class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    id="searchProduk" placeholder="Cari produk..." type="text" />
            </div>
            <div class="overflow-x-auto rounded-lg shadow-md bg-white">
                <table class="min-w-full divide-y divide-gray-200" id="tableProduk">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                Gambar
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                Nama Produk
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                Harga (Rp)
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                Stok
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                Stok Minimum
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="produkList">
                        <!-- Produk akan dimuat di sini -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Modal Produk -->
    <div aria-hidden="true"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-40" id="modalProduk">
        <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <form class="p-6 space-y-6" id="formProduk" novalidate="">
                <h3 class="text-2xl font-semibold text-indigo-700 mb-4" id="modalProdukTitle">
                    Tambah Produk
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="namaProduk">
                            Nama Produk
                            <span class="text-red-600">
                                *
                            </span>
                        </label>
                        <input
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            id="namaProduk" name="name" placeholder="Contoh: Beras Premium" required="" type="text" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="kategoriProduk">
                            Kategori
                            <span class="text-red-600">
                                *
                            </span>
                        </label>
                        <select
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            id="kategoriProduk" name="category_id" required="">
                            <!-- Opsi kategori akan dimuat di sini -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="hargaProduk">
                            Harga (Rp)
                            <span class="text-red-600">
                                *
                            </span>
                        </label>
                        <input
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            id="hargaProduk" min="0" name="price" placeholder="Contoh: 15000" required=""
                            type="number" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="stokProduk">
                            Stok Awal
                            <span class="text-red-600">
                                *
                            </span>
                        </label>
                        <input
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            id="stokProduk" min="0" name="stock" placeholder="Contoh: 100" required="" type="number" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="stokMinProduk">
                            Stok Minimum
                            <span class="text-red-600">
                                *
                            </span>
                        </label>
                        <input
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            id="stokMinProduk" min="0" name="min_stock" placeholder="Contoh: 10" required=""
                            type="number" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="gambarProduk">
                            Gambar Produk
                        </label>
                        <input accept="image/*"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            id="gambarProduk" name="image" type="file" />
                        <img alt="Preview gambar produk yang diupload"
                            class="mt-3 max-h-48 rounded-md object-contain border border-gray-300" height="300"
                            id="previewGambarProduk"
                            src="https://storage.googleapis.com/a1aa/image/8207d951-bfd2-4f00-bc79-080948e02688.jpg"
                            width="400" />
                    </div>
                </div>
                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <button
                        class="px-5 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100 transition"
                        id="btnBatalProduk" type="button">
                        Batal
                    </button>
                    <button
                        class="px-5 py-2 rounded-md bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition"
                        type="submit">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- table kategori -->
    <div id="modalKategori"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <!-- Tombol tambah kategori dan search -->
            <div class="flex justify-between items-center mb-4">
                <button id="btnTambahKategori"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 font-semibold">
                    + Tambah Kategori
                </button>
                <input id="searchKategori" type="text" placeholder="Cari kategori..."
                    class="border border-gray-300 rounded px-3 py-2 w-1/2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- TABEL kategori -->
            <div class="overflow-x-auto max-h-[300px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                Nama</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kategoriList" class="divide-y divide-gray-100">
                        <!-- Data kategori dimuat lewat JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Form Kategori -->
    <div id="modalFormKategori"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <form id="formKategori" class="space-y-4">
                <h3 class="text-2xl font-semibold text-indigo-700" id="modalKategoriTitle">Tambah Kategori</h3>
                <div>
                    <label for="namaKategori" class="block text-sm font-medium text-gray-700">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="namaKategori" id="namaKategori"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 pt-4">
                    <button type="button" id="btnBatalKategori"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= base_url('js/products.js') ?>"></script>
    <script src="<?= base_url('js/kategori.js') ?>"></script>
    </tbody>

    <footer class="bg-white border-t border-gray-200 text-center py-4 text-gray-500 text-sm">
        © 2024 Toko Sembako. All rights reserved.
    </footer>