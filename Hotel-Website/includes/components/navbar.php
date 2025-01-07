<?php
    /* ---- -------------------------- ALTER TEIL -----------------------*/
    /*if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $connection = new mysqli($host, $dbusername, $dbpassword, $dbname);
        $id = $_SESSION['user_id'];

        $sql = "SELECT * FROM users WHERE  user_id=$id";
        $result =$connection -> query($sql);
        $row = $result ->fetch_assoc();
        $username = $row["username"];
    }*/
    /* ---- -------------------------- ALTER TEIL -----------------------*/

    /*----------------------- NEUER TEIL ----------------------------*/
if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    try {
        // Verbindung zur Datenbank
        $connection = new mysqli($host, $dbusername, $dbpassword, $dbname);
        
        // Überprüfen der Verbindung
        if ($connection->connect_error) {
            throw new Exception("Verbindungsfehler: " . $connection->connect_error);
        }

        // Überprüfen, ob user_id in der Session existiert
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("Keine Benutzer-ID gefunden");
        }

        $id = (int)$_SESSION['user_id']; // Type casting zur Sicherheit

        // Prepared Statement verwenden
        $stmt = $connection->prepare("SELECT username FROM users WHERE user_id = ?");
        if (!$stmt) {
            throw new Exception("Prepared Statement Fehler: " . $connection->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $username = htmlspecialchars($row["username"]); // XSS-Schutz
        } else {
            $username = "Guest";
        }

        $stmt->close();
        $connection->close();

    } catch (Exception $e) {
        // Fehler loggen
        error_log($e->getMessage());
        $username = "Guest"; // Fallback-Wert
    }
}
/*----------------------- NEUER TEIL ----------------------------*/
?>

<!----- NAVBAR ---->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold ms-3" href="/Hotel-Website/index.php?page=home">XENIA <i class="bi bi-lightning-charge-fill" style="color: #6C63FF"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav">
                <?php if(isset($_SESSION["loggedin"])){?>
                    <a class="nav-link text-white text-uppercase" style="text-decoration:none;"> Welcome <?php echo $username?></a>
                <?php }?>
            </div>
            <div class="navbar-nav ms-auto">
                <a class="nav-link <?= ($_GET["page"] ?? "home") === "home" ? "active" : ""?>"  href="/Hotel-Website/index.php?page=home">Home</a>
                <a class="nav-link <?= ($_GET["page"] ?? "news") === "news" ? "active" : ""?>"  href="/Hotel-Website/index.php?page=news">News</a>
                <a class="nav-link  <?= ($_GET["page"] ?? "rooms") === "rooms" ? "active" : ""?>" href="/Hotel-Website/index.php?page=rooms">Rooms</a>
                <a class="nav-link  <?= ($_GET["page"] ?? "impressum") === "impressum" ? "active" : ""?>"  href="/Hotel-Website/index.php?page=impressum" class="text-decoration-none text-light">Impressum</a>
                <a class="nav-link  <?= ($_GET["page"] ?? "faq") === "faq" ? "active" : ""?>"  href="/Hotel-Website/index.php?page=faq" class="text-decoration-none text-light">FAQ</a>

                <?php if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === 1) {?>
                <a class="nav-link <?= ($_GET["page"] ?? "administration") === "administration" ? "active" : ""?>" href="/Hotel-Website/index.php?page=administration">Administration</a>
                <?php }?>

                <?php if(isset($_SESSION["loggedin"])) {?>
                    <a class="nav-link <?= ($_GET["page"] ?? "profile") === "profile" ? "active" : ""?>" href="/Hotel-Website/index.php?page=profile">My Profile</a> 
                    <form action="/Hotel-Website/includes/content/login/logout.inc.php" method="post" class="d-inline">
                        <button type="submit" class="btn btn-danger me-3">LOG OUT</button>
                    </form>
                <?php } else { ?>
                    <form action="/Hotel-Website/index.php?page=login" method="post" class="d-inline">
                        <button type="submit" class="btn btn-danger me-3">LOGIN</button>
                    </form>
                <?php }?>
            </div>
        </div>
    </div>
</nav>