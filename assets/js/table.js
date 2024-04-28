$(document).ready(function () {
  var table = $('#myTable').DataTable({
    "paging": true,
    "ordering": false,
    "info": true,
    "searching": true,
    "order": [[0, "asc"]],
    "language": {
      "search": "Search:",
      "lengthMenu": "Show _MENU_ entries",
      "info": "Showing _START_ to _END_ of _TOTAL_ entries",
      "paginate": {
        "first": "First",
        "last": "Last",
        "next": "Next",
        "previous": "Previous"
      }
    },
    dom: '<"top"lfB<"clear">>rt<"bottom"ip><"clear">',
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ]
  });

  $('#myTable').on('draw.dt', function (e, settings) {
    var pageInfo = table.page.info();

    var currentPage = pageInfo.page;
    var totalPages = pageInfo.pages;
    var startIndex = pageInfo.start;
    var endIndex = pageInfo.end;

    console.log("Current Page:", currentPage);
    console.log("Total Pages:", totalPages);
    console.log("Start Index:", startIndex);
    console.log("End Index:", endIndex);
  });
  $('#myTable').on('page.dt', function () {
    var pageInfo = table.page.info();

    var currentPage = pageInfo.page;
    var totalPages = pageInfo.pages;
    var startIndex = pageInfo.start;
    var endIndex = pageInfo.end;

    console.log("Current Page:", currentPage);
    console.log("Total Pages:", totalPages);
    console.log("Start Index:", startIndex);
    console.log("End Index:", endIndex);
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const kolomHiddenElements = document.querySelectorAll('.kolom-hidden');
  const toggleButton1 = document.getElementById('toggleButton1');

  toggleButton1.addEventListener('click', function () {
    kolomHiddenElements.forEach(function (element) {
      if (element.style.display === 'none') {
        element.style.display = 'table-cell';
      } else {
        element.style.display = 'none';
      }
    });
  });

  document.addEventListener('click', function (event) {
    if (!toggleButton1.contains(event.target)) {
      kolomHiddenElements.forEach(function (element) {
        element.style.display = 'none';
      });
    }
  });
});

const modalDataButtons = document.querySelectorAll('.modal-data1');

modalDataButtons.forEach(button => {
  button.addEventListener('click', function (event) {
    event.preventDefault();
    const targetId = button.getAttribute('href');
    const targetElement = document.querySelector(targetId);
    if (targetElement) {
      targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});