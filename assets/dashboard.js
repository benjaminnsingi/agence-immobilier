import "./css/navbar-admin.scss";
import 'boxicons/css/boxicons.min.css';
import "bootstrap/scss/bootstrap.scss";

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
    sidebar.classList.toggle("active");
    if(sidebar.classList.contains("active")){
        sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
    }else
        sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}