function previewImage(event, id) {
  var preview = document.getElementById('fotoS_' + id);
  var fileInput = document.getElementById('infotoS_' + id);
  
  if (fileInput && fileInput.files.length > 0) {
      var file = fileInput.files[0];
      var reader = new FileReader();

      reader.onload = function() {
          preview.src = reader.result;
      }

      reader.readAsDataURL(file);
  }
}
