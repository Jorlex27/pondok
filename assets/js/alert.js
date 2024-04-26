$(document).ready(function () {
  function showAlert(type, message) {
    toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };

    switch (type) {
      case "success":
        toastr.options.class = "toast-success";
        toastr.success(message, "Success");
        break;
      case "error":
        toastr.options.class = "toast-error";
        toastr.error(message, "Error");
        break;
      case "warning":
        toastr.options.class = "toast-warning";
        toastr.warning(message, "Warning");
        break;
      default:
        toastr.info(message);
    }
    setTimeout(function () {
      removeStatusParameterFromURL();
    }, 5000);
  }

  const status = {
    insert: { text: "Data berhasil masok.", type: "success" },
    noinsert: { text: "tak masok kah.", type: "error" },
    editok: { text: "Masok", type: "success" },
    noedit: { text: "jek tak masok", type: "error" },
    deleteok: { text: "adek lah", type: "success" },
    nodelete: { text: "Tak ning hapus", type: "error" },
    delete: { text: "mareh e hapus", type: "success" },
    import: { text: "Data berhasil di import.", type: "success" },
    noimport: { text: "Tidak bisa melakukan import data.", type: "error" },
    update: { text: "Data telah diupdate", type: "success" },
    noupdate: { text: "Tidak dapat melakukan operasi update", type: "error" },
    reset: { text: "Data Telah direset", type: "success" },
    noreset: { text: "Tidak dapat melakukan operasi reset data", type: "error" },
    nodata: { text: "Database masih kosong!", type: "error" },
    noimport1: { text: "Database error", type: "error" },
    cekok: { text: "Alhamdulillah, masuk kappi", type: "success" },
    taks: { text: "Reminder baru telah masuk", type: "success" },
    notaks: { text: "Reminder tidak masuk", type: "error" },
    taks2: { text: "Reminder telah dihapus", type: "success" },
    notaks2: { text: "Reminder tidak bisa dihapus", type: "error" },
    adek: { text: "Ga ada datanya bro", type: "error" },
    mupdate: { text: "Update berhasil!", type: "success" },
    mtakupdate: { text: "Tak e update", type: "error" },
    mmasuk: { text: "Data berhasil masuk!", type: "success" },
    mtakmasuk: { text: "Tak masok", type: "error" },
    ukuran: { text: "Ukuran foto melebihi batas. Ukuran foto 200 kb", type: "error" },
    type: { text: "Type image tidak didukung!", type: "error" },
    fotoerror: { text: "Foto tak masok!", type: "error" },
    noID: { text: "Cek kembali! ID Sentral masih ada yang kosong!", type: "error" },
    back: { text: "Data sudah dikembalikan", type: "success" },
    noback: { text: "Data tidak bisa di restore", type: "error" },
    binsert: { text: "Billing masok", type: "success" },
    pay_masok: { text: "Pembayaran masok", type: "success" },
    no_insert: { text: "Pembayaran tak masok", type: "error" },
    ada_data: { text: "Sudah ada", type: "error" },
    bupdate: { text: "Bill berhasil diupdate", type: "success" },
    no_update: { text: "Bill tak update", type: "error" },
    no_update_pay1: { text: "Pembayaran 1 tak ning update", type: "error" },
    no_data: { text: "Ga ada data", type: "error" },
    bdelete: { text: "Bill berhasil dihapus", type: "success" },
    bno_delete: { text: "Bill tak ning hapus", type: "error" },
    no: { text: "Ga boleh kesini", type: "error" },
    kurang_pay: { text: "Pembayaran kurang", type: "error" },
    mhapus: { text: "APPS Berhasil di hapus", type: "success" },
    mtakhapus: { text: "APPS tidak bisa di hapus", type: "error" },
    no_update_pay: { text: "Tak ning obe", type: "error" },
    Pay_isNull: { text: "Pembayaran tidak boleh kosong", type: "error" },
    diskon_invalid: { text: "Diskon tidak valid", type: "error" },
    Pay_lunas: { text: "Pembayaran sudah lunas, tak usa obe!", type: "error" },
    id_invalid: { text: "ID Tidak valid!", type: "error" },
    pay_update: { text: "Pembayaran berhasil di update", type: "success" },
  };
  
  const alertType = getParameterByName("status");
  
  if (alertType && status[alertType]) {
    const { text, type } = status[alertType];
    showAlert(type, text);
  }
  
});

function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");
  const results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}
function removeStatusParameterFromURL() {
  const url = window.location.href;
  const updatedURL = url.replace(/[?&]status(=([^&#]*)|&|#|$)/, "");
  window.history.replaceState({}, document.title, updatedURL);
}
