// Import file bootstrap utama (biasanya untuk setup axios, CSRF, dll)
import "./bootstrap";

// Jalankan script setelah seluruh DOM selesai dimuat
document.addEventListener("DOMContentLoaded", function () {

    // ================= SIDEBAR TOGGLE =================
    // Ambil elemen sidebar (<aside>) dan tombol toggle
    const sidebar = document.querySelector("aside");
    const sidebarToggle = document.getElementById("sidebarToggle");

    // Pastikan kedua elemen ada sebelum menambahkan event
    if (sidebar && sidebarToggle) {
        sidebarToggle.addEventListener("click", function () {
            // Toggle class "hidden" untuk menampilkan / menyembunyikan sidebar
            sidebar.classList.toggle("hidden");
        });
    }

    // ================= ANIMASI HOVER CARD =================
    // Loop semua elemen dengan class "card-hover"
    document.querySelectorAll(".card-hover").forEach((card) => {

        // Saat mouse masuk ke card
        card.addEventListener("mouseenter", () => {
            // Tambahkan efek bayangan dan zoom
            card.classList.add("shadow-lg", "scale-105");
        });

        // Saat mouse keluar dari card
        card.addEventListener("mouseleave", () => {
            // Hapus efek bayangan dan zoom
            card.classList.remove("shadow-lg", "scale-105");
        });

    });

});
