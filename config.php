<?php
    define('SERVER_NAME', '172.24.33.186');
    define('DB_USERNAME', 'admin');
    define('DB_PASSWORD', 'admin');
    define('DB_NAME', 'messManagement');

    $ZERO = 0;

    date_default_timezone_set('Asia/Kolkata');

    $db_connect = new mysqli(constant('SERVER_NAME'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'));

    function check_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function is_today($a_day){
        if(strtoupper($a_day) == strtoupper(date("l",time()))){
            return "checked";
        } else {
            return "";
        }
    }

    function is_current_meal($a_meal){
        $time_now = (int)date("G",time());
        
        $meal = 'DINNER';

        if($time_now <= 11){
            $meal = 'BREAKFAST';
        } else if(11 < $time_now && $time_now <= 18){
            $meal = 'LUNCH';
        }

        if(strtoupper($a_meal) == $meal){
            return "checked";
        } else {
            return "";
        }
    }
?>
