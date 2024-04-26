<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.26/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <title>Pendaftaran</title>
</head>

<body>
    <style>
        .judul {
            display: flex;
            text-align: center;
            margin-bottom: 20px;
            background-color: #1a6735;
            color: #fff;
            padding: 5px;
        }

        .twajib {
            color: #4033B6;
        }

        .daftar {
            font-size: 20px;
        }

        .card-body-1 {
            padding: 10px;
        }

        @media screen and (max-width: 400px) {
            .daftar {
                font-size: 12px;
            }
        }
    </style>
    <div class="container mt-3 mb-3">
        <div class="card judul">
            <h3>Registrasi Santri Baru</h3>
            <h6>Pondok Pesantren Miftahul Ulum Karangdurin</h6>
        </div>
        <div class="col mb-3">
            <h6 class="daftar">Anda sudah mendaftar? <button id="inputButton" class="btn btn-sm btn-info">Klik
                    disini!</button></h6>
        </div>
        <form onsubmit="return validasi()" id="myForm" action="mod/pendaftaran.php" method="POST">
            <div class="card">
                <div class="card-header">Identitas Santri</div>
                <div class="card-body-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukkan Nama" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="mb-3">
                                <label for="no_nik" class="form-label">NIK</label>
                                <input type="number" class="form-control" id="no_nik" name="no_nik"
                                    placeholder="Masukkan NIK" oninput="numberInput(this)">
                            </div>
                            <div class="mb-3">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="number" class="form-control" id="nisn" name="nisn"
                                    placeholder="Masukkan NISN" oninput="numberInput(this)">
                            </div>
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="gender1"
                                                    value="pria" checked>
                                                <label class="form-check-label" for="gender1">
                                                    Pria
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="gender2"
                                                    value="wanita">
                                                <label class="form-check-label" for="gender2">
                                                    Wanita
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="anak_ke" class="form-label">Anak Ke</label>
                                        <input type="number" class="form-control" id="anak_ke" name="anak_ke"
                                            placeholder="Anak Ke" oninput="numberInput(this)">
                                    </div>
                                    <div class="col">
                                        <label for="jumlah_saudara" class="form-label">Jumlah Saudara</label>
                                        <input type="number" class="form-control" id="jumlah_saudara"
                                            name="jumlah_saudara" placeholder="Jumlah Saudara"
                                            oninput="numberInput(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="gol_darah" class="form-label">Golongan Darah</label>
                                        <input type="text" class="form-control" id="gol_darah" name="gol_darah"
                                            placeholder="Golongan Darah" oninput="convertToUpperCase(this)">
                                    </div>
                                    <div class="col">
                                        <label for="dom" class="form-label">Domisili</label>
                                        <input type="text" class="form-control" id="dom" name="dom"
                                            placeholder="Domisili" oninput="convertToUpperCase(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                    placeholder="Masukkan Tempat Lahir" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tanggal_lahir" class="form-label">Tanggal</label>
                                    <input type="number" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                        placeholder="Tanggal" oninput="numberTanggal(this)">
                                </div>
                                <div class="col">
                                    <label for="bulan_lahir" class="form-label">Bulan</label>
                                    <input type="number" class="form-control" id="bulan_lahir" name="bulan_lahir"
                                        placeholder="Bulan" oninput="numberBulan(this)">
                                </div>
                                <div class="col">
                                    <label for="tahun_lahir" class="form-label">Tahun</label>
                                    <input type="number" class="form-control" id="tahun_lahir" name="tahun_lahir"
                                        placeholder="Tahun" oninput="numberInput(this)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="diniyah" class="form-label">Tujuan Kelas Diniyah</label>
                                    <select name="diniyah" id="diniyah" name="diniyah" class="form-select">
                                        <option value="shifir">Shifir</option>
                                        <option value="pk">Program Khusus</option>
                                        <option value="ibtidaiyah">Ibtidaiyah</option>
                                        <option value="tsanawiyah">Tsanawiyah</option>
                                        <option value="aliyah">Aliyah</option>
                                    </select>
                                </div>
                                <div class="col" id="tujuan_kelas_din">
                                    <label for="kelas_din" class="form-label">Kelas</label>
                                    <input type="number" class="form-control" id="kelas_din" name="kelas_din"
                                        placeholder="Kelas">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="ammiyah" class="form-label">Tujuan Kelas Ammiyah</label>
                                    <select name="ammiyah" id="ammiyah" class="form-select">
                                        <option value="tk">TK</option>
                                        <option value="mi">MI</option>
                                        <option value="mts">MTs</option>
                                        <option value="smp">SMP</option>
                                        <option value="smk">SMK</option>
                                        <option value="ma">MA</option>
                                        <option value="mahasiswa">Perguruan Tinggi</option>
                                    </select>
                                </div>
                                <div class="col" id="tujuan_kelas_am">
                                    <label for="kelas_am" class="form-label">Kelas</label>
                                    <input type="number" class="form-control" id="kelas_am" name="kelas_am"
                                        placeholder="Kelas">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-1">
                <div class="card-header">Identitas Wali</div>
                <div class="card-body-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kk" class="form-label">No. KK</label>
                                <input type="number" class="form-control" id="kk" name="kk"
                                    placeholder="Masukkan Nomor KK" oninput="numberInput(this)">
                            </div>
                            <div class="mb-3">
                                <label for="nik_ayah" class="form-label">NIK Wali</label>
                                <input type="number" class="form-control" id="nik_ayah" name="nik_ayah"
                                    placeholder="Masukkan NIK Ayah" oninput="numberInput(this)">
                            </div>
                            <div class="mb-3">
                                <label for="nama_ayah" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah"
                                    placeholder="Masukkan Nama Ayah" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir_ayah" name="tempat_lahir_ayah"
                                    placeholder="Masukkan Tempat Lahir" oninput="convertToUpperCase(this)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tanggal_lahir_ayah" class="form-label">Tanggal</label>
                                    <input type="number" class="form-control" id="tanggal_lahir_ayah"
                                        name="tanggal_lahir_ayah" placeholder="Tanggal" oninput="numberTanggal(this)">
                                </div>
                                <div class="col">
                                    <label for="bulan_lahir_ayah" class="form-label">Bulan</label>
                                    <input type="number" class="form-control" id="bulan_lahir_ayah"
                                        name="bulan_lahir_ayah" placeholder="Bulan" oninput="numberBulan(this)">
                                </div>
                                <div class="col">
                                    <label for="tahun_lahir_ayah" class="form-label">Tahun</label>
                                    <input type="number" class="form-control" id="tahun_lahir_ayah"
                                        name="tahun_lahir_ayah" placeholder="Tahun" oninput="numberInput(this)">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_ayah" class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah"
                                    placeholder="Pekerjaan" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="mb-3">
                                <label for="pendidikan_ayah" class="form-label">Pendidikan</label>
                                <input type="tex" class="form-control" id="pendidikan_ayah" name="pendidikan_ayah"
                                    placeholder="Pendidikan Terakhir" oninput="convertToUpperCase(this)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-1">
                <div class="card-header">Identitas Ibu</div>
                <div class="card-body-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nik_ibu" class="form-label">NIK Ibu</label>
                                <input type="number" class="form-control" id="nik_ibu" name="nik_ibu"
                                    placeholder="Masukkan NIK Ibu" oninput="numberInput(this)">
                            </div>
                            <div class="mb-3">
                                <label for="nama_ibu" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu"
                                    placeholder="Masukkan Nama Ibu" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir_ibu" name="tempat_lahir_ibu"
                                    placeholder="Masukkan Tempat Lahir Ibu" oninput="convertToUpperCase(this)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="tanggal_lahir_ibu" class="form-label">Tanggal</label>
                                    <input type="number" class="form-control" id="tanggal_lahir_ibu"
                                        name="tanggal_lahir_ibu" placeholder="Tanggal" oninput="numberTanggal(this)">
                                </div>
                                <div class="col">
                                    <label for="bulan_lahir_ibu" class="form-label">Bulan</label>
                                    <input type="number" class="form-control" id="bulan_lahir_ibu"
                                        name="bulan_lahir_ibu" placeholder="Bulan" oninput="numberBulan(this)">
                                </div>
                                <div class="col">
                                    <label for="tahun_lahir_ibu" class="form-label">Tahun</label>
                                    <input type="number" class="form-control" id="tahun_lahir_ibu"
                                        name="tahun_lahir_ibu" placeholder="Tahun" oninput="numberInput(this)">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_ibu" class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu"
                                    placeholder="Pekerjaan" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="mb-3">
                                <label for="pendidikan_ibu" class="form-label">Pendidikan</label>
                                <input type="text" class="form-control" id="pendidikan_ibu" name="pendidikan_ibu"
                                    placeholder="Pendidikan Terakhir" oninput="convertToUpperCase(this)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-1">
                <div class="card-header">Informasi Data</div>
                <div class="card-body-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dusun" class="form-label">Dusun</label>
                                <input type="text" class="form-control" id="dusun" name="dusun"
                                    placeholder="Masukkan Dusun" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="mb-3">
                                <label for="desa" class="form-label">Desa/Kelurahan</label>
                                <input type="text" class="form-control" id="desa" name="desa"
                                    placeholder="Masukkan Desa" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                    placeholder="Masukkan kecamatan" oninput="convertToUpperCase(this)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kabupaten" class="form-label">Kabupaten</label>
                                <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                    placeholder="Masukkan kabupaten" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="mb-3">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" name="provinsi"
                                    placeholder="Masukkan Provinsi" oninput="convertToUpperCase(this)">
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp"
                                    placeholder="Masukkan No HP" oninput="numberInput(this)">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>



    <!-- <script src="../assets/js/input.js"></script>
    <script src="../assets/js/alert.js"></script> -->
    <script>
        function convertToUpperCase(input) {
            let value = input.value;
            let upperCaseValue = value.toUpperCase();
            input.value = upperCaseValue;
        }

        function numberTanggal(input) {
            let value = input.value;

            let numericValue = value.replace(/\D/g, '');

            if (numericValue > 31) {
                input.value = "01";
            } else {
                numericValue = numericValue.replace(/^0+/, '');

                if (numericValue.length === 1) {
                    numericValue = "0" + numericValue;
                }
                input.value = numericValue;
            }
        }

        function numberBulan(input) {
            let value = input.value;

            let numericValue = value.replace(/\D/g, '');

            if (numericValue > 12) {
                input.value = "01";
            } else {
                numericValue = numericValue.replace(/^0+/, '');
                if (numericValue.length === 1) {
                    numericValue = "0" + numericValue;
                }
                input.value = numericValue;
            }
        }

        function numberInput(input) {
            let value = input.value;
            let numericValue = value.replace(/\D/g, '');
            input.value = numericValue;
        }

        let diniyah = document.getElementById('diniyah');
        let tujuan_kelas_din = document.getElementById('tujuan_kelas_din');
        tujuan_kelas_din.style.display = 'none'
        diniyah.addEventListener('change', function () {
            let selectedValue = diniyah.value;
            if (selectedValue !== 'shifir' && selectedValue !== 'pk') {
                tujuan_kelas_din.style.display = 'block'
            } else {
                tujuan_kelas_din.style.display = 'none'
            }
        });

        let ammiyah = document.getElementById('ammiyah');
        let tujuan_kelas_am = document.getElementById('tujuan_kelas_am');
        tujuan_kelas_am.style.display = 'none'
        ammiyah.addEventListener('change', function () {
            let selectedValue = ammiyah.value;
            if (selectedValue !== 'tk') {
                tujuan_kelas_am.style.display = 'block'
            } else {
                tujuan_kelas_am.style.display = 'none'
            }
        });

        function showToast(message) {
            toastr.options = {
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "timeOut": "3000"
            };
            toastr.error(message);
        }
        function showToastS(message) {
            toastr.options = {
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "timeOut": "3000"
            };
            toastr.success(message);
        }

        function validasi() {
            const validations = [
                { id: 'nama', message: 'Nama harus diisi' },
                { id: 'no_nik', message: 'NIK harus diisi' },
                // { id: 'nisn', message: 'NISN harus diisi' },
                { id: 'anak_ke', message: 'Anak ke berapa?' },
                { id: 'jumlah_saudara', message: 'Jumlah saudaranya?' },
                // { id: 'gol_darah', message: 'Golongan darah loh!' },
                { id: 'dom', message: 'Domisili disii!' },
                { id: 'tempat_lahir', message: 'Tempat lahir Santri harus diisi' },
                { id: 'tanggal_lahir', message: 'Tanggal Lahir harus diisi' },
                { id: 'bulan_lahir', message: 'Bulan Lahir harus diisi' },
                { id: 'tahun_lahir', message: 'Tahun Lahir harus diisi' },
                { id: 'diniyah', message: 'Tujuan Kelas Diniyah harus dipilih' },
                { id: 'ammiyah', message: 'Tujuan Kelas Ammiyah harus dipilih' },
                { id: 'kk', message: 'No. KK harus diisi' },
                { id: 'nik_ayah', message: 'NIK wali harus diisi' },
                { id: 'nama_ayah', message: 'Nama Wali harus diisi' },
                { id: 'tempat_lahir_ayah', message: 'Tempat lahir wali harus diisi' },
                { id: 'tanggal_lahir_ayah', message: 'Tanggal lahir wali harus diisi' },
                { id: 'bulan_lahir_ayah', message: 'Bulan lahir wali harus diisi' },
                { id: 'tahun_lahir_ayah', message: 'Tahun lahir wali harus diisi' },
                { id: 'pekerjaan_ayah', message: 'Pekerjaan Wali harus diisi' },
                { id: 'pendidikan_ayah', message: 'Pendidikan Wali harus diisi' },
                { id: 'nik_ibu', message: 'NIK Ibu harus diisi' },
                { id: 'nama_ibu', message: 'Nama Ibu harus diisi' },
                { id: 'tempat_lahir_ibu', message: 'Tempat lahir Ibu harus diisi' },
                { id: 'tanggal_lahir_ibu', message: 'Tanggal lahir Ibu harus diisi' },
                { id: 'bulan_lahir_ibu', message: 'Bulan lahir Ibu harus diisi' },
                { id: 'tahun_lahir_ibu', message: 'Tahun lahir Ibu harus diisi' },
                { id: 'pekerjaan_ibu', message: 'Pekerjaan Ibu harus diisi' },
                { id: 'pendidikan_ibu', message: 'Pendidikan Ibu harus diisi' },
                { id: 'dusun', message: 'Dusun jangan sampai lupa' },
                { id: 'desa', message: 'Desa-nya bro!' },
                { id: 'kecamatan', message: 'Kecamatan-nya bro!' },
                { id: 'kabupaten', message: 'Kabupaten jangan sampai lupa' },
                { id: 'provinsi', message: 'Provinsi disii yo' },
                { id: 'no_hp', message: 'Nomer Hp jangan sampai terlewatkan' },
            ];

            let semuaValid = true;

            for (const validation of validations) {
                const element = document.getElementById(validation.id);
                const value = element.value.trim();

                if (value === '') {
                    showToast(validation.message);
                    semuaValid = false;
                    break;
                }

                if (validation.condition && validation.condition()) {
                    showToast(validation.message);
                    semuaValid = false;
                    break;
                }
            }

            let diniyah = document.getElementById('diniyah').value;
            let kelas_din = document.getElementById('kelas_din').value;
            if (diniyah !== "shifir" && diniyah !== "pk" && kelas_din === "") {
                showToast("Kelas Diniyah harus diisi");
                semuaValid = false;
            }

            let ammiyah = document.getElementById('ammiyah').value;
            let kelas_am = document.getElementById('kelas_am').value;
            if (ammiyah !== "tk" && kelas_am === "") {
                showToast("Kelas Ammiyah harus diisi");
                semuaValid = false;
            }

            let genderInputs = document.getElementsByName('gender');
            let genderSelected = false;
            for (let i = 0; i < genderInputs.length; i++) {
                if (genderInputs[i].checked) {
                    genderSelected = true;
                    break;
                }
            }

            if (!genderSelected) {
                showToast('Pilih jenis kelamin Anda');
                semuaValid = false;
            }

            if (semuaValid) {
                kirimForm();
            } else {
                return false;
            }
            return false;
        }

        function kirimForm() {
            let form = document.getElementById("myForm");
            let formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location = "cek-data.php?id=" + data.id;
                        // console.log("ok")
                    } else {
                        showToast(data.message);
                    }
                })
                .catch(error => {
                    // console.error('Terjadi kesalahan:', error);
                    showToast('Terjadi kesalahan saat mengirim data.');
                });
        }
    </script>
    <script>
        document.getElementById('inputButton').addEventListener('click', async function () {
            const { value: inputValue } = await Swal.fire({
                title: 'ID Registrasi',
                input: 'text',
                inputLabel: 'Masukkan ID',
                // inputPlaceholder: 'Enter your input',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (input) => {
                    if (!input) {
                        Swal.showValidationMessage('Input cannot be empty');
                    }
                    return input;
                }
            });

            if (inputValue) {
                fetch('mod/cekId.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ input: inputValue })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'ok') {
                            window.location = `cek-data.php?id=${inputValue}`
                        } else {
                            Swal.fire({
                                title: 'error',
                                text: 'ID yang anda masukkan tidak valid',
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while processing your request',
                            icon: 'error'
                        });
                    });
            }
        });
    </script>
</body>

</html>