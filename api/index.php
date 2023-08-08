<?php

// Fungsi untuk melakukan analisis leksikal
function analisisLeksikal($input)
{
    $tokens = []; // Array untuk menyimpan token-token hasil analisis leksikal

    $len = strlen($input);
    $i = 0;

    while ($i < $len) {
        $char = $input[$i];

        // Melewati spasi, tab, atau karakter yang tidak perlu dianalisis
        if ($char == ' ' || $char == '\t') {
            $i++;
            continue;
        }

        // Mengecek apakah karakter adalah angka
        if (is_numeric($char)) {
            $value = '';
            while ($i < $len && is_numeric($input[$i])) {
                $value .= $input[$i];
                $i++;
            }
            $tokens[] = ['type' => 'NUMBER', 'value' => $value];
            continue;
        }

        // Mengecek apakah karakter adalah huruf
        if (ctype_alpha($char) || $char == '$') {
            $value = '';
            while ($i < $len && (ctype_alnum($input[$i]) || $input[$i] == '$')) {
                $value .= $input[$i];
                $i++;
            }

            if (isKeyword($value)) {
                $tokens[] = ['type' => 'KEYWORD', 'value' => $value];
            } else {
                $tokens[] = ['type' => 'IDENTIFIER', 'value' => $value];
            }
            continue;
        }

        // Mengecek apakah karakter adalah tanda baca
        if (isPunctuation($char)) {
            $tokens[] = ['type' => 'PUNCTUATION', 'value' => $char];
            $i++;
            continue;
        }

        // Mengecek apakah karakter adalah operator
        if (isOperator($char)) {
            $value = '';
            while ($i < $len && isOperator($input[$i])) {
                $value .= $input[$i];
                $i++;
            }
            $tokens[] = ['type' => 'OPERATOR', 'value' => $value];
            continue;
        }

        // Jika karakter tidak cocok dengan jenis di atas, anggap sebagai literal
        $tokens[] = ['type' => 'LITERAL', 'value' => $char];
        $i++;
    }

    return $tokens;
}

// Fungsi untuk memeriksa apakah kata adalah keyword
function isKeyword($word)
{
    $keywords = ["for", "while", "if", "do", "switch", "case", "echo", "count", "FOR", "WHILE", "IF", "DO", "SWITCH", "CASE", "ECHO", "COUNT"];
    return in_array($word, $keywords);
}

// Fungsi untuk memeriksa apakah karakter adalah tanda baca
function isPunctuation($char)
{
    $punctuations = [".", ",", ";", ":", "?", "!", "(", ")", "{", "}", "[", "]", " ' ", ' " '];
    return in_array($char, $punctuations);
}

