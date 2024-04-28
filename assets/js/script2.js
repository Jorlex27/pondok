const arrows = document.querySelectorAll(".arrow");

arrows.forEach((arrow) => {
  arrow.addEventListener("click", (e) => {
    const arrowParent = arrow.parentElement.parentElement;
    arrowParent.classList.toggle("showMenu");
  });
});

const sidebar = document.querySelector(".sidebar");
const sidebarBtn = document.querySelector(".bx-menu");
// console.log(sidebarBtn);

sidebarBtn.addEventListener("click", () => {
  sidebar.classList.toggle("close");
  document.querySelector(".home-section").classList.toggle("full");
});
