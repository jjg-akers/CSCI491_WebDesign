<?php
    session_start();
require_once 'functions.php';
    
    
$result_array = array();
 

// from members
    if (isset($_GET['city']) && isset($_GET['state'])){
       // echo "isset city and state = true";
        $city = sanitizeString($_GET['city']);
        // make sure first letter is uppercase
        $city = ucfirst($city);
        $state = sanitizeString($_GET['state']);
        $query = "SELECT * FROM bookStores WHERE city='$city' and state='$state'";
        $result = queryMysql($query);
        // check if no results return (if there isn't a store in there city)
        if ($result->num_rows < 1){
            // change query to search by state only
            $query = "SELECT * FROM bookStores WHERE state='$state'";
            $result = queryMysql($query);
        }
    } else if (isset($_GET['state'])){
       // echo "only state isset = true";
        $state = sanitizeString($_GET['state']);
        $query = "SELECT * FROM bookStores WHERE state='$state'";
        $result = queryMysql($query);
    } else {
        $query = "SELECT * FROM bookStores";
        $result = queryMysql($query);
       // echo "isset = false";
    }
    


    //$query  = "SELECT * FROM messages WHERE recip='$view' and time < '$time' ORDER BY time DESC LIMIT 10";
//    if ($view == $user) {
//        $query = "SELECT * FROM messages INNER JOIN friends ON messages.auth = friends.user WHERE friend = '$view' and time < '$time' ORDER BY time DESC LIMIT 5";
//    } else {
//        $query  = "SELECT * FROM messages WHERE recip='$view' and time < '$time' ORDER BY time DESC LIMIT 5";
//
//    }

    $num    = $result->num_rows;
    
        for ($j = 0 ; $j < $num ; ++$j)
        {
          $row = $result->fetch_array(MYSQLI_ASSOC);

            // save the time
            //if ($messageDate != NULL){
            //$_SESSION["messageDate"] = $row['time'];
            //echo "<br>";
            //echo $row['time'];
            array_push($result_array, $row);
            
            //echo $_SESSION['messageDate'];
        }

/* If there are results from database push to result array */
echo json_encode($result_array);

?>
