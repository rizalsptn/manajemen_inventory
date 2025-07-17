document.addEventListener("DOMContentLoaded", () => {
    let editKategoriId = null;
    let kategoriData = [];

    const kategoriListEl = document.getElementById("kategoriList");
    const formKategori = document.getElementById("formKategori");
    const modalKategori = document.getElementById("modalKategori");
    const searchKategoriInput = document.getElementById("searchKategori");
    const btnTambahKategori = document.getElementById("btnTambahKategori");
    const btnBatalKategori = document.getElementById("btnBatalKategori");
    const btnLihatKategori = document.getElementById("modalTableKategori");
    const kategoriSelectEl = document.getElementById("kategoriProduk");
    const modalKategoriTitle = document.getElementById("modalKategoriTitle");
    const modalFormKategori = document.getElementById("modalFormKategori");

    function renderKategori(filter = "") {
        if (!kategoriListEl) return;
        kategoriListEl.innerHTML = "";

        const filtered = kategoriData.filter((k) =>
            k.name.toLowerCase().includes(filter.toLowerCase())
        );

        if (filtered.length === 0) {
            kategoriListEl.innerHTML = `
                <tr>
                    <td colspan="2" class="text-center py-6 text-gray-500">Tidak ada kategori ditemukan.</td>
                </tr>`;
            return;
        }

        filtered.forEach((kategori) => {
            const tr = document.createElement("tr");
            tr.classList.add("hover:bg-indigo-50");
            tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-gray-800 font-semibold">${kategori.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                    <button data-id="${kategori.id}" class="btnEditKategori text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></button>
                    <button data-id="${kategori.id}" class="btnHapusKategori text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i></button>
                </td>`;
            kategoriListEl.appendChild(tr);
        });

        // Bind ulang event listener setelah render ulang
        document.querySelectorAll(".btnEditKategori").forEach((btn) => {
            btn.addEventListener("click", () => {
                const id = parseInt(btn.dataset.id);
                const kategori = kategoriData.find((k) => k.id === id);
                if (!kategori) return alert("Kategori tidak ditemukan");
        
                editKategoriId = id;
                modalKategoriTitle.textContent = "Edit Kategori";
                formKategori.namaKategori.value = kategori.name;
                modalFormKategori.classList.remove("hidden");
            });
        });
        

        document.querySelectorAll(".btnHapusKategori").forEach((btn) => {
            btn.addEventListener("click", () => {
                const id = parseInt(btn.dataset.id);
                if (!confirm("Yakin ingin menghapus kategori ini?")) return;
        
                fetch(`/admin/categories/delete/${id}`, {
                    method: "DELETE",
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                })
                    .then((res) => res.ok ? res.json() : Promise.reject("Gagal hapus"))
                    .then(() => {
                        alert("Kategori berhasil dihapus");
                        renderKategoriSelect(); // reload daftar dan dropdown
                    })
                    .catch((err) => {
                        console.error(err);
                        alert("Gagal menghapus kategori.");
                    });
            });
        });
        
    }

    function renderKategoriSelect() {
        if (!kategoriSelectEl) return;
    
        kategoriSelectEl.innerHTML = '<option value="" disabled selected>Pilih kategori</option>';
    
        fetch('/admin/categories/jsonList')
            .then(res => res.json())
            .then(data => {
                kategoriData = data;
                data.forEach((kategori) => {
                    const option = document.createElement("option");
                    option.value = kategori.id;
                    option.textContent = kategori.name;
                    kategoriSelectEl.appendChild(option);
                });

                renderKategori(); // juga render tabel
            })
            .catch(err => {
                console.error("Gagal memuat kategori:", err);
            });
    }

    function openTambahKategori() {
        editKategoriId = null;
        modalKategoriTitle.textContent = "Tambah Kategori";
        formKategori.reset();
        modalKategori.classList.remove("hidden");
    }

    function closeModalKategori() {
        modalKategori.classList.add("hidden");
        formKategori.reset();
        editKategoriId = null;
    }

    formKategori.addEventListener("submit", (e) => {
        e.preventDefault();
    
        const nama = formKategori.namaKategori.value.trim();
        if (!nama) {
            alert("Nama kategori wajib diisi.");
            return;
        }
    
        const url = editKategoriId
            ? `/admin/categories/update/${editKategoriId}`
            : "/admin/categories/jsonStore";
    
        fetch(url, {
            method: "POST", // tetap POST
            headers: { "Accept": "application/json" },
            body: new URLSearchParams({ namaKategori: nama }),
        })
            .then(async (res) => {
                if (!res.ok) {
                    const error = await res.json();
                    throw new Error(error.error || "Gagal menyimpan kategori");
                }
                return res.json();
            })
            .then(() => {
                renderKategoriSelect(); // refresh daftar dan select
                modalFormKategori.classList.add("hidden");
                formKategori.reset();
                editKategoriId = null;
            })
            .catch((err) => alert(err.message));
    });
    

    btnLihatKategori?.addEventListener("click", () => {
        modalKategori.classList.remove("hidden");
        renderKategori();
    });


    btnTambahKategori?.addEventListener("click", () => {
        editKategoriId = null;
        modalKategoriTitle.textContent = "Tambah Kategori";
        formKategori.reset();
        modalFormKategori.classList.remove("hidden"); // tampilkan modal form
    });

    btnBatalKategori?.addEventListener("click", () => {
        modalFormKategori.classList.add("hidden");
        formKategori.reset();
        editKategoriId = null;
    });
    
    

    btnTambahKategori?.addEventListener("click", openTambahKategori);
    btnBatalKategori?.addEventListener("click", closeModalKategori);
    searchKategoriInput?.addEventListener("input", (e) => renderKategori(e.target.value));

    renderKategoriSelect();
});
