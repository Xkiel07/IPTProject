let admin = document.getElementById("admin");

function openAdminPopup() {
    closeStaffPopup();
    admin.classList.add("AdminOpen-popup");
}

function closeAdminPopup() {
    admin.classList.remove("AdminOpen-popup");
}
