<?php
session_start();
$judul = "Unggah Foto";
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';
?>
    <style>

        .container1 {
            max-height: 430px;
            margin: 20px 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            z-index: 0;
            overflow-x: auto;
        }
        @media (min-width: 12in){
            .container1{
                max-height: 430px;
            }
        }
        @media (max-width: 768px){
            .container1{
                max-height: 100%;
            }
        }
        @media (min-width: 14in){
            .container1{
                max-height: 500px;
            }
        }
    </style>

    <div class="container1">
        <form action="../import/uploadFoto.php" class="dropzone" id="my-dropzone"></form>
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
        Dropzone.options.myDropzone = {
            paramName: "file",
            maxFilesize: 5,
            addRemoveLinks: true,
            dictRemoveFile: "Hapus file",
            success: function(file, response) {
                // var successMessage = "File berhasil diunggah: " + file.name + response;
                // showCustomToastrNotification("arapaah-blue", 'File berhasil diunggah');
                console.log("File berhasil diunggah: " + successMessage);
            },
            error: function(file, errorMessage) {
                var errorMessage = "Gagal mengunggah file: " + file.name + "\nError: " + errorMessage;
                showCustomToastrNotification("arapaah-orange", errorMessage);
                console.log("Gagal mengunggah file: " + file.name + "\nError: " + errorMessage);
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
    </script>
</body>
</html>
