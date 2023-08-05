// Membuat editor CodeMirror pada textarea dengan id "codeEditor"
var codeEditor = CodeMirror.fromTextArea(document.getElementById("codeEditor"), {
  lineNumbers: true, // Tampilkan nomor baris
  mode: "javascript", // Pilih mode (syntax highlighting) sesuai bahasa pemrograman
  theme: "dracula", // Pilih tema (opsional)
});

// Theme Toggle
// $(document).ready(function () {
//   $("#darkModeToggle").click(function () {
//     $("body").toggleClass("dark-mode");
//     // Ganti ikon ketika dark mode diaktifkan atau dinonaktifkan
//     var icon = $(this).find("i");
//     if (icon.hasClass("bi-moon")) {
//       icon.removeClass("bi-moon").addClass("bi-sun");
//     } else {
//       icon.removeClass("bi-sun").addClass("bi-moon");
//     }
//   });
// });

// Theme switcher
$(document).ready(function () {
  // Ambil status tema dari localStorage saat halaman dimuat
  var isDarkMode = localStorage.getItem("darkMode");

  // Jika status tema tersimpan dan bernilai "true", aktifkan dark mode
  if (isDarkMode === "true") {
    $("body").addClass("dark-mode");
    $("#darkModeToggle i").removeClass("bi-moon").addClass("bi-sun");
  }

  // Ketika tombol toggle di klik
  $("#darkModeToggle").click(function () {
    // Togglle class "dark-mode" pada body
    $("body").toggleClass("dark-mode");

    // Ganti ikon ketika dark mode diaktifkan atau dinonaktifkan
    var icon = $(this).find("i");
    if (icon.hasClass("bi-moon")) {
      icon.removeClass("bi-moon").addClass("bi-sun");
    } else {
      icon.removeClass("bi-sun").addClass("bi-moon");
    }

    // Simpan status tema ke localStorage
    var isDarkMode = $("body").hasClass("dark-mode");
    localStorage.setItem("darkMode", isDarkMode);
  });
});

// Preloader
window.addEventListener("load", function () {
  const preloader = document.getElementById("preloader");
  const content = document.getElementById("content");

  // Sembunyikan preloader saat konten halaman selesai dimuat
  preloader.style.display = "none";

  // Tampilkan konten halaman setelah preloader dihilangkan
  content.style.display = "block";
});
