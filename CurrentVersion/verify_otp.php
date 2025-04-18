<?php
session_start();
require_once 'pdo.php';
date_default_timezone_set('UTC');


if($_SERVER['REQUEST_METHOD']=="POST"){
    $email = trim($_POST['email']);
    $otp = trim($_POST["otp"]);

    if(empty($email) || empty($otp)){
        echo "email or otp is empty";
    }

    $query = "SELECT * FROM `password_reset` 
          WHERE `email` = :email 
            AND `otp` = :otp ;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":otp", $otp);
    $stmt->execute();

    $otp_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$otp_row){
        echo "No data found";
        exit;
    }

    $dbtime = strtotime($otp_row['generated_at']);
    $curtime = strtotime(date("Y-m-d H:i:s"));

    if($curtime - $dbtime > 600){
        
        $stmt= $pdo->prepare("DELETE FROM `password_reset` WHERE `email` = :email ;");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        die("Otp expired");
    }

    $stmt= $pdo->prepare("DELETE FROM `password_reset` WHERE `email` = :email ;");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    header("Location: reset_password_ui.php?email=".urlencode($email));
}