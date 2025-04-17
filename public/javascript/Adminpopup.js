document.addEventListener('DOMContentLoaded', function() {
    const adminPopup = document.getElementById("admin");
    const adminPopupOverlay = document.getElementById("admin-popup-overlay"); // Example

    window.openAdminPopup = function() {
        if (adminPopup) {
            closeStaffPopup(); // Make sure this exists
            adminPopup.classList.add("AdminOpen-popup");
            if (adminPopupOverlay) adminPopupOverlay.style.display = 'block';
        }
    };

    window.closeAdminPopup = function() {
        if (adminPopup) {
            adminPopup.classList.remove("AdminOpen-popup");
            if (adminPopupOverlay) adminPopupOverlay.style.display = 'none';
        }
    };
});
