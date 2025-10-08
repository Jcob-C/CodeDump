<?php
    function clearPosts() {
        if (!empty($_POST)) {
            headto($_SERVER["PHP_SELF"]);
        }
    }

    function headto($location) {
        header('Location: ' . $location);
        exit;
    }

    function displayMessage() {
        if (isset($_SESSION['popupMessage'])) {
            echo '<h1 style="color: #ff0000ff;">'. $_SESSION['popupMessage'] . '</h1><hr>';
            unset($_SESSION['popupMessage']);
        }
    }

    function getProfileLink($username) {
        return 'user.php?name=' . $username;
    }

    function clean($text) {
        return htmlspecialchars($text);
    }
?>