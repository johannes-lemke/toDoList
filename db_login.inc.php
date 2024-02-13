<?php

    function db_login($database)
    {
        $server = "localhost";
        $user = "root";
        $password = "";
        $port = "3307";

        $mysqli = new mysqli($server, $user, $password, $database, $port);
        if ($mysqli->connect_errno) {
            echo "Fehler beim Zugriff auf Mysql: ({$mysqli->connect_error}) "
                . $mysqli->connect_error;
            exit();
        }

        $mysqli->set_charset("utf8");
        return $mysqli;
    }
    
?>
