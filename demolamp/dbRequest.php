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
//    echo "<div>";
//    echo "view set ";
//    echo $_GET['view'];
//    echo "</div>";

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

?>
