<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stock In - Manajemen Inventory Toko Sembako</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header dan tombol -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4 md:mb-0">Data Stok Masuk</h2>
            <button type="button" onclick="toggleModal('modal-add-stock')"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                <i class="fas fa-plus mr-2"></i> Tambah Stok Masuk
            </button>
        </div>

        <!-- Tabel stok masuk -->
        <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 rounded-lg bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-600 uppercase">Tanggal Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-indigo-600 uppercase">Nama Produk</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-indigo-600 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-indigo-600 uppercase">Harga Beli</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-indigo-600 uppercase">Subtotal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-indigo-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php foreach ($stocks as $s): ?>
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900"><?= date('Y-m-d', strtotime($s['received_at'])) ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?= esc($s['product_name']) ?></td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900"><?= $s['quantity'] ?></td>
                        <td class="px-6 py-4 text-sm text-right text-gray-900">Rp
                            <?= number_format($s['purchase_price'], 0, ',', '.') ?></td>
                        <td class="px-6 py-4 text-sm text-right font-semibold text-gray-900">
                            Rp <?= number_format($s['quantity'] * $s['purchase_price'], 0, ',', '.') ?>
                        </td>
                        <td class="px-6 py-4 text-center text-sm font-medium space-x-2">
                            <button class="btnEditStockIn text-indigo-600 hover:text-indigo-900"
                                data-id="<?= $s['id'] ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btnDeleteStockIn text-red-600 hover:text-red-900" data-id="<?= $s['id'] ?>">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Tambah Stock Masuk -->
    <div id="modal-add-stock" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
            <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Stok Masuk</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600"
                    onclick="toggleModal('modal-add-stock', false)">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form method="post" action="/admin/stock-in/store" class="px-6 py-4 space-y-4">
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk</label>
                    <select id="product_id" name="product_id" required
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="" disabled selected>Pilih Produk</option>
                        <?php foreach ($products as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= esc($p['name']) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Masuk</label>
                    <input type="number" name="quantity" id="quantity" min="1" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Beli / Unit
                        (Rp)</label>
                    <input type="number" name="purchase_price" id="purchase_price" min="0" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button"
                        class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100"
                        onclick="toggleModal('modal-add-stock')">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function toggleModal(id, show = true) {
        const modal = document.getElementById(id);
        if (!modal) return;

        if (show) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        } else {
            modal.classList.remove("flex");
            modal.classList.add("hidden");
        }
    }
    </script>

    <script src="<?= base_url('js/stockin.js') ?>"></script>
</body>