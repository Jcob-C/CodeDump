<?php
    @session_start();
    require_once "includes/db.php";
    
    if (isset($_SESSION["loggedinUserID"])) {
        updateLastActive($_SESSION["loggedinUserID"]);
    }
?>