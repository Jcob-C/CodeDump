<?php
    @session_start();

    if (!isset($_SESSION["loggedinUserID"])) {
        header("Location: login.php");
        exit;
    }
?>