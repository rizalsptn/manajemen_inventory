// ======= PRODUCTS =======
let editProdukId = null;
let produkData = [];

const produkListEl = document.getElementById("produkList");
const formProduk = document.getElementById("formProduk");
const modalProduk = document.getElementById("modalProduk");
const modalProdukTitle = document.getElementById("modalProdukTitle");
const previewGambarProduk = document.getElementById("previewGambarProduk");
const gambarProdukInput = document.getElementById("gambarProduk");
const kategoriSelectEl = document.getElementById("kategoriProduk");
document.getElementById("btnTambahProduk").addEventListener("click", () => {
    formProduk.reset();
    formProduk.removeAttribute("data-edit-id"); // pastikan ini
    document.getElementById("modalProdukTitle").textContent = "Tambah Produk";
});
const btnBatalProduk = document.getElementById("btnBatalProduk");
const searchProdukInput = document.getElementById("searchProduk");

function renderProduk(filter = "") {
    produkListEl.innerHTML = "";

    fetch("/admin/products/jsonstore")
        .then(res => res.json())
        .then(data => {
            produkData = data;
            let filtered = data;
            if (filter.trim()) {
                filtered = data.filter(p => p.name.toLowerCase().includes(filter.toLowerCase()));
            }

            if (filtered.length === 0) {
                produkListEl.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">Tidak ada produk ditemukan.</td>
                </tr>
            `;
                return;
            }

            filtered.forEach((produk) => {
                const tr = document.createElement("tr");
                tr.classList.add("hover:bg-indigo-50");
                tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <img src="${produk.image_url ?? 'https://placehold.co/100x100'}" alt="${produk.name}" class="w-16 h-16 object-cover rounded-md border border-gray-300" />
                </td>
                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">${produk.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">${produk.category_name ?? '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">Rp${Number(produk.price).toLocaleString("id-ID")}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">${produk.stock}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">${produk.min_stock}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                    <button class="btnEdit text-indigo-600 hover:text-indigo-800" data-id="${produk.id}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btnHapus text-red-600 hover:text-red-800" data-id="${produk.id}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
                produkListEl.appendChild(tr);
            });

            document.querySelectorAll(".btnEdit").forEach((btn) => {
                btn.addEventListener("click", async () => {
                    const id = btn.dataset.id;
                    const produk = produkData.find(p => p.id == id);
                    if (produk) {
                        formProduk.dataset.editId = id;
                        formProduk.namaProduk.value = produk.name;
                        formProduk.kategoriProduk.value = produk.category_id;
                        formProduk.hargaProduk.value = produk.price;
                        formProduk.stokProduk.value = produk.stock;
                        formProduk.stokMinProduk.value = produk.min_stock;
                        previewGambarProduk.src = produk.image_url ?? "https://placehold.co/400x300/png?text=Preview+Gambar+Produk";
                        modalProduk.classList.remove("hidden");
                    }
                });
            });

            document.querySelectorAll(".btnHapus").forEach((btn) => {
                btn.addEventListener("click", () => {
                    const id = btn.dataset.id;
                    if (confirm("Yakin ingin menghapus produk ini?")) {
                        fetch(`/products/delete/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-Requested-With": "XMLHttpRequest"
                            }
                        })
                        .then((res) => res.ok ? res.json() : Promise.reject("Gagal hapus"))
                        .then(() => {
                            alert("Produk berhasil dihapus");
                            renderProduk(); // reload data
                        })
                        .catch((err) => {
                            console.error(err);
                            alert("Gagal menghapus produk.");
                        });
                    }
                });
            });
        })
        .catch((err) => {
            console.error("Gagal memuat produk:", err);
            produkListEl.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-6 text-red-500">Gagal memuat data produk.</td>
            </tr>
        `;
        });
}

function openTambahProduk() {
    editProdukId = null;
    modalProdukTitle.textContent = "Tambah Produk";
    formProduk.reset();
    previewGambarProduk.src = "https://placehold.co/400x300/png?text=Preview+Gambar+Produk";
    modalProduk.classList.remove("hidden");
    gambarProdukInput.value = "";
    kategoriSelectEl.value = "";
}

function closeModalProduk() {
    modalProduk.classList.add("hidden");
    editProdukId = null;
    formProduk.reset();
    previewGambarProduk.src = "https://placehold.co/400x300/png?text=Preview+Gambar+Produk";
}

formProduk.addEventListener("submit", (e) => {
    e.preventDefault();

    const isEdit = formProduk.dataset.editId;
    const url = isEdit ? `/products/update/${formProduk.dataset.editId}` : "/products/store";

    const formData = new FormData();
    formData.append("name", formProduk.namaProduk.value.trim());
    formData.append("category_id", formProduk.kategoriProduk.value);
    formData.append("price", formProduk.hargaProduk.value);
    formData.append("stock", formProduk.stokProduk.value);
    formData.append("min_stock", formProduk.stokMinProduk.value);

    if (formProduk.gambarProduk.files.length > 0) {
        formData.append("image", formProduk.gambarProduk.files[0]);
    }

    if (isEdit) {
        formData.append("_method", "PUT");
    }

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(async (res) => {
        const data = await res.json();
        if (!res.ok) {
            throw new Error(data.error ? Object.values(data.error).join(", ") : "Terjadi kesalahan");
        }

        alert(isEdit ? "Produk berhasil diperbarui!" : "Produk berhasil ditambahkan!");
        closeModalProduk();
        formProduk.reset();
        formProduk.removeAttribute("data-edit-id"); // ✅ ini penting
        renderProduk();        
    })
    .catch((err) => {
        alert("Gagal menyimpan produk: " + err.message);
    });
});

btnTambahProduk.addEventListener("click", openTambahProduk);
btnBatalProduk.addEventListener("click", closeModalProduk);

searchProdukInput.addEventListener("input", (e) => {
    renderProduk(e.target.value);
});

gambarProdukInput.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            previewGambarProduk.src = event.target.result;
            previewGambarProduk.alt = `Gambar produk: ${file.name}`;
        };
        reader.readAsDataURL(file);
    } else {
        previewGambarProduk.src = "https://placehold.co/400x300/png?text=Preview+Gambar+Produk";
    }
});

// Initial load
renderProduk();
