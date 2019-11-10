<?php
$dbhost  = 'localhost';

$dbname  = 'db04';   // Modify these...
$dbuser  = 'user04';   // ...variables according
$dbpass  = '04cowp';   // ...to your installation

require_once 'functions.php';

$query  = "SELECT * FROM messages WHERE recip='$view' and time > $_SESSION['messageDate'] ORDER BY time DESC LIMIT 10";
$result = queryMysql($query);



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
