<?php
$dbhost  = 'localhost';

$dbname  = 'db04';   // Modify these...
$dbuser  = 'user04';   // ...variables according
$dbpass  = '04cowp';   // ...to your installation


$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) 
    die("Fatal Error 1");

function createTable($name, $query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query) {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die("Fatal Error 2");
    return $result;
}

function destroySession() {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}

function sanitizeString($var){
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    if (get_magic_quotes_gpc())
        $var = stripslashes($var);
    return $connection->real_escape_string($var);
}

function showProfile($user) {
    if (file_exists("userpics/$user.jpg"))
        echo "<img class='userpic' src='userpics/$user.jpg'>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
        echo "<div id='profilePreview'>";
        echo "Currently Reading: " . $row['currentBookAuthor'] . "<br>";
        echo "Book Goal: " . $row['bookGoal'] . "<br>";
        echo "Your Store: " . $row['yourStore'] . "<br>";
        echo "Store URL: " . $row['storeURL'];
        echo "</div>";
    }
    else echo "<p>Nothing to see here, yet</p><br>";
}
?>
