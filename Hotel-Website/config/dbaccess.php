<?php 

    //$host = "127.0.0.1:3308"; 
    $host = "localhost";
    $dbname = "dbaccess";
    $dbusername = "root";
    $dbpassword = "";
  


    try{
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
        $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        die("Connection failed: " . $e->getMessage());
    }



?>