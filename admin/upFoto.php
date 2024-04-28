<?php
session_start();
$judul = "Unggah Foto";
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';
?>
<style>
    .container {
        max-height: 500px;
        margin: 20px 30px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        z-index: 0;
        overflow-x: auto;
    }

    .custom-preview {
        max-width: 100%;
        height: auto;
        padding: 5px;
    }


    @media (min-width: 12in) {
        .container1 {
            max-height: 430px;
        }
    }

    @media (max-width: 768px) {
        .container1 {
            max-height: 100%;
        }
    }

    @media (min-width: 14in) {
        .container1 {
            max-height: 500px;
        }
    }
</style>

<div class="container">
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#oversizedModal" id="openModalButton">
        Lihat Foto Oversized
    </button>
    <form action="../import/uploadFoto" class="dropzone" id="my-dropzone"></form>


    <!-- Modal -->

    <div class="modal fade" id="oversizedModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Foto Oversized</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="imageGrid"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
require '../helper/toastr.php';
require '../tem/foot.php';

?>
<script src="../assets/js/script2.js"></script>
<script src="../assets/js/repag.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    var oversizedFiles = [];

    Dropzone.options.myDropzone = {
        paramName: "file",
        maxFilesize: 0.2,
        addRemoveLinks: true,
        dictRemoveFile: "Hapus file",
        success: function(file, response) {
            // File diunggah berhasil
        },
        error: function(file, errorMessage) {
            var fileSizeInKB = file.size / 1024;

            if (fileSizeInKB > 200) {
                oversizedFiles.push({
                    name: file.name,
                    dataURL: URL.createObjectURL(file)
                });
            }

            var errorMessage = "Gagal mengunggah file: " + file.name + "\nError: " + errorMessage;
            showCustomToastrNotification("arapaah-orange", errorMessage);
        }
    };

    function showCustomToastrNotification(customClass, message) {
        toastr.options = {
            closeButton: true,
            duration: 3000,
            positionClass: 'toast-top-right arapaah',
            progressBar: true,
            toastClass: customClass
        };
        toastr.success(message);
    }

    Dropzone.options.myDropzone.init = function() {
        this.on("queuecomplete", function() {
            if (oversizedFiles.length > 0) {
                var imageGrid = document.getElementById("imageGrid");
                imageGrid.innerHTML = "";

                var row = document.createElement("div");
                row.classList.add("row");
                oversizedFiles.forEach(function(file, index) {
                    var imageWrapper = document.createElement("div");
                    imageWrapper.classList.add("col-2");
                    var img = document.createElement("img");
                    img.src = file.dataURL;
                    img.alt = file.name;
                    img.classList.add("img-fluid", "custom-preview");
                    imageWrapper.appendChild(img);

                    row.appendChild(imageWrapper);

                    if ((index + 1) % 6 === 0) {
                        imageGrid.appendChild(row);
                        row = document.createElement("div");
                        row.classList.add("row");
                    }
                });

                if (row.childElementCount > 0) {
                    imageGrid.appendChild(row);
                }

                var oversizedModal = new bootstrap.Modal(document.getElementById("oversizedModal"));
                oversizedModal.show();
            }
        });
    };
</script>

<script>
    var modal = new bootstrap.Modal(document.getElementById('oversizedModal'));
    var openModalButton = document.getElementById('openModalButton');
    var closeModalButton = document.getElementById('closeModalButton');
    openModalButton.addEventListener('click', function() {
        modal.show();
    });
    closeModalButton.addEventListener('click', function() {
        modal.hide();
    });
</script>
</body>

</html>