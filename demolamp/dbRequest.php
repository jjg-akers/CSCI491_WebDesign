<?php
    session_start();
require_once 'functions.php';
    
// from header

if (isset($_SESSION['user'])) {
    //echo "true";
    $user     = $_SESSION['user'];
    //echo $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = "Logged in as: $user";
}
else {
    $loggedin = FALSE;
    //echo "false";
}
    
$result_array = array();
 
$time = $_SESSION['messageDate'];
    //echo "\ntime";
    //echo "<br>\r\nthe latest time: ";
    //echo $time;
    //echo $_SESSION['messageDate'];
    
    
// from members
    if (isset($_GET['view'])){
        //echo "isset true";
        $view = sanitizeString($_GET['view']);
    }
    else {
        //echo "isset false";
        $view = $user;
    }


    $query  = "SELECT * FROM messages WHERE recip='$view' and time < '$time' ORDER BY time DESC LIMIT 10";
    //$query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC LIMIT 10";
    $result = queryMysql($query);
    $num    = $result->num_rows;
    
        for ($j = 0 ; $j < $num ; ++$j)
        {
          $row = $result->fetch_array(MYSQLI_ASSOC);
            $_SESSION["messageDate"] = $row['time'];
            
            $row['time'] = date('M jS \'y g:ia:', $row['time']);
            
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
    
    
    //if ($result->num_rows > 0) {
//    while($row = $result->fetch_assoc()) {
//        echo $row;
//        array_push($result_array, $row);
//    }
//}
///* send a JSON encded array to client */
//array_push($result_array, $row);
    
    
    
    
    
//function destroySession() {
//    $_SESSION=array();
//
//    if (session_id() != "" || isset($_COOKIE[session_name()]))
//        setcookie(session_name(), '', time()-2592000, '/');
//
//    session_destroy();
//}
//
//function sanitizeString($var){
//    global $connection;
//    $var = strip_tags($var);
//    $var = htmlentities($var);
//    if (get_magic_quotes_gpc())
//        $var = stripslashes($var);
//    return $connection->real_escape_string($var);
//}
//
//function showProfile($user) {
//    if (file_exists("userpics/$user.jpg"))
//        echo "<img class='userpic' src='userpics/$user.jpg'>";
//
//    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
//
//    if ($result->num_rows) {
//        $row = $result->fetch_array(MYSQLI_ASSOC);
//        echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
//    }
//    else echo "<p>Nothing to see here, yet</p><br>";
//}
?>
