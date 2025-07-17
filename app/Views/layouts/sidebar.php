<aside class="bg-white w-64 border-r border-gray-200 flex flex-col sticky top-0 h-screen">
    <div class="flex items-center space-x-3 px-6 py-5 border-b border-gray-200">
        <img src="https://storage.googleapis.com/a1aa/image/3d94939b-cb35-4b1c-e2c9-35ee06f7946a.jpg"
            class="h-10 w-10 rounded-full" alt="Logo toko sembako" />
        <h1 class="text-2xl font-semibold text-green-700">Sembako Inventory</h1>
    </div>
    <nav class="flex flex-col flex-grow px-6 py-6 space-y-2 text-gray-600 font-medium">
        <a href="<?= base_url('/') ?>"
            class="text-green-700 border-l-4 border-green-700 bg-green-50 pl-4 py-2 rounded-r-md flex items-center">
            <i class="fas fa-tachometer-alt mr-3 w-5 text-green-700"></i> Dashboard
        </a>
        <a href="<?= base_url('products') ?>"
            class="hover:text-green-700 hover:bg-green-50 pl-4 py-2 rounded-r-md flex items-center transition">
            <i class="fas fa-boxes mr-3 w-5"></i> Stok
        </a>
        <a href="<?= base_url('stockin') ?>"
            class="hover:text-green-700 hover:bg-green-50 pl-4 py-2 rounded-r-md flex items-center transition">
            <i class="fas fa-shopping-cart mr-3 w-5"></i> StockIn
        </a>
        <a href="#" class="hover:text-green-700 hover:bg-green-50 pl-4 py-2 rounded-r-md flex items-center transition">
            <i class="fas fa-file-alt mr-3 w-5"></i> Laporan
        </a>
        <a href="#" class="hover:text-green-700 hover:bg-green-50 pl-4 py-2 rounded-r-md flex items-center transition">
            <i class="fas fa-cog mr-3 w-5"></i> Pengaturan
        </a>
    </nav>
    <div class="px-6 py-4 border-t border-gray-200 flex items-center space-x-4">
        <button class="text-gray-500 hover:text-green-700">
            <i class="fas fa-search fa-lg"></i>
        </button>
        <button class="relative text-gray-500 hover:text-green-700">
            <i class="fas fa-bell fa-lg"></i>
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1.5">3</span>
        </button>
    </div>
</aside>