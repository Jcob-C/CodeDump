<?php
    const host = "localhost";
    const user = "root";
    const pass = "";
    const dbname = "codedump";

    function getConnection() {
        return mysqli_connect(host, user, pass, dbname);
    }
?>