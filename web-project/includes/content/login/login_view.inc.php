<?php 

declare(strict_types=1);

function render_login_errors() {
    if (!empty($_SESSION["errors_login"])) {
        foreach ($_SESSION["errors_login"] as $error) {
            echo '<p class="alert-danger p-2 mt-2">' . htmlspecialchars($error) . '</p>';
        }
        unset($_SESSION["errors_login"]);
    } elseif (isset($_GET['login']) && $_GET['login'] === "success") {
        echo '<p class="alert-success p-2 mt-2">Login successful!</p>';
    }
}

?>
