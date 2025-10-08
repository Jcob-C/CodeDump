<?php
    session_start();

    if (isset($_SESSION["authorized"]) || (isset($_POST["password"]) && password_verify($_POST["password"], '$2y$10$t5mfsu1O74ncn6ABbIl//enngvJQ9wI36vnwgJOi6WdiKXg4GEP6y'))) {
        $_SESSION["authorized"] = true;
        header("Location: login.php");
        exit;
    }
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/styles.css">
    </head>
    <body>
        <form method="post">
            <br>
            <h1>CodeDump</h1>
            <hr> 
            <br>
            <input type="password" name="password" placeholder="Access Code" required>
            <br> 
            <br>
            <button type="submit">Enter</button>
            <br> 
            <br> 
            <hr>
        </form>
    </body>
</html>