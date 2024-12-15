<?php
    if (isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === true) {
        $connection = new mysqli($host, $dbusername, $dbpassword, $dbname);
        $id = $_SESSION['user_id'];

        $sql = "SELECT * FROM users WHERE  id=$id";
        $result =$connection -> query($sql);
        $row = $result ->fetch_assoc();
        $username = $row["username"];
    }
?>

<!----- NAVBAR ---->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/web-project/index.php?page=home">XENIA <i class="bi bi-lightning-charge-fill" style="color: #6C63FF"></i></a>
        <a class="text-white" style="text-decoration:none;"><?php echo $username?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto">
                <a class="nav-link <?= ($_GET["page"] ?? "home") === "home" ? "active" : ""?>"  href="/web-project/index.php?page=home">Home</a>
                <a class="nav-link <?= ($_GET["page"] ?? "news") === "news" ? "active" : ""?>"  href="/web-project/index.php?page=news">News</a>
                <a class="nav-link  <?= ($_GET["page"] ?? "reservation") === "reservation" ? "active" : ""?>" href="reservation.php">Reservation</a>

                <?php if($_SESSION["is_admin"]===1){?>
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