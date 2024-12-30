<?php
    if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $connection = new mysqli($host, $dbusername, $dbpassword, $dbname);
        $id = $_SESSION['user_id'];

        $sql = "SELECT * FROM users WHERE  user_id=$id";
        $result =$connection -> query($sql);
        $row = $result ->fetch_assoc();
        $username = $row["username"];
    }
?>

<!----- NAVBAR ---->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/web-project/index.php?page=home">XENIA <i class="bi bi-lightning-charge-fill" style="color: #6C63FF"></i></a>
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
                <a class="nav-link <?= ($_GET["page"] ?? "home") === "home" ? "active" : ""?>"  href="/web-project/index.php?page=home">Home</a>
                <a class="nav-link <?= ($_GET["page"] ?? "news") === "news" ? "active" : ""?>"  href="/web-project/index.php?page=news">News</a>
                <a class="nav-link  <?= ($_GET["page"] ?? "rooms") === "rooms" ? "active" : ""?>" href="/web-project/index.php?page=rooms">Rooms</a>
                <a class="nav-link  <?= ($_GET["page"] ?? "impressum") === "impressum" ? "active" : ""?>"  href="/web-project/index.php?page=impressum" class="text-decoration-none text-light">Impressum</a>
                <a class="nav-link  <?= ($_GET["page"] ?? "faq") === "faq" ? "active" : ""?>"  href="/web-project/index.php?page=faq" class="text-decoration-none text-light">FAQ</a>

                <?php if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === 1) {?>
                <a class="nav-link <?= ($_GET["page"] ?? "administration") === "administration" ? "active" : ""?>" href="/web-project/index.php?page=administration">Administration</a>
                <?php }?>

                <?php if(isset($_SESSION["loggedin"])) {?>
                    <a class="nav-link <?= ($_GET["page"] ?? "profile") === "profile" ? "active" : ""?>" href="/web-project/index.php?page=profile">My Profile</a> 
                    <form action="/web-project/includes/content/login/logout.inc.php" method="post" class="d-inline">
                        <button type="submit" class="btn btn-danger">LOG OUT</button>
                    </form>
                <?php } else { ?>
                    <form action="/web-project/includes/content/login/login_form.php" method="post" class="d-inline">
                        <button type="submit" class="btn btn-danger">LOGIN</button>
                    </form>
                <?php }?>
            </div>
        </div>
    </div>
</nav>