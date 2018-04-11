<?php
    define('SERVER_NAME', 'localhost');
    define('DB_USERNAME', 'admin');
    define('DB_PASSWORD', 'admin');
    define('DB_NAME', 'messManagement');

    $db_connect = new mysqli(constant('SERVER_NAME'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'));

    function check_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
