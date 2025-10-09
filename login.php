<?php
    session_start();
    require_once 'includes/db.php'; 
    require_once 'includes/utils.php';

    checkIfLoggedIn();
    checkPost();
    displayMessage();

    function checkIfLoggedIn() {
        if (isset($_SESSION["loggedinUserID"])) {
            headto("home.php");
        }
    }
    
    function checkPost() {
        if (isset($_POST['login'])) {
            login($_POST['username'], $_POST['password']);
        }
        elseif (isset($_POST['signup'])) {
            signup($_POST['username'], $_POST['password'], $_POST['confirmPassword']);
        }
        clearPosts();
    }  

    function login($username, $password) {
        $username = trim($username);
        $password = trim($password);

        if (password_verify($password, getHashedPassword($username))) {
            $_SESSION["loggedinUserID"] = getUserID($username);
            headto("home.php");
        }
        else {
            $_SESSION['popupMessage'] = "Invalid login!";
        }
    }

    function signup($username, $password, $confirmPassword) {
        $username = trim($username);
        $password = trim($password);
        $confirmPassword = trim($confirmPassword);

        if (strlen($username) < 4) {
            $_SESSION['popupMessage'] = "Username must be 4 characters or longer!";
        }
        elseif (strlen($password) < 6) {
            $_SESSION['popupMessage'] = "Password must be 6 characters or longer!";
        }
        elseif (getProperUsername($username)) {
            $_SESSION['popupMessage'] = "Username already used!";
        }
        elseif ($password !== $confirmPassword) {
            $_SESSION['popupMessage'] = "Passwords are not identical!";
        }
        elseif (!password_verify($_POST["accessCode"], '$2y$10$t5mfsu1O74ncn6ABbIl//enngvJQ9wI36vnwgJOi6WdiKXg4GEP6y')) {
            $_SESSION['popupMessage'] = "Incorrect Access Code!";
        }
        elseif (createUser($username, password_hash($password, PASSWORD_DEFAULT))) {
            $_SESSION['popupMessage'] = "Account created successfully!";
        } 
        else {
            $_SESSION['popupMessage'] = "Account creation failed!";
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
        <hr>
        <h2>Log in</h2>
        <br>
        <form method="post">
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password" required>
            <button type="submit" name="login">Log in</button>
        </form>
        <hr> 
        <h2>Register</h2>
        <br>
        <form method="post">
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password" required>
            <input type="password" placeholder="Confirm Password" name="confirmPassword" required>
            <br>
            <input type="password" placeholder="Access Code" name="accessCode" required>
            <button type="submit" name="signup">Create Account</button>
        </form>
    </body>
</html>