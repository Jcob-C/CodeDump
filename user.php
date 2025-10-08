<?php
    session_start();
    require "auth/login_block.php";
    require "auth/update_last_active.php";
    require_once "includes/db.php";
    require_once "includes/utils.php";

    checkGet();
    checkPost();

    function checkGet() {
        if (!isset($_GET["name"]) || !getUserID($_GET["name"])) {
            headto("home.php");
        }
    }

    function checkPost() {
        if (isset($_POST["backtohome"])) {
            headto("home.php");
        }
        elseif (isset($_POST["deletepost"])) {
            deletePost($_POST["deletepost"]);
        }
        elseif (isset($_POST["edituser"])) {
            headto("edituser.php");
        }

        if (!empty($_POST)) {
            headto(getProfileLink($_GET["name"]));
        }
    }

    function echoUserPosts() {
        $userid = getUserID($_GET["name"]);
        foreach (getUserPosts($userid) as $post) {
            echo '<h2>' . clean($post['title']) . '</h2>';
            if ($userid === $_SESSION['loggedinUserID']) {
                echo '<form method="post"> <button type="submit" name="deletepost" value="' . $post['id'] . '">Delete   </button> </form>';
            }
            echo '<p>Posted on ' . $post['created_at'] . '</p>';
            echo '<textarea readonly rows="20" cols="100">' . clean($post['code']) . '</textarea>';
        }
    }

    function echoEditAccountButton() {
        if (getUserID($_GET["name"]) === $_SESSION['loggedinUserID']) {
            echo '<form method="post"><button type="submit" name="edituser">Edit Account</button></form>';
        }
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
        <h2>User: <?=clean(getProperUsername($_GET["name"]))?></h2>
        <?php echoEditAccountButton() ?>    
        <hr>
        <h2>Posts:</h2>
        <?php echoUserPosts() ?>
    </body> 
</html>