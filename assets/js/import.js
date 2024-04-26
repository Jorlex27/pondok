var nameInput = document.getElementById("jenjang");
var idInput = document.getElementById("id_m");

nameInput.addEventListener("input", function () {
    var selectedOption = null;
    var inputValue = this.value;
    var options = document.querySelectorAll("#master-data option");
    options.forEach(function (option) {
        if (option.textContent === inputValue) {
            selectedOption = option;
            return;
        }
    });

    if (selectedOption) {
        idInput.value = selectedOption.getAttribute("data-id");
    } else {
        idInput.value = "";
    }
});

function tambahJ_Kelas(id) {
    Swal.fire({
        icon: 'info',
        title: 'Nama Kelas',
        input: 'text',
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Input harus diisi!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const inputValue = result.value;
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../mod/setting/add-kelas?id=" + id, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.success
                        }).then (function(){
                            location.reload();
                        });
                    } else {
                        const response = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error
                        });
                    }
                }
            };
            const data = `kelas=${inputValue}`;
            xhr.send(data);
        }
    });
}

function hapus(id) {
    Swal.fire({
        title: 'Yakin mau dihapus?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../mod/setting/deleteUser?id=' + id;
        }
    });
}

function remove(id, act) {
    if (act == 'all') {
        alert(id, act, "ehapuseh kappi?!")
    }
}

function alert(id, act, alert) {
    Swal.fire({
        title: alert,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../mod/setting/delete-kelas?id=' + id + '&action=' + act;
        }
    });
}

function ResetData(name, kolom) {
    Swal.fire({
        title: 'Semua data ' + name + ' akan dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../mod/setting/reset?name=' + name + '&kolom=' + kolom;
        }
    });
}