// Fungsi untuk memeriksa apakah karakter adalah operator
function isOperator($char)
{
    $operators = ["+", "-", "*", "/", "=", "==", "!=", ">=", "<=", "==="];
    return in_array($char, $operators);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lexical Analyzer</title>
    <link rel="icon" type="image/x-icon" href="gear.ico">
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.min.css" />

    <style>
        /* MAIN CSS */
        body {
            font-family: "Nunito", sans-serif;
        }

        /* Theme */
        body.dark-mode {
            background-color: #121212;
            color: #f8f9fa;
        }

        .dark-mode .navbar {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .dark-mode .card {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .dark-mode .card-body {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .dark-mode .area {
            background-color: #343a40;
            color: #f8f9fa;
        }

        footer {
            color: white;
            padding: 20px 0;
        }

        .b {
            font-weight: bold;
        }

        /* Preloader Styling */
        .loader {
            transform: rotateZ(45deg);
            perspective: 1000px;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            color: #fff;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -24px;
            /* Setengah dari lebar */
            margin-left: -24px;
            /* Setengah dari tinggi */
            z-index: 9999;
        }

        .loader:before,
        .loader:after {
            content: "";
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: inherit;
            height: inherit;
            border-radius: 50%;
            transform: rotateX(70deg);
            animation: 1s spin linear infinite;
        }

        .loader:after {
            color: #ff3d00;
            transform: rotateY(70deg);
            animation-delay: 0.4s;
        }

        @keyframes rotate {
            0% {
                transform: translate(-50%, -50%) rotateZ(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotateZ(360deg);
            }
        }

        @keyframes rotateccw {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(-360deg);
            }
        }

        @keyframes spin {

            0%,
            100% {
                box-shadow: 0.2em 0px 0 0px currentcolor;
            }

            12% {
                box-shadow: 0.2em 0.2em 0 0 currentcolor;
            }

            25% {
                box-shadow: 0 0.2em 0 0px currentcolor;
            }

            37% {
                box-shadow: -0.2em 0.2em 0 0 currentcolor;
            }

            50% {
                box-shadow: -0.2em 0 0 0 currentcolor;
            }

            62% {
                box-shadow: -0.2em -0.2em 0 0 currentcolor;
            }

            75% {
                box-shadow: 0px -0.2em 0 0 currentcolor;
            }

            87% {
                box-shadow: 0.2em -0.2em 0 0 currentcolor;
            }
        }

        /* CSS untuk scrollbar */
        /* Untuk browser WebKit (Chrome dan Safari) */
        ::-webkit-scrollbar {
            width: 8px;
            /* Lebar scrollbar */
        }

        ::-webkit-scrollbar-track {
            background-color: #333;
            /* Warna track scrollbar (background scrollbar) */
        }

        ::-webkit-scrollbar-thumb {
            background-color: #555;
            /* Warna thumb scrollbar (bagian geser scrollbar) */
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #888;
            /* Warna thumb saat hover */
        }

        /* Contoh elemen scrollable dengan custom scrollbar */
        .scrollable-container {
            height: 300px;
            overflow-y: auto;
            background-color: #444;
            /* Warna background container */
            padding: 10px;
        }

        .scrollable-content {
            height: 800px;
            /* Tinggi konten yang akan di-scroll */
            background-color: #666;
            /* Warna background konten */
            color: #fff;
            /* Warna teks konten */
            padding: 20px;
        }

        /* Ukuran font badges yang diinginkan */
        .badge {
            font-size: 14px;
        }

        /* Ganti lebar textarea menjadi 100% dari lebar card */
        .card-body textarea {
            width: 100%;
            border: none;
            resize: none;
        }

        /* END MAIN CSS */

        /* DRACULA */
        .cm-s-dracula.CodeMirror,
        .cm-s-dracula .CodeMirror-gutters {
            background-color: #282a36 !important;
            color: #f8f8f2 !important;
            border: none;
        }

        .cm-s-dracula .CodeMirror-gutters {
            color: #282a36;
        }

        .cm-s-dracula .CodeMirror-cursor {
            border-left: solid thin #f8f8f0;
        }

        .cm-s-dracula .CodeMirror-linenumber {
            color: #6D8A88;
        }

        .cm-s-dracula .CodeMirror-selected {
            background: rgba(255, 255, 255, 0.10);
        }

        .cm-s-dracula .CodeMirror-line::selection,
        .cm-s-dracula .CodeMirror-line>span::selection,
        .cm-s-dracula .CodeMirror-line>span>span::selection {
            background: rgba(255, 255, 255, 0.10);
        }

        .cm-s-dracula .CodeMirror-line::-moz-selection,
        .cm-s-dracula .CodeMirror-line>span::-moz-selection,
        .cm-s-dracula .CodeMirror-line>span>span::-moz-selection {
            background: rgba(255, 255, 255, 0.10);
        }

        .cm-s-dracula span.cm-comment {
            color: #6272a4;
        }

        .cm-s-dracula span.cm-string,
        .cm-s-dracula span.cm-string-2 {
            color: #f1fa8c;
        }

        .cm-s-dracula span.cm-number {
            color: #bd93f9;
        }

        .cm-s-dracula span.cm-variable {
            color: #50fa7b;
        }

        .cm-s-dracula span.cm-variable-2 {
            color: white;
        }

        .cm-s-dracula span.cm-def {
            color: #50fa7b;
        }

        .cm-s-dracula span.cm-operator {
            color: #ff79c6;
        }

        .cm-s-dracula span.cm-keyword {
            color: #ff79c6;
        }

        .cm-s-dracula span.cm-atom {
            color: #bd93f9;
        }

        .cm-s-dracula span.cm-meta {
            color: #f8f8f2;
        }

        .cm-s-dracula span.cm-tag {
            color: #ff79c6;
        }

        .cm-s-dracula span.cm-attribute {
            color: #50fa7b;
        }

        .cm-s-dracula span.cm-qualifier {
            color: #50fa7b;
        }

        .cm-s-dracula span.cm-property {
            color: #66d9ef;
        }

        .cm-s-dracula span.cm-builtin {
            color: #50fa7b;
        }

        .cm-s-dracula span.cm-variable-3,
        .cm-s-dracula span.cm-type {
            color: #ffb86c;
        }

        .cm-s-dracula .CodeMirror-activeline-background {
            background: rgba(255, 255, 255, 0.1);
        }

        .cm-s-dracula .CodeMirror-matchingbracket {
            text-decoration: underline;
            color: white !important;
        }

        /* END DRACULA CSS */
    </style>
</head>

<body oncontextmenu="return false;">
    <!-- Preloader -->
    <div class="loader" id="preloader"></div>
    <!-- Content -->
    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark b">
            <div class="container-fluid mx-5">
                <!-- Brand -->
                <a class="navbar-brand" href="https://lexyzer.vercel.app">
                    <i class="bi bi-gear"></i>
                    Lexyzer
                </a>
                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navbar Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#" style="text-decoration: none;">Docs</a>
                        </li>
                        <li class="nav-item">
                            <button id="darkModeToggle" class="btn btn-dark"><i class="bi bi-moon"></i></button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-3">
            <div class="row">
                <!-- Halaman Kiri -->
                <div class="col-md-12">
                    <div class="card">
                        <form method="POST" action="">
                            <nav class="navbar navbar-dark bg-dark">
                                <div class="container-fluid">
                                    <span class="navbar-brand mb-0 h1">Input</span>
                                    <div class="ms-auto">
                                        <button type="submit" class="btn btn-primary" name="run">Run</button>
                                    </div>
                                </div>
                            </nav>
                            <div class="card-body">
                                <div class="input-container">
                                    <textarea id="codeEditor" name="code" rows="10" placeholder="Tulis kode di sini"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Halaman Kanan -->
                <div class="col-md-12 my-3">
                    <div class="card">
                        <form method="POST" action="">
                            <nav class="navbar navbar-dark bg-dark">
                                <div class="container-fluid">
                                    <span class="navbar-brand mb-0 h1">Output</span>
                                    <button class="btn btn-primary" onclick="">Clear</button>
                                </div>
                            </nav>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    if (isset($_POST["run"])) {
                                        $code = $_POST["code"];
                                        $tokens = analisisLeksikal($code);
                                    ?>
                                        <div class="col-md-12 my-2">
                                            <div class="card shadow">
                                                <div class="card-body">
                                                    <!-- <p class="card-text">
                                                            <?php
                                                            echo $code;
                                                            ?>
                                                        </p> -->
                                                    <textarea class="area" rows="5" style="border: none; resize: none;" readonly><?= $code; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-3">
                                            <div class="card shadow">
                                                <div class="card-header bg-primary b">
                                                    IDENTIFIER
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        foreach ($tokens as $token) {
                                                            if ($token['type'] == 'IDENTIFIER') {
                                                                // echo "'" . $token['value'] . "'<br>";
                                                                echo '<span class="badge rounded-pill text-bg-primary shadow">' . $token['value'] . '</span>&nbsp';
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-3">
                                            <div class="card shadow">
                                                <div class="card-header bg-info b">
                                                    KEYWORD
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        foreach ($tokens as $token) {
                                                            if ($token['type'] == 'KEYWORD') {
                                                                echo '<span class="badge rounded-pill text-bg-info shadow">' . $token['value'] . '</span>&nbsp';
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-3">
                                            <div class="card shadow">
                                                <div class="card-header bg-warning b">
                                                    NUMBER
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        foreach ($tokens as $token) {
                                                            if ($token['type'] == 'NUMBER') {
                                                                echo '<span class="badge rounded-pill text-bg-warning shadow">' . $token['value'] . '</span>&nbsp';
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-3">
                                            <div class="card shadow">
                                                <div class="card-header text-white bg-danger b">
                                                    PUNCTUATION
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        foreach ($tokens as $token) {
                                                            if ($token['type'] == 'PUNCTUATION') {
                                                                echo '<span class="badge rounded-pill text-bg-danger shadow">' . $token['value'] . '</span>&nbsp';
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-3">
                                            <div class="card shadow">
                                                <div class="card-header text-white bg-secondary b">
                                                    OPERATOR
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        foreach ($tokens as $token) {
                                                            if ($token['type'] == 'OPERATOR') {
                                                                echo '<span class="badge rounded-pill text-bg-secondary shadow">' . $token['value'] . '</span>&nbsp';
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 my-3">
                                            <div class="card shadow">
                                                <div class="card-header text-white bg-success b">
                                                    LITERAL
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        foreach ($tokens as $token) {
                                                            if ($token['type'] == 'LITERAL') {
                                                                echo '<span class="badge rounded-pill text-bg-success shadow">' . $token['value'] . '</span>&nbsp';
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer text-center bg-dark b py-3">
            <div class="container">
                <span class="me-2">Lexyzer <?= date('Y'); ?></span>
                <a href="#" class="text-white"><i class="bi bi-github"></i></a>
            </div>
        </footer>
    </div>
</body>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/mode/javascript/javascript.min.js"></script>

<script type="text/javascript">
    // Membuat editor CodeMirror pada textarea dengan id "codeEditor"
    var codeEditor = CodeMirror.fromTextArea(document.getElementById("codeEditor"), {
        lineNumbers: true, // Tampilkan nomor baris
        mode: "javascript", // Pilih mode (syntax highlighting) sesuai bahasa pemrograman
        theme: "dracula", // Pilih tema (opsional)
    });

    // Theme switcher
    $(document).ready(function() {
        // Ambil status tema dari localStorage saat halaman dimuat
        var isDarkMode = localStorage.getItem("darkMode");

        // Jika status tema tersimpan dan bernilai "true", aktifkan dark mode
        if (isDarkMode === "true") {
            $("body").addClass("dark-mode");
            $("#darkModeToggle i").removeClass("bi-moon").addClass("bi-sun");
        }

        // Ketika tombol toggle di klik
        $("#darkModeToggle").click(function() {
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
    window.addEventListener("load", function() {
        const preloader = document.getElementById("preloader");
        const content = document.getElementById("content");

        // Sembunyikan preloader saat konten halaman selesai dimuat
        preloader.style.display = "none";

        // Tampilkan konten halaman setelah preloader dihilangkan
        content.style.display = "block";
    });
</script>

</html>
