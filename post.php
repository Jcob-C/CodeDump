<?php
    session_start();
    require "auth/login_block.php";
    require "auth/update_last_active.php";
    require_once "includes/db.php";
    require_once "includes/utils.php";

    checkPost();

    function checkPost() {
        if (isset($_POST['backtohome'])) {
            headto('home.php');
        }
        elseif (isset($_POST['submitPost'])) {
            createNewPost($_SESSION["loggedinUserID"], $_POST['title'], $_POST['code']);
            headto("home.php");
        }
        clearPosts();
    }
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/styles.css">
    </head>
    <body>
        <br>
        <h1>CodeDump</h1>
        <form method="post">
            <button type="submit" name="backtohome">Home</button>
        </form> 
        <hr>
        <form method="post">
            <button type="submit" name="submitPost">Submit Post</button>
            <br> 
            <br>
            <textarea name="title" rows="2" cols="60" placeholder="Title" required></textarea>
            <textarea name="code" rows="30" cols="100" placeholder="Enter your code here." required></textarea>
        </form> 
    </body> 
</html>