$(function () {
    $("#datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        dayNames: ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
        onSelect: function(dateText, inst) {
            inputtask.focus();
        }
    });
    
    const toggleButton = document.getElementById('toggle-button');
    const taskForm = document.getElementById('task-form');
    const min = document.getElementById('icon-hapus');
    const inputdate = document.getElementById('datepicker');
    const inputtask = document.getElementById('input-task');

    min.addEventListener('click', function() {
        taskForm.style.display = 'none';
        toggleButton.style.display = 'block';
    });

    toggleButton.addEventListener('click', function () {
        taskForm.style.display = 'block';
        toggleButton.style.display = 'none';
        inputdate.focus();
    });

    document.getElementById('task-form').addEventListener('submit', function (event) {
        this.submit();
    });
});
function sudah(mod, id){
window.location = "../mod/setting/taksOption?id="+ id + "&mod="+ mod;
}