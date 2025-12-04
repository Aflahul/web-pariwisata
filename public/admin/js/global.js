// =======================
// INIT MODALS
// =======================
let modalConfirm = new bootstrap.Modal(document.getElementById('modalConfirm'));
let modalAlert   = new bootstrap.Modal(document.getElementById('modalAlert'));

const CSRF = document.querySelector('meta[name="csrf-token"]').content;


// =======================
// UNIVERSAL CONFIRM MODAL
// =======================
function showConfirm(message, onYes) {
    document.getElementById('modalConfirmBody').innerText = message;

    let yesBtn = document.getElementById('modalConfirmYes');
    let newBtn = yesBtn.cloneNode(true);
    yesBtn.parentNode.replaceChild(newBtn, yesBtn);

    newBtn.addEventListener('click', function () {
        modalConfirm.hide();
        if (typeof onYes === 'function') onYes();
    });

    modalConfirm.show();
}


// =======================
// UNIVERSAL ALERT MODAL
// =======================
function showAlert(title, message) {
    document.getElementById('modalAlertTitle').innerText = title || "Informasi";
    document.getElementById('modalAlertBody').innerText  = message;
    modalAlert.show();
}


// =======================
// GLOBAL DELETE HANDLER
// tombol class: .btn-delete
// data-url=""      → URL DELETE
// data-msg=""      → pesan konfirmasi
// data-body=""     → JSON body untuk DELETE
// data-remove=""   → selector element yang akan dihapus
// =======================
document.addEventListener("click", async e => {

    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const url = btn.dataset.url;
    let body = {};

    if (btn.dataset.body) {
        try { body = JSON.parse(btn.dataset.body); } catch (_) {}
    }

    const msg = btn.dataset.msg || "Yakin hapus data ini?";

    showConfirm(msg, async () => {

        let res = await fetch(url, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": CSRF
            },
            body: Object.keys(body).length ? JSON.stringify(body) : null
        });

        let json = null;
        try { json = await res.json(); } catch (_) {}

        if (res.ok && json && json.success) {

            if (btn.dataset.remove) {
                const target = btn.closest(btn.dataset.remove);
                if (target) target.remove();
            }

            showAlert("Sukses", "Data berhasil dihapus.");

        } else {
            showAlert("Gagal", "Gagal menghapus data.");
        }
    });

});
