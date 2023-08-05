<?php include_once "functions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lexical Analyzer</title>

    <link rel="icon" type="image/x-icon" href="img/gear.ico">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.min.css" />

    <link rel="stylesheet" href="css/dracula.css" />
    <link rel="stylesheet" href="css/main.css?v=<?= time(); ?>" />

</head>

<body>
    <!-- Preloader -->
    <div class="loader" id="preloader"></div>

    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark b">
            <div class="container-fluid mx-5">
                <!-- Brand -->
                <a class="navbar-brand" href="#">
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
                                    if (isset($_POST["run"])) { ?>
                                        <div class="col-md-12 my-2">
                                            <div class="card shadow">
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        $code = $_POST["code"];
                                                        echo $code;
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    if (isset($_POST["run"])) {
                                        $code = $_POST["code"];
                                        $tokens = analisisLeksikal($code);
                                    ?>
                                        <div class="col-md-4">
                                            <div class="card shadow">
                                                <div class="card-header bg-primary b">
                                                    IDENTIFIER
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        foreach ($tokens as $token) {
                                                            if ($token['type'] == 'IDENTIFIER') {
                                                                echo "'" . $token['value'] . "'<br>";
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card shadow">
                                                <div class="card-header bg-info b">
                                                    KEYWORD
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        foreach ($tokens as $token) {
                                                            if ($token['type'] == 'KEYWORD') {
                                                                echo "'" . $token['value'] . "'<br>";
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card shadow">
                                                <div class="card-header bg-warning b">
                                                    NUMBER
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <?php
                                                        foreach ($tokens as $token) {
                                                            if ($token['type'] == 'NUMBER') {
                                                                echo "'" . $token['value'] . "'<br>";
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
                                                                echo "'" . $token['value'] . "'<br>";
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
                                                                echo "'" . $token['value'] . "'<br>";
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
                                                                echo "'" . $token['value'] . "'<br>";
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

        <footer class="footer text-center b py-3">
            <div class="container">
                <span class="me-2">Lexizer <?= date('Y'); ?></span>
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
<script src="js/main.js?v=<?= time(); ?>"></script>

</html>