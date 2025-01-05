<?php 
    require_once 'config/config_session.inc.php'; 
    require_once 'config/dbaccess.php';

    $page = $_GET["page"] ?? "home";

    include("includes/components/header.php");
    include("includes/components/navbar.php");

    switch($page){
        case "home":
            include("./includes/content/home.php");
            break;
        case "news":
            include "includes/content/news/news.php";
            break;
        case "rooms":
            include "includes/content/rooms/rooms.php";
            break;
        case "administration":
            include "includes/content/admin/administration.php";
            break;
        case "profile":
            include "includes/content/myprofile.php";
            break;
        case "impressum":
            include "includes/content/impressum.php";
            break; 
        case "faq":
            include "includes/content/faq.php";
            break; 
        case "login":
            include("includes/content/login/login_form.php");
            break; 
        case "signup":
            include("includes/content/signup/signup_form.php");
            break; 
                  
        
    }


    include("includes/components/footer.php");
?>