<?php
    require_once '../../../config/config_session.inc.php';
    require_once '../../../config/dbaccess.php';
    include("../../components/header.php");
    include("../../components/navbar.php");

    require_once("options_fetch.php");
    require_once("../rooms/rooms_fetch.php");

    // Get checkin and checkout dates from URL parameters if available
    $checkin = $_POST['checkin'] ?? '';
    $checkout = $_POST['checkout'] ?? '';
    $room_id = $_POST['room_id'] ?? '';

    // Fetch the selected room
    $selected_room = null;
    foreach ($rooms as $room) {
        if ($room['room_id'] == $room_id) {
            $selected_room = $room;
            break;
        }
    }


    // Unique index controller for checkout related pages for easier editing and adding new pages
    $page = $_GET["page"] ?? "options";

    switch($page){
        case "options":
            include "options.php";
            break;
        case "checkout":
            include "checkout.php";
            break;
        case "thanks":
            include "thankyoupage.php";
            break;     
    }

    include("../../components/footer.php");
?>