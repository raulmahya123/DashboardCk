document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.getElementById("menuToggle");
    let isToggled = false;

    menuToggle.addEventListener("click", function() {
        isToggled = !isToggled;

        if (isToggled) {
            menuToggle.style.position = "absolute";
            menuToggle.style.right = "240px";
            menuToggle.style.left = "240px";
        } else {
            menuToggle.style.position = "relative";
            menuToggle.style.left = "auto";
            menuToggle.style.right = "40px";
        }
    });

    menuToggle.style.transition = "all 0.3s ease-in-out";
});

document.addEventListener("DOMContentLoaded", function() {
    const logoutButton = document.getElementById("logoutButton");

    if (logoutButton) {
        logoutButton.addEventListener("click", function() {
            if (confirm("Apakah Anda yakin ingin logout?")) {
                document.getElementById("logoutForm").submit();
            } else {
                alert("Logout dibatalkan.");
            }
        });
    }
});
