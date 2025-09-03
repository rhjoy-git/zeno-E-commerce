// preloader.js
document.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("global-loader");

    window.showLoader = function () {
        if (loader) {
            loader.classList.remove("hidden");
            document.body.style.pointerEvents = "none"; 
        }
    };

    window.hideLoader = function () {
        if (loader) {
            loader.classList.add("hidden");
            document.body.style.pointerEvents = "auto";
        }
    };
});