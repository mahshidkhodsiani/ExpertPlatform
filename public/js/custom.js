document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggle = document.getElementById("sidebarToggle");
    const mobileSidebar = document.getElementById("mobileSidebar");
    const sidebarOverlay = document.getElementById("sidebarOverlay");
    const body = document.body;

    // Log to confirm elements are found
    if (sidebarToggle && mobileSidebar && sidebarOverlay) {
        console.log("All sidebar elements found:", {
            sidebarToggle,
            mobileSidebar,
            sidebarOverlay,
        });

        sidebarToggle.addEventListener("click", function () {
            console.log("Toggle button clicked!");
            mobileSidebar.classList.toggle("show");
            sidebarOverlay.classList.toggle("show");
            body.classList.toggle("sidebar-open"); // Add class to body to prevent scroll

            // Toggle icon
            const icon = this.querySelector("i");
            if (mobileSidebar.classList.contains("show")) {
                icon.classList.remove("fa-bars");
                icon.classList.add("fa-times");
            } else {
                icon.classList.remove("fa-times");
                icon.classList.add("fa-bars");
            }
        });

        sidebarOverlay.addEventListener("click", function () {
            console.log("Overlay clicked, closing sidebar.");
            mobileSidebar.classList.remove("show");
            sidebarOverlay.classList.remove("show");
            body.classList.remove("sidebar-open");
            sidebarToggle.querySelector("i").classList.remove("fa-times");
            sidebarToggle.querySelector("i").classList.add("fa-bars");
        });
    } else {
        console.error("ERROR: One or more sidebar elements not found!");
    }

    // Close sidebar if window resized from mobile to desktop
    window.addEventListener("resize", function () {
        if (window.innerWidth >= 992) {
            if (mobileSidebar.classList.contains("show")) {
                mobileSidebar.classList.remove("show");
                sidebarOverlay.classList.remove("show");
                body.classList.remove("sidebar-open");
                sidebarToggle.querySelector("i").classList.remove("fa-times");
                sidebarToggle.querySelector("i").classList.add("fa-bars");
            }
        }
    });
});

