<?php
    define('SERVER_NAME', 'localhost');
    define('DB_USERNAME', 'admin');
    define('DB_PASSWORD', 'admin');
    define('DB_NAME', 'messManagement');

    $db_connect = new mysqli(constant('SERVER_NAME'), constant('DB_USERNAME'), constant('DB_PASSWORD'));

    $sql = "CREATE DATABASE IF NOT EXISTS messManagement";

    if ($db_connect->query($sql) === TRUE) {
        echo "Database Created Successfully";
    } else {
        echo "Error!";
    }

    $db_connect->close();

    $db_connect = new mysqli(constant('SERVER_NAME'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'));

    $sql_hall_login = "CREATE TABLE IF NOT EXISTS HallLogin (
        hallName CHAR(10),
        password TEXT NOT NULL,
        CONSTRAINT HallKey PRIMARY KEY ( hallName )
    )";

    $sql_student_info = "CREATE TABLE IF NOT EXISTS StudentInfo (
        rollNo INTEGER,
        name CHAR(100) NOT NULL,
        hallName CHAR(10) NOT NULL,
        roomNo CHAR(10) NOT NULL,
        bill INTEGER NOT NULL,
        PRIMARY KEY (rollNo),
        FOREIGN KEY (hallName) REFERENCES HallLogin(hallName) ON DELETE CASCADE
    )";

    $sql_extras = "CREATE TABLE IF NOT EXISTS Extras(
        hallName CHAR(10) NOT NULL,
        day ENUM('MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY') NOT NULL,
        meal ENUM('BREAKFAST', 'LUNCH', 'DINNER') NOT NULL,
        extraItem CHAR(50) NOT NULL,
        price INTEGER NOT NULL,
        PRIMARY KEY (hallName, day, extraItem),
        FOREIGN KEY (hallName) REFERENCES HallLogin(hallName) ON DELETE CASCADE
    )";

    $sql_history = "CREATE TABLE IF NOT EXISTS History(
        rollNo INTEGER NOT NULL,
        onDate DATE NOT NULL,
        atTime TIME NOT NULL,
        item CHAR(50) NOT NULL,
        quantity INTEGER NOT NULL,
        price INTEGER NOT NULL
    )";

    try {
        $db_connect->query($sql_hall_login);
        $db_connect->query($sql_student_info);
        $db_connect->query($sql_extras);
        $db_connect->query($sql_history);
    } catch (Exception $e) {
        echo "Failed to create tables";
    }


    $db_connect->close();
?>
