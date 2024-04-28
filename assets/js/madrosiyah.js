const selectAllCheckbox = document.getElementById("selectAll");
const itemCheckboxes = document.querySelectorAll(".itemCheckbox");
const dropdown = document.querySelector(".dropdown");
const itemCountSpan = dropdown.querySelector("#itemCount");

let selectedCount = 0;

selectAllCheckbox.addEventListener("change", function () {
  itemCheckboxes.forEach((checkbox) => {
    checkbox.checked = selectAllCheckbox.checked;
  });
  updateSelectedCount();
});

itemCheckboxes.forEach((checkbox) => {
  checkbox.addEventListener("change", function () {
    updateSelectedCount();
    if (!this.checked) {
      selectAllCheckbox.checked = false;
    } else {
      const allChecked = Array.from(itemCheckboxes).every(
        (checkbox) => checkbox.checked
      );
      selectAllCheckbox.checked = allChecked;
    }
  });
});

function updateSelectedCount() {
  selectedCount = Array.from(itemCheckboxes).filter(
    (checkbox) => checkbox.checked
  ).length;
  updateDropdownContent();
  const itemsInput = document.getElementById("items");
  itemsInput.value = selectedCount;
  const kelas = document.getElementById("kelas-valid").value;
  if (kelas == '') {
    selectAllCheckbox.checked = false;
    itemCheckboxes.forEach((checkbox) => {
      checkbox.checked = false;
    });
    dropdown.style.display = "none";
    toggleCheckbox();
  }
}

function updateDropdownContent() {
  const itemCountText = selectedCount > 0 ? `Item : ${selectedCount}` : "";
  itemCountSpan.textContent = itemCountText;

  if (selectedCount > 0) {
    dropdown.style.display = "block";
  } else {
    dropdown.style.display = "none";
  }
}

function toggleCheckbox(kelas, id) {
  var checkboxall = document.getElementById("selectAll");
  var checkbox = document.getElementById("itemCheckbox" + id);
  var dropdown = document.getElementById("dropdown");
  if (!kelas) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Pilih kelas dulu!',
    }).then(function () {
      checkboxall.checked = false;
      checkbox.checked = false;
      dropdown.style.display = "none";
    });
  }
}
function kelas_br(act, n_id, kolom, kelas_in, Apdata, data) {
  Swal.fire({
    title: 'Mau di naikkan ke kelas berapa?',
    input: 'text',
    inputPlaceholder: 'Masukkan kelas',
    showCancelButton: true,
    confirmButtonText: 'Simpan',
    cancelButtonText: 'Batal',
    inputValidator: (value) => {
      if (!value) {
        return 'Kelas tidak boleh kosong!'
      } else if (!/^[0-9A-Z]+-[A-Z]$/.test(value)) {
        return 'Kelas harus dalam format angka-tanda (contoh: 2-A, XI-B)';
      } else if (value < kelas_in) {
        return 'Kelas tidak boleh kurang dari ' + kelas_in;
      }
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const kelas = result.value;
      if (kelas) {
        document.getElementById('kelas-input').value = kelas;
        showMoveAlert(act, n_id, kolom, kelas_in, Apdata, data)
      }
    }
  });
}

function showDeleteAlert(actionType, n_id, kolom, kelas, Apdata, data) {
  Swal.fire({
    title: "Apakah Anda yakin?",
    text: selectedCount + " Data akan drop dari " + Apdata,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Ya",
    cancelButtonText: "Batal",
  }).then((result) => {
    if (result.isConfirmed) {
      submitForm(actionType, n_id, kolom, kelas, Apdata, data);
    }
  });
}

function showMoveAlert(actionType, n_id, kolom, kelas, Apdata, data) {
  Swal.fire({
    title: "Apakah Anda yakin?",
    text: selectedCount + " Data yang telah dipilih akan naik kelas.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya",
    cancelButtonText: "Batal",
  }).then((result) => {
    if (result.isConfirmed) {
      submitForm(actionType, n_id, kolom, kelas, Apdata, data);
    }
  });
}

