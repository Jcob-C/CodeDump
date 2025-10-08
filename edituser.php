<?php
    session_start();
    require "auth/login_block.php";
    require "auth/update_last_active.php";
    require_once "includes/db.php";
    require_once "includes/utils.php";

    checkPost();
    displayMessage();

    function checkPost() {
        if (isset($_POST['changeName'])) {
            changeUsername($_POST['username']);
        }
        elseif (isset($_POST['changePass'])) {
            changePassword($_POST['newPassword'], $_POST['confirmNewPassword']);
        }   
        elseif (isset($_POST['backtoprofile'])) {
            headto(getProfileLink(getUsername($_SESSION['loggedinUserID'])));
        }
        clearPosts();
    }

    function changeUsername($newUsername) {
        if (strlen($newUsername) < 4) {
            $_SESSION['popupMessage'] = "Username must be 4 characters or longer!";
        }
        elseif (getProperUsername($newUsername)) {
            $_SESSION['popupMessage'] = "Username already used!";
        }
        elseif (updateUsername($_SESSION['loggedinUserID'], $newUsername)) {
            $_SESSION['popupMessage'] = "Username updated!";
        }
        else {
            $_SESSION['popupMessage'] = "Username update failed!";
        }
    }

    function changePassword($newPassword, $confirmNewPassword) {
        if (strlen($newPassword) < 6) {
            $_SESSION['popupMessage'] = "Password must be 6 characters or longer!";
        }
        elseif ($newPassword !== $confirmNewPassword) {
            $_SESSION['popupMessage'] = "Passwords are not identical!";
        }
        elseif (updatePassword($_SESSION['loggedinUserID'], $newPassword)) {
            $_SESSION['popupMessage'] = "Password updated!";
        }
        else {
            $_SESSION['popupMessage'] = "Password update failed!";
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
            <button type="submit" name="backtoprofile">Back</button>
        </form> 
        <hr>
        <form method="post">
            <input type="text" name="username" value="<?= clean(getUsername($_SESSION['loggedinUserID'])) ?>" required>
            <button type="submit" name="changeName">Change Username</button>
        </form>
        <hr>
        <form method="post">
            <input type="password" name="newPassword" placeholder="New Password" required>
            <input type="password" name="confirmNewPassword" placeholder="Confirm New Password" required>
            <button type="submit" name="changePass">Change Password</button>
        </form>
    </body>
</html>