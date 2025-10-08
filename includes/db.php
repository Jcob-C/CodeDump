<?php
    require_once "config/db_conn.php";

    date_default_timezone_set('Asia/Manila');

    function getHashedPassword($username) {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ? LIMIT 1");
        
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $hashedPassword = null;

        if ($row = $result->fetch_assoc()) {
            $hashedPassword = $row['password'];
        }

        $stmt->close();
        $conn->close();

        return $hashedPassword;
    }

    function getProperUsername($username) {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ? LIMIT 1");
        
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $output = null;

        if ($row = $result->fetch_assoc()) {
            $output= $row['username'];
        }

        $stmt->close();
        $conn->close();

        return $output;
    }

    function getUsername($id) {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ? LIMIT 1");
        
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $output = null;

        if ($row = $result->fetch_assoc()) {
            $output= $row['username'];
        }

        $stmt->close();
        $conn->close();

        return $output;
    }

    function getUserID($username) {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $output = null;

        if ($row = $result->fetch_assoc()) {
            $output= $row['id'];
        }

        $stmt->close();
        $conn->close();

        return $output;
    }

    function createUser($username, $hashedPassword) {
        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashedPassword);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    function getOnlineUsers() {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT username FROM users WHERE last_active > NOW() - INTERVAL 5 MINUTE");
        $stmt->execute();

        $result = $stmt->get_result();
        $output = [];

        while ($row = $result->fetch_assoc()) {
            $output[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $output;
    }

    function getLatestPosts() {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT user_id, title, code, created_at FROM posts ORDER BY id DESC LIMIT 10");
        $stmt->execute();

        $result = $stmt->get_result();
        $output = [];

        while ($row = $result->fetch_assoc()) {
            $output[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $output;
    }

    function getUserPosts($userid) {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT id, user_id, title, code, created_at FROM posts WHERE user_id = ? ORDER BY id DESC");
        $stmt->bind_param("i", $userid);
        $stmt->execute();

        $result = $stmt->get_result();
        $output = [];

        while ($row = $result->fetch_assoc()) {
            $output[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $output;
    }

    function createNewPost($userid, $title, $code) {
        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, code, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userid, $title, $code, date('Y-m-d H:i:s'));
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function deletePost($postID) {
        $conn = getConnection();
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
    
    function updateLastActive($userid) {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE users SET last_active = NOW() WHERE id = ?");
        $stmt->bind_param("i", $userid);
        $output = $stmt->execute();

        $stmt->close();
        $conn->close(); 

        return $output;
    }

    function updateUsername($userid, $newUsername) {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $newUsername, $userid);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close(); 
        return $result;
    }

    function updatePassword($userid, $newPassword) {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", password_hash($newPassword, PASSWORD_DEFAULT), $userid);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close(); 
        return $result;
    }
?>