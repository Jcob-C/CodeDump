<?php
    session_start();
    require "auth/login_block.php";
    require "auth/update_last_active.php";
    require_once "includes/db.php";
    require_once 'includes/utils.php';

    checkPost();

    function checkPost() {
        if (isset($_POST["logout"])) {
            logout();
        }
        elseif (isset($_POST["createpost"])) {
            headto('post.php');
        } 
        clearPosts();
    }

    function logout() {
        session_unset();
        session_destroy();
    }

    function echoOnlineUsers() {
        $usercount = 0;
        foreach (getOnlineUsers() as $user) {
            if ($user['username'] != getUsername($_SESSION['loggedinUserID'])) {
                $usercount++;
                echo '<h3> <a href="' 
                . getProfileLink($user['username']) . '">' 
                . clean($user['username']) . '</a></h3>';
            }
        }
        if ($usercount <= 0) {
            echo "<h3>...</h3>";
            return;
        }
    }

    function echoLatestPosts() {
        foreach (getLatestPosts() as $post) {
            $username = getUsername($post['user_id']);
            echo '<br> <h2>' . clean($post['title']) . '</h2>';
            echo '<p>Posted by <a href="' 
            . getProfileLink(clean($username)) . '">' 
            . clean($username) . '</a> on ' . $post['created_at'] . '</p>';
            echo '<textarea readonly rows="20" cols="100">' 
            . clean($post['code']) . '</textarea>';
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
        <h1>Welcome to CodeDump, 
            <a href="<?=getProfileLink(clean(getUsername($_SESSION['loggedinUserID'])))?>">
                <?=clean(getUsername($_SESSION['loggedinUserID']))?></a>!
        </h1>
        <form method="post">
            <button type="submit" name="logout">Log out</button>
        </form>
        <hr>
        <h2>Currently Online</h2>
        <?php echoOnlineUsers() ?>
        <hr>
        <h2>Latest Posts</h2>
        <form method="post">
            <button type="submit" name="createpost">New Post</button>
        </form>
        <?php echoLatestPosts() ?>  
    </body>
</html>