document.addEventListener("DOMContentLoaded", () => {
    const modalEl = document.getElementById("modal-add-stock");
    const btnOpenModal = document.querySelector("[data-modal-target='modal-add-stock']");
    const form = document.querySelector("#modal-add-stock form"); // ambil form dari dalam modal
    const btnBatal = form?.querySelector("button[type='button']");
    const tbody = document.getElementById("stockinTbody");

    let editId = null;

    function toggleModal(show) {
        if (!modalEl) return;
        if (show) {
            modalEl.classList.remove("hidden");
            modalEl.classList.add("flex");
        } else {
            modalEl.classList.remove("flex");
            modalEl.classList.add("hidden");
        }
    }
    

    function resetForm() {
        if (!form) return;
        form.reset();
        editId = null;
    }

    // 🧾 Submit Tambah/Edit
    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const url = editId
                ? `/admin/stock-in/update/${editId}`
                : `/admin/stock-in/store`;

                fetch(url, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest" // <-- INI PENTING!
                    }
                })                
                .then(res => {
                    if (!res.ok) throw new Error("Gagal menyimpan data.");
                    return res.json();
                })
                .then(() => location.reload())
                .catch(err => alert(err.message));
        });
    }

    // 🟢 Buka Modal Tambah
    btnOpenModal?.addEventListener("click", () => {
        resetForm();
        toggleModal(true);
    });

    // 🔴 Batal Modal
    btnBatal?.addEventListener("click", () => {
        toggleModal(false);
        resetForm();
    });

    // ✏️ Edit
    document.querySelectorAll(".btnEditStockIn").forEach((btn) => {
        btn.addEventListener("click", () => {
            editId = btn.dataset.id;
            fetch(`/admin/stock-in/edit/${editId}`)
                .then(res => res.json())
                .then(data => {
                    toggleModal(true);
                    if (!form) return;
                    form.product_id.value = data.product_id;
                    form.quantity.value = data.quantity;
                    form.purchase_price.value = data.purchase_price;
                })
                .catch(() => alert("Gagal mengambil data untuk diedit."));
        });
    });

    // 🗑️ Delete
    document.querySelectorAll(".btnDeleteStockIn").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            if (confirm("Yakin ingin menghapus data stok masuk ini?")) {
                fetch(`/admin/stock-in/delete/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then((res) => {
                        if (!res.ok) throw new Error("Gagal menghapus data.");
                        return res.json();
                    })
                    .then(() => location.reload())
                    .catch((err) => alert(err.message));
            }
        });
    });
});