function submitForm(actionType, n_id, kolom, kelas, Apdata, data) {
  const form = document.getElementById("formAction");
  form.action = form.action + "?Apdata=" + Apdata + "&kelas=" + kelas + "&actionType=" + actionType + "&n_id=" + n_id + "&kolom=" + kolom + "&data=" + data;
  form.submit();
}

function gender(gender) {
  var currentURL = window.location.href;
  var paramName = "gender";
  var paramValue = gender;
  if (currentURL.indexOf(paramName + '=') !== -1) {
    var updatedURL = currentURL.replace(new RegExp(paramName + '=([^&]+)'), paramName + '=' + paramValue);
  } else {
    var separator = currentURL.indexOf('?') !== -1 ? '&' : '?';
    var updatedURL = currentURL + separator + paramName + '=' + paramValue;
  }
  window.location.href = updatedURL;
};

function updateKelas(kelas) {
  var currentURL = window.location.href;
  var paramName = "kelas";
  var paramValue = kelas;
  if (currentURL.indexOf(paramName + '=') !== -1) {
    var updatedURL = currentURL.replace(new RegExp(paramName + '=([^&]+)'), paramName + '=' + paramValue);
  } else {
    var separator = currentURL.indexOf('?') !== -1 ? '&' : '?';
    var updatedURL = currentURL + separator + paramName + '=' + paramValue;
  }
  window.location.href = updatedURL;
};

function reloadKelas(kelas) {
  var btn = document.getElementById('btnReloadKelas');
  if (kelas === '') {
    btn.disabled = true;
  } else {
    btn.disabled = false;
    var currentURL = window.location.href;
    var paramNameKelas = "kelas";
    var paramNameGender = "gender";

    if (currentURL.indexOf('?' + paramNameKelas + '=') !== -1 || currentURL.indexOf('&' + paramNameKelas + '=') !== -1) {
      currentURL = currentURL.replace(new RegExp('[?&]' + paramNameKelas + '=([^&]+)'), '');
    }

    if (currentURL.indexOf('?' + paramNameGender + '=') !== -1 || currentURL.indexOf('&' + paramNameGender + '=') !== -1) {
      currentURL = currentURL.replace(new RegExp('[?&]' + paramNameGender + '=([^&]+)'), '');
    }

    window.location.href = currentURL;
  }
}


// function HapusData(act, n_id, id, kelas, Apdata, link, dari, ke) {
//   Swal.fire({
//     title: "Apakah Anda yakin?",
//     text: "Data akan dihapus dari " + Apdata,
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "Ya",
//     cancelButtonText: "Batal",
//   }).then((result) => {
//     if (result.isConfirmed) {
//       window.location = "../mod/data/delete?act=" + act + "&n_id=" + n_id + "&id=" + id + "&kelas=" + kelas + "&Apdata=" + Apdata + "&link=" + link  + "&dari=" + dari + "&ke=" + ke;
//     }
//   })
// }

function HapusData(n_id, id, kelas, Apdata, link) {
  Swal.fire({
    title: "Apakah Anda yakin?",
    text: "Data akan dihapus dari " + Apdata,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya",
    cancelButtonText: "Batal",
    input: 'select',
    inputOptions: {
      'Non Aktif': 'Non Aktif',
      'Boyong': 'Boyong',
      'Drop Out': 'Drop Out'
    },
    inputPlaceholder: 'Pilih tindakan',
    inputValidator: (value) => {
      if (!value) {
        return 'Anda harus memilih tindakan';
      }
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const choice = Swal.getInput().value;
      if (choice) {
        window.location = "../mod/data/opt-dell?n_id=" + n_id + "&id=" + id + "&kelas=" + kelas + "&Apdata=" + Apdata + "&link=" + link + "&choice=" + choice;
      }
    }
  });
}
