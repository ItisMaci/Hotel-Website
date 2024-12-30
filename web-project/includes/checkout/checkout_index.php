<?php
    require_once __DIR__ . '/../../config/config_session.inc.php';
    require_once __DIR__ . '/../../config/dbaccess.php';
    include("../components/header.php");
    include("../components/navbar.php");

    $page = $_GET["page"] ?? "options";

    switch($page){
        case "options":
            include "options.php";
            break;
        case "payment":
            include "payment.php";
            break;
        case "checkout":
            include "#";
            break;
        case "thanks":
            include "#";
            break;     
    }

    include("../components/footer.php");
?